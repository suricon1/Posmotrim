<?php

namespace App\Http\Requests\Admin\Vinograd\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrdersTreckCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:vinograd_orders,id',
            //'track_code' => ['required', 'max:13', 'regex:/^[A-Za-z]{2}[0-9]{9}(BY|by)$/']
            'track_code' => 'required|max:13'
        ];
    }

//    public function messages()
//    {
//        return [
//            'track_code.regex' => 'Код должен иметь формат: "VV380205975BY"'
//        ];
//    }
}
