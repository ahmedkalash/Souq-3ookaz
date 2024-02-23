<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Filament\Resources\ProductResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class RelatedProductsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'related_products';

    public function form(Form $form): Form
    {
       return ProductResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->allowDuplicates(false)
            ->recordTitleAttribute('name')
            ->inverseRelationship('related_to_products')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function($data) {
                    // Todo Duplicate code in CreateProduct Class
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
            ])
            ->actions([
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
