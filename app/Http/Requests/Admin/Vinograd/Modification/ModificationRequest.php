<?php

namespace App\Http\Requests\Admin\Vinograd\Modification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:vinograd_products,id',
            'modification_id'       =>
            [
                'required',
                'integer',
                'exists:vinograd_modifications,id',
                Rule::unique('vinograd_product_modifications', 'modification_id')->where(function ($query) {
                    $query->where('product_id', $this->request->get('product_id'));
                })
            ],
            'price'      => ['required', 'integer', 'regex:/^[1-9]\d*$/'],
            'quantity'   => ['required', 'integer', 'regex:/^[0-9]\d*$/']
        ];
    }

    public function messages()
    {
        return [
            'modification_id.unique' => 'Такая модификация уже есть у этого товара!',
            'product_id.*' => 'Ошибка! Прегрузите станицу и попробуйте снова.'
        ];
    }

    public function  attributes()
    {
        return [
            'price' => '<b>[Цена]</b>',
            'quantity' => '<b>[Колличество]</b>',
            'modification_id' => '<b>[Модификация]</b>',
        ];
    }
}
