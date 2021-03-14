<?php

namespace App\Http\Requests\Admin\Vinograd\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>'required|string|max:255',
            'content'   =>  'required|string',
            'slug' =>  [
                'nullable',
                'string',
                Rule::unique('vinograd_delivery_methods')->ignore($this->delivery),
            ]
        ];
    }

}
