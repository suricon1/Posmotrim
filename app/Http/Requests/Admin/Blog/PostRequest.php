<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer|exists:vinograd_blog_category,id',
            'content'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|dimensions:max_width=900,max_height=600|max:500',
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('vinograd_posts')->ignore($this->post)]
        ];
    }
}
