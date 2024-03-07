<?php

namespace App\Http\Requests\Web\Customer;

use Illuminate\Foundation\Http\FormRequest;

class DecreaseCartItmQtyRequest extends FormRequest
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
            'qty'=> ['required','integer', 'min:1'],
            'product_id'=> ['required','integer', 'exists:products,id'] ,
        ];
    }
}
