<?php

namespace App\Http\Requests\Admin\Vinograd\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' =>'nullable|string|max:255',
            'name' =>'required|string|max:255',
            'content'   =>  'required|string',
            'ripening'   =>  'required',
            'description'   =>  'nullable|string',
            'category_id'   =>  'required|integer|exists:vinograd_categorys,id',
            'selection_id'   =>  'required|integer|exists:vinograd_selections,id',
            'country_id'   =>  'required|integer|exists:vinograd_countrys,id',
            'meta.*' => 'nullable|string|max:255',
            'image' =>  'nullable|image',
            'gallery.*' => 'nullable|image|max:500',
            'images.*' => 'nullable|image|max:500',
            'slug' =>  [
                'nullable',
                'string',
                Rule::unique('vinograd_products')->ignore($this->product),
            ]
        ];
    }

    public function messages()
    {
        return [
            'selection_id.*' => 'Нужно выбрать имя селекционера из списка!',
            'country_id.*' => 'Нужно выбрать страну селекции из списка!'
        ];
    }
}
