<?php

namespace App\Http\Requests\Web\Customer;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddProductToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected $stopOnFirstFailure = true;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
             'qty' => [
                 'required',
                 'integer',
                 'gt:0',
                 /**  validate that there is enough qty in stock */
                 function (string $attribute, mixed $value, Closure $fail) {
                     $product_id = $this->get('product_id');
                     if(Auth::check()){
                         $product = Product::query()
                             ->where('id', $product_id)
                             ->with('cartItem')
                             ->first();
                         if($product->cartItem->first()?->qty + $value > $product->stock){
                             $fail('validation.no_enough_items_in_stock')->translate();
                         }
                     }else{
                         $cart_qty = Session::get("user_cart_products_ids.{$product_id}");
                         $product = Product::find($product_id);
                         if($cart_qty + $value > $product->stock){
                              $fail('validation.no_enough_items_in_stock')->translate();
                         }
                     }
                 },
             ]
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            [
                'qty'=>'quantity'
            ]
        );
    }
}
