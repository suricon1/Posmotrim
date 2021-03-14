<?php

namespace App\Http\Requests\Admin\Vinograd\Modification;

use Illuminate\Foundation\Http\FormRequest;

class ModificationDeleteRequest extends FormRequest
{
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
            'modification_id' => 'required|integer|exists:vinograd_product_modifications,id'
        ];
    }
}