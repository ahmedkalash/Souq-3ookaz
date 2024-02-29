<?php

namespace App\Http\Requests\Web\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrUpdateProductReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rate'=>['required','numeric','integer','min:0','max:5'],
            'comment'=>['nullable','string','max:10000'],
            'product_id' => ['required','exists:products,id'],
            'user_id' => ['required', 'exists:users,id']
        ];
    }

    public function validationData()
    {
        return array_merge(
            [
                'user_id' => Auth::id(),
                'product_id'=>$this->route('product')->id
            ],
            parent::validationData()
        );
    }

}
