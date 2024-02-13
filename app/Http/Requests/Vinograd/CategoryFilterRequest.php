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
            'filters.selection.*' => [
                'integer',
                'regex:/^[1-9][0-9]*$/iu',
                'exists:vinograd_selections,id'
            ],
            'filters.country.*' => [
                'integer',
                'regex:/^[1-9][0-9]*$/iu',
                'exists:vinograd_countrys,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            //'selection.required_without' => 'Необходимо выбрать селекционера',
            'filters.selection.*.integer' => 'Не чуди',
            'filters.selection.*.regex' => 'Не чуди',
            'filters.selection.*.exists' => 'Не чуди',
            //'country.required_without' => 'Необходимо выбрать страну селекции',
            'filters.country.*.integer' => 'Не чуди',
            'filters.country.*.regex' => 'Не чуди',
            'filters.country.*.exists' => 'Не чуди'
        ];
    }

}
