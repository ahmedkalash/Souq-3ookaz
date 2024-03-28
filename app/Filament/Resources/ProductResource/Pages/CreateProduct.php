<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Cknow\Money\Money;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }


    protected function getRedirectUrl(): string
    {
        $resource = $this->getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        return $resource::getUrl('index');

    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = parent::mutateFormDataBeforeCreate($data);
        $data['owner_type'] = \Auth::user()::class;
        $data['owner_id'] = \Auth::user()->id;

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
