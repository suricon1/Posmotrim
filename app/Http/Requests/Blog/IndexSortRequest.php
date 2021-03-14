<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexSortRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'field' => [
                'nullable',
                Rule::in(['date_add', 'name', 'view']),
            ],
            'order_by' => [
                'nullable',
                Rule::in(['desc', 'asc']),
            ]
        ];
    }
}
