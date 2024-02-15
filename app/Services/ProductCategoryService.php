<?php

namespace App\Services;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;


class ProductCategoryService
{

    public function __construct()
    {

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    public function create(ProductCategory|array $productCategory): ProductCategory | Validator
    {
        // validate
        // create
        // return the result { the new newly created model or the validation errors }

        $validationRules = $this->createValidationRules();


        if ($productCategory instanceof ProductCategory){
            $validationData = $productCategory->toArray();
        }else{
            $validationData = $productCategory;
        }

        $validationResult = \Illuminate\Support\Facades\Validator::make($validationData, $validationRules);
        if ($validationResult->fails()){
            return $validationResult;
        }

        if(is_array($productCategory)){
            $newModel  =ProductCategory::create($productCategory);
        }elseif ($productCategory instanceof ProductCategory){
            $newModel =  $productCategory->save();
        }

        return $newModel;
    }

    public function createValidationRules(){
        return [
            'name'=>['required','string',],
            'parent_id'=>['nullable','numeric', 'exists:product_categories,id'],
        ];
    }



    public function show($id)
    {
        return ProductCategory::find($id);
    }




    public function update(ProductCategory|array $productCategory)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

}
