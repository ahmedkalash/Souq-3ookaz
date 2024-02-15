<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\DeleteAction::make()
                /*->before(app(static::getResource())::beforeDelete())*/,
            Actions\LocaleSwitcher::make(),

        ];
    }




}
