<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:dns|max:255|unique:users',
            'password' => 'required|confirmed|string|min:6',
            'subject'	=>	[
                'nullable',
                Rule::in('')
            ]
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Пароли не совпадают'
        ];
    }
}
