<?php

namespace App\Http\Requests\Admin\Vinograd\Order;

use Illuminate\Foundation\Http\FormRequest;

class SendReplyMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:vinograd_orders,id',
            'subject' =>  'required',
            'message' =>  'required'
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Не балуй',
            'order_id.exists' => 'Не балуй',
            'subject.required' => 'Укажите тему письма',
            'message.required' => 'Набросайте хоть пару словей!'
        ];
    }
}
