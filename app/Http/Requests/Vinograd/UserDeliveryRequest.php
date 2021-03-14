<?php


namespace App\Http\Requests\Vinograd;

use Illuminate\Foundation\Http\FormRequest;

class UserDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'delivery.first_name' => [
                'required',
                'regex:/^[А-Яа-яA-Za-z ]{3,50}$/iu'
            ],
            'delivery.address' => 'required',
            'delivery.index' => 'required|digits:6',
            'delivery.phone' => [
                'nullable',
                'regex:/^[\+\(\)1-9 _-]{5,}$/iu'
            ],
        ];
    }

    public function messages()
    {
        return [
            'delivery.first_name.required' => 'Укажите Ваше имя и фамилию, иначе Вы не сможете получить свою посылку!',
            'delivery.first_name.regex' => 'Правильно укажите Ваше имя и фамилию, иначе Вы не сможете получить свою посылку!',
            'delivery.address.required' => 'Правильно укажите почтовый адрес, иначе Вы не сможете получить свою посылку!',
            'delivery.index.required' => 'Укажите почтовый индекс, иначе Вы не сможете получить свою посылку!',
            'delivery.index.digits' => 'Правильно укажите почтовый индекс, иначе Вы не сможете получить свою посылку!',
            'delivery.phone.regex' => 'Номер телефона указывать необязятельно, иначе номер телефона должен быть рабочий!',
        ];
    }
}
