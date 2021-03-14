<?php

namespace App\Http\Requests\Vinograd;

use App\Models\Vinograd\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SortPostsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ripening_by' => [
                'nullable',
                'integer',
                Rule::in(array_keys(Category::$sortRipeningProducts))
            ],
            'order_by' => [
                'nullable',
                'string',
                Rule::in(array_keys(Category::getSortArr()))
            ]
        ];
    }

    public function messages()
    {
        return [
            'ripening_by.integer' => 'Системная ошибка. Попробуйте повторить попытку, пожалуйста.',
            'ripening_by.in' => 'Системная ошибка. Попробуйте повторить попытку, пожалуйста.',
            'order_by.string' => 'Системная ошибка. Попробуйте повторить попытку, пожалуйста.',
            'order_by.in' => 'Системная ошибка. Попробуйте повторить попытку, пожалуйста.'
        ];
    }
}
