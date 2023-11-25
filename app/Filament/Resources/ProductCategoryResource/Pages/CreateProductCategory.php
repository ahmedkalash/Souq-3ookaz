<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;


class CreateProductCategory extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ProductCategoryResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    public function form(Form $form): Form
    {
        return static::getResource()::sharedForm($form,  $this->getActiveFormsLocale()?? $this->getResource()::getDefaultTranslatableLocale());
    }


    protected function handleRecordCreation(array $data): Model
    {
        // handel prevent cycle db exception and send error msg to the user

        try {
            $res =  parent::handleRecordCreation($data);
        }catch (\Throwable $e){
            if ($e->getCode() == static::getResource()::PREVENT_CYCLE_ERROR_CODE){
                Notification::make()
                    ->danger()
                    ->title("Cannot create cycle in category hierarchy")
                    ->send();
                $this->halt();
            }else{
                throw $e;
            }
        }

        return $res;


    }


}
