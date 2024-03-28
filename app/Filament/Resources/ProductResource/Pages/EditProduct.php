<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Brick\Math\BigDecimal;
use Cknow\Money\Money;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

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


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = parent::mutateFormDataBeforeFill($data);
        if(isset($data['price'])) {
            $data['price'] = bcdiv($data['price']['amount'], 100, 2);
        }
        if( isset($data['special_price_type']) &&
            $data['special_price_type'] == 'fixed' &&
            isset($data['special_price'])
            ) {
            $data['special_price'] = bcdiv($data['special_price'], 100, 2);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if(isset($data['price'])) {
            $data['price'] = new Money(bcmul($data['price'], 100), "USD");
        }
        if( isset($data['special_price_type']) &&
            $data['special_price_type'] == 'fixed' &&
            isset($data['special_price'])
        ) {
            $data['special_price'] = bcmul($data['special_price'], 100);
        }

        return $data;
    }

}
