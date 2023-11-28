<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Filament\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ProductCategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = ProductCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public const PREVENT_CYCLE_ERROR_CODE = 45000;


    public static function form(Form $form): Form
    {
        return static::sharedForm($form) ;
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
//            'view' => Pages\ViewProductCategory::route('/{record}'),
        ];
    }



    public static function sharedForm(Form $form){

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
                ->unique(app(static::getModel())->getTable(), 'id' ),

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



    public static function beforeDelete(){
        return
            /*** @var ProductCategory $record*/
            function (Model $record) {
            $record->children()->update([ 'parent_id'=>$record->parent_id]);

            // todo also update the category of the products that belongs to this category
        };
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->tree()  ;
    }


}
