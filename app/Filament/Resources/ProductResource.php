<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use PHPStan\Parser\RichParser;

class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->string()
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->required()
                            ->string()
                            ->unique(static::getModel()::tableName(), 'id' )
                            ->mutateDehydratedStateUsing(fn (string $state) => Str::slug($state))->readOnly(),

                        TextInput::make('brand')
                            ->required()
                            ->string(),

                        TextInput::make('price')
                            ->required()
                            ->numeric(),

                    ])
                    ->columns(),


                Forms\Components\Section::make('Product Description')
                    ->schema([
                        Forms\Components\Section::make('Description')
                            ->schema([
                                Forms\Components\RichEditor::make('description') ,
                            ]),

                    ]) ,



                Forms\Components\Section::make('Product Images')
                    ->schema([

                        SpatieMediaLibraryFileUpload::make('images')
                            ->required()
                            ->multiple()
                            ->collection('gallery')
                            ->columns(1)
                            ->imageEditor()
                            ->openable()
                            ->downloadable(),


                        SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->required()
                            ->collection('thumbnail')
                            ->imageEditor()
                            ->openable()
                            ->downloadable(),

                ])->columns(5),



//
//                Select::make('categories')
//                    ->multiple()
//                    ->relationship('categories', 'name')
//                    ->getOptionLabelFromRecordUsing(function (Model $record, $livewire){
//                        return $record->getTranslation('name', $livewire->activeLocale) . ' -- level ' /*. $record->depth*/;
//                    })
//                    ->preload()
//                    ->required(),
//



            ]) ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->rowIndex(),

                TextColumn::make('name')->searchable()->sortable()->limit(20)->wrap(),

                TextColumn::make('slug')->searchable()->sortable()->limit(20)->wrap(),

                TextColumn::make('brand')->searchable()->sortable()->limit(20)->wrap(),

                TextColumn::make('price')->searchable()->sortable()->limit(20)->wrap(),

                TextColumn::make('owner_id')->searchable()->sortable()->limit(20)->wrap(),

                TextColumn::make('description')->searchable()->sortable()->limit(20)->wrap()->html(),

                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('thumbnail'),

            ])

            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make(),

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttributesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
