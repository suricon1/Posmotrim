<?php

namespace App\Http\Requests\Admin\Vinograd\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' =>'required|string|max:255',
            'name' =>'required|string|max:255',
            'content'   =>  'required|string',
            'meta_desc' => 'nullable|string|max:255',
            'meta_key' => 'nullable|string|max:255',
            'slug' =>  [
                'nullable',
                'string',
                Rule::unique('vinograd_pages')->ignore($this->page),
            ]
        ];
    }
}
