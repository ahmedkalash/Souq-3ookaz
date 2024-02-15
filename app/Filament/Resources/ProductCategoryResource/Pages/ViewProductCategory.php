<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

/***
 * @property ProductCategoryResource $resource
 * */

class ViewProductCategory extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }


    public function form(Form $form): Form
    {
        return static::getResource()::sharedForm($form,  $this->getActiveFormsLocale() ?? $this->getResource()::getTranslatableLocales());
    }

}
