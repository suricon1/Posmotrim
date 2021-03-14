<?php

namespace App\Http\Requests\Vinograd;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'	  => 'required|min:3|max:30',
            'email'	  => 'required|email',
            'phone'   => [
                'nullable',
                'regex:/^[\+\(\)0-9 _-]{5,}$/iu'
            ],
            'message' => 'required|string',
            'subject' => [
                'nullable',
                //'size:0',
                Rule::in('')
            ]
        ];
    }
}
