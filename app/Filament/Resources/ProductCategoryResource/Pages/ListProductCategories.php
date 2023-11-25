<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListProductCategories extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->badge($this->getModel()::count()),
            'root' => Tab::make()
                ->badge( $this->getModel()::whereNull('parent_id')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('parent_id')),
            ];
    }


    public function table(Table $table): Table
    {
        return  $table
            ->columns([
                TextColumn::make('index')->rowIndex(),
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),

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

            ])

            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(static::getResource()::beforeDelete()),
                ViewAction::make(),

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->striped();

    }



}
