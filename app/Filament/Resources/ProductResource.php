<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

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
                            ->maxLength(255)
                            ->required()
                            ->string()
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->maxLength(255)
                            ->required()
                            ->string()
                            ->unique(ignoreRecord: true)
                            ->mutateDehydratedStateUsing(fn (string $state) => Str::slug($state))->readOnly(),

                        TextInput::make('brand')
                            ->maxLength(255)
                            ->required()
                            ->string(),

                        TextInput::make('type')
                            ->maxLength(255)
                            ->required()
                            ->string(),

                        TextInput::make('sku')
                            ->maxLength(255)
                            ->required()
                            ->string()
                        ->unique(ignoreRecord: true),

                        DateTimePicker::make('mfg')
                            ->label('MFG Date')
                            ->required()
                            ->date(),

                        TextInput::make('stock')
                            ->maxValue(2147483647) // Check against the maximum value for an INT column in MySQL
                            ->required()
                            ->integer(),
                    ])
                    ->columns(),

                Forms\Components\Section::make('Price')
                    ->columns()
                    ->schema([
                        TextInput::make('price')
                            ->maxValue(2147483647) // Check against the maximum value for an INT column in MySQL
                            ->required()
                            ->numeric()
                            ->suffix('$'),

                        Forms\Components\Toggle::make('has_special_price')
                            ->required()
                            ->inline(false)
                            ->live(),

                        Forms\Components\Fieldset::make('Special Price')
                            ->schema([
                                Forms\Components\Select::make('special_price_type')
                                    ->options([
                                        'fixed'=>'Fixed price',
                                        'percentage'=>'Percentage of the original price (%)'
                                    ])
                                    ->required(fn (Get $get) => $get('has_special_price'))
                                    ->in(['fixed', 'percentage'])
                                    ->live(),

                                Forms\Components\TextInput::make('special_price')
                                    ->required(fn (Get $get) => $get('has_special_price'))
                                    ->numeric()
                                    ->regex('/^\d{1,6}(?:\.\d{0,2})?$/')/* up to {6} digits before the dot and up to {2} after it*/
                                    ->suffix(fn(Get $get) => ($get('special_price_type') == 'fixed')? '$':'%'),

                                Forms\Components\DateTimePicker::make('when_special_price_start')
                                    ->required(fn (Get $get) => $get('has_special_price'))
                                    ->before(fn(Get $get) => $get('when_special_price_end')),

                                Forms\Components\DateTimePicker::make('when_special_price_end')
                                    ->required(fn (Get $get) => $get('has_special_price'))
                                    ->after(fn(Get $get) => $get('when_special_price_start')),
                            ])
                            ->disabled(fn (Get $get) => !$get('has_special_price'))
                            ->hidden(fn (Get $get) => !$get('has_special_price') ),
                    ]),

                Forms\Components\Section::make('Product Description')
                    ->schema([
                        Forms\Components\Section::make('Short Description')
                            ->schema([
                                Forms\Components\RichEditor::make('short_description')
                                    ->maxLength(60000)
                                    ->disableToolbarButtons(['attachFiles']),
                            ]),

                        Forms\Components\Section::make('Description')
                            ->schema([
                                Forms\Components\RichEditor::make('description')->maxLength(1000000),
                            ]),

                    ]),

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
            ]);
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
                TextColumn::make('short_description')->searchable()->sortable()->limit(20)->wrap()->html(),
                TextColumn::make('description')->searchable()->sortable()->limit(20)->wrap()->html(),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make()
                    ->slideOver(),

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
            RelationManagers\RelatedProductsRelationManager::class,
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
