<?php

namespace App\Http\Requests\Admin\Vinograd\Modification;

use Illuminate\Foundation\Http\FormRequest;

class ModificationEditRequest extends FormRequest
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
     * @return array vinograd_product_modifications
     */
    public function rules()
    {
        return [
            'modification_id' => 'required|integer|exists:vinograd_product_modifications,id',
            'price'      => ['required', 'integer', 'regex:/^[1-9]\d*$/'],
            'quantity'   => ['required', 'integer', 'regex:/^[0-9]\d*$/']
        ];
    }
}
