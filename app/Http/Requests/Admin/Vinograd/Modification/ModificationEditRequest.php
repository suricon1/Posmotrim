<?php

namespace App\Http\Requests\Admin\Vinograd\Modification;

use Illuminate\Foundation\Http\FormRequest;

class ModificationEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'modification_id' => 'required|integer|exists:vinograd_product_modifications,id',
            'price'      => ['required', 'integer', 'regex:/^[1-9]\d*$/'],
            'correct'   => 'integer',
//            'quantity'   => ['required', 'integer', 'regex:/^[0-9]\d*$/'],
        ];
    }
}
