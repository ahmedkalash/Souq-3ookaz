<?php

namespace App\Http\Requests\Web\Customer\Auth;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password'=> [
                'required',
                (new Password(8))
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(5),
            ],
            'password_confirmation'=>'required|string|same:password',
        ];
    }
}
