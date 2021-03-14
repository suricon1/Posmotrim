<?php

namespace App\Http\Requests\Vinograd;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddCommentRequest extends FormRequest
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
            'subjects' =>	[
                'nullable',
                //'size:0',
                Rule::in('')
            ],
            'text'	     => 'required',
            'product_id' => 'nullable|integer|exists:vinograd_products,id',
            'post_id'    => 'nullable|integer|exists:vinograd_posts,id',
            'parent_id'  => 'nullable|integer|exists:vinograd_comments,id',
            'name'	     => 'sometimes|required|max:20',
            'user_id'    => 'sometimes|required|integer',
            'email'      => 'sometimes|required|email'
        ];
    }

    public function messages()
    {
        return [
            'subject.in' => 'Ботам здесь не место'
        ];
    }
}
