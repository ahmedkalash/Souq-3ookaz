<?php

namespace App\Http\Requests\Web\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IncreaseCartItmQtyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'qty'=> ['required','integer', 'min:1'],
            'product_id'=> ['required','integer', 'exists:products,id'] ,
        ];
    }
}
