<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class RelatedProductsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'related_products';

    /**
     * @param Model $ownerRecord
     * @param string $pageClass
     * @return string
     */

    public function form(Form $form): Form
    {
       return ProductResource::form($form);
    }

    public function getResource()
    {
        return ProductResource::class;
    }
    public function table(Table $table): Table
    {
        $active_local = $table->getLivewire()->getActiveTableLocale() ?? $this->getResource()::getDefaultTranslatableLocale();
        $limit = Product::RELATED_PRODUCTS_LIMIT;
        
        return $table
            ->description("Only first {$limit} products will be shown in the PDP")
            // I used recordTitle(...) function like this way instead of the default recordTitleAttribute(...) cause
            // when using the recordTitleAttribute(...) the category name is displayed as json and the translation of the name is not handed properly.
            // May be it is a bug with Filament.
            ->recordTitle(fn (Product $record): string =>  ($record->getTranslation('name', $active_local)))
            ->inverseRelationship('related_to_products')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('brand')->searchable(),
                Tables\Columns\TextColumn::make('short_description')->html()->limit(50)->searchable(),
                SpatieMediaLibraryImageColumn::make('Image')->collection('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function($data) {
                        // Todo: Duplicated code in CreateProduct Class
                        $data['owner_type'] = \Auth::user()::class;
                        $data['owner_id'] = \Auth::user()->id;
                        return $data;
                }),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    /*** @param Builder $query*/
                    ->recordSelectOptionsQuery(function ($query, $livewire){
                        // The following code was written to handel {2} things:
                        // 1. Hide the current product form the products select list - not to be select as a related to itself-
                        // 2. Prevent duplication when attaching products to be related to the current product.
                        //      Please note that this (num. 2) should be handled by Filament by default but there is some issue - that I am not able to catch - that prevent Filament form handling it.
                        //      Probably this is an issue with the relationship definition.

                        /*** @var Collection $attached_products */
                        $attached_products = $livewire->ownerRecord->related_products()
                            ->select('products.id')->get()->pluck('id')->toArray();

                        return $query
                            ->where('products.id','!=', $livewire->ownerRecord->id)
                            ->whereNotIn('products.id', $attached_products);
                    }),

                Tables\Actions\LocaleSwitcher::make(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
