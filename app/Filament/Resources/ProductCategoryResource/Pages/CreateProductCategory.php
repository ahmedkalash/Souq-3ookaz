<?php

namespace App\Filament\Resources\ProductCategoryResource\Pages;

use App\Filament\Resources\ProductCategoryResource;
use App\Services\ProductCategoryService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProductCategory extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ProductCategoryResource::class;

    protected $productCategoryService;

    public function __construct( $id = null)
    {
        parent::__construct($id);

        $this->productCategoryService = app(ProductCategoryService::class);

    }

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function handleRecordCreation(array $data): Model
    {
//        dd($data);
        return $this->productCategoryService->create($data);
    }


}
