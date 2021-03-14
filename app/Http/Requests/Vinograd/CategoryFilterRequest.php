<?php

namespace App\Http\Requests\Vinograd;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //'selection' => 'nullable|required_without:country',
            //'country' => 'nullable|required_without:selection',
            'selection.*' => [
                'integer',
                'regex:/^[1-9][0-9]*$/iu'
            ],
            'country.*' => [
                'integer',
                'regex:/^[1-9][0-9]*$/iu'
            ]
        ];
    }

    public function messages()
    {
        return [
            //'selection.required_without' => 'Необходимо выбрать селекционера',
            'selection.*.integer' => 'Не чуди',
            'selection.*.regex' => 'Не чуди',
            //'country.required_without' => 'Необходимо выбрать страну селекции',
            'country.*.integer' => 'Не чуди',
            'country.*.regex' => 'Не чуди'
        ];
    }

}
