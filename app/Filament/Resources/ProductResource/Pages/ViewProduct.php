<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Cknow\Money\Money;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return static::getResource()::form($form);
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
}
