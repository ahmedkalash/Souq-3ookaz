<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\ProductCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoriesRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->string()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->string()
                    ->unique(ProductCategory::tableName(), 'id' ),

                TextInput::make('depth')
                    ->label('level')
                    ->disabled()
                    ->required()
                    ->numeric(),

                Select::make('parent_id')
                    ->label('Parent category')
                    ->relationship(
                        'parent',
                        'name',
                        function (Builder $query, $record){
                            // if we are in a create form
                            if(! $record){
                                return  $query->tree();
                            }
                            // hide the descendants and the category itself from the choices to avoid cycles in the tree
                            $descendantsAndSelf = ProductCategory::find( $record->id)->descendantsAndSelf()->get()->pluck('id')->toArray();
                            return  $query->whereNotIn('id', $descendantsAndSelf)->tree();
                        }
                    )

                    /*** @var ProductCategory $record*/
                    ->getOptionLabelFromRecordUsing(function (Model $record, $livewire){
                        return $record->getTranslation('name', $livewire->activeLocale) . ' -- level ' . $record->depth;
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(
                        fn (Set $set, ?string $state)
                        => $set(
                            'depth',
                            (   is_null($model = ProductCategory::tree()->find($state)) ? 0 : ($model->depth+1)  )
                        )
                    ),

                SpatieMediaLibraryFileUpload::make('image')->required(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
//            ->modifyQueryUsing(fn (Builder $query) => $query->tree())
            ->recordTitleAttribute('name')
            ->columns(
                [
                    TextColumn::make('index')->rowIndex(),

                    TextColumn::make('name')
                        ->searchable()
                        ->sortable()
                        ->limit(20)
                        ->wrap(),

                    TextColumn::make('slug')
                        ->searchable()
                        ->sortable()
                        ->limit(20)
                        ->wrap(),

                    TextColumn::make('parent.name')
                        /*** @param ProductCategory $record */
                        ->formatStateUsing(function (string $state, Model $record){
                            return $record->parent->getTranslation(
                                'name',
                                $this->getActiveFormsLocale() ?? $this->getResource()::getDefaultTranslatableLocale()
                            ) ;
                        } )
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('depth')->label('level')
                        ->searchable()
                        ->sortable(),

                    SpatieMediaLibraryImageColumn::make('image'),
                ]
                 )
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
                Tables\Actions\LocaleSwitcher::make(),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
