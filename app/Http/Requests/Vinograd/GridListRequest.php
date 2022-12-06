<?php

namespace App\Http\Requests\Vinograd;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class GridListRequest extends JsonFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'grid_list' => [
                'required',
                Rule::in(['grid', 'list', 'small_list']),
            ],
            'category' => 'nullable|integer',
            'page' => 'nullable|integer',
            'model' => [
                'nullable',
                Rule::in(['category', 'selection', 'country']),
            ]
        ];
    }

    public function messages()
    {
        return [
            'grid_list.required' => 'Не чуди',
            'grid_list.in' => 'Не чуди',
            'category.integer' => 'Не чуди',
            'page.integer' => 'Не чуди',
            'model.in' => 'Не чуди'
        ];
    }
}
