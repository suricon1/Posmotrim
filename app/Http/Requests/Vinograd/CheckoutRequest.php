<?php

namespace App\Http\Requests\Vinograd;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer.name' => 'required|min:3|max:50|string',
            'customer.email' => 'nullable|required_without:customer.phone|email',
            'customer.phone' => 'nullable|required_without:customer.email',
            'delivery.address' => 'sometimes|string',
            'delivery.index' => 'sometimes|regex:/[0-9]{4}/',
            'note' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'customer.name.required' => 'Представьтесь, пожалуйста.',
            'customer.email.required_without' => 'Оставьте для обратной связи либо Email либо номер телефона.',
            'customer.phone.required_without' => 'Оставьте для обратной связи либо Email либо номер телефона.',
            'delivery.index.regex'  => 'Введите индекс почты правильного формата.',
            'delivery.address.string'  => 'Укажите действительный адрес отправки заказа.',
        ];
    }
}
