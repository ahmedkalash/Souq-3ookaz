<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditProductCategory extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {

        return [
             Actions\DeleteAction::make()
                 ->before(app(static::getResource())::beforeDelete()),
            Actions\LocaleSwitcher::make(),

        ];
    }


    public function form(Form $form): Form
    {
        return static::getResource()::sharedForm($form,  $this->getActiveFormsLocale() ?? $this->getResource()::getDefaultTranslatableLocale());
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // handel prevent cycle db exception and send error msg to the user

        try {
            $res =  parent::handleRecordUpdate($record, $data);
        }catch (\Throwable $e){
            if ($e->getCode() == static::getResource()::PREVENT_CYCLE_TRIGGER_ERROR_CODE){
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
