<?php

namespace App\Http\Requests\Admin\Vinograd\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class OrdersTreckCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => 'required|exists:vinograd_orders,id',
            'track_code' => ['required', 'regex:/^([A-Za-z]{2}[0-9]{9}(BY|by))$|^([A-Za-z]{3}[0-9]{14})$/'],
        ];
    }

    public function messages()
    {
        return [
            'track_code.regex' => 'Код должен иметь формат: для почты - "VV380205975BY, для Boxberry - BBU17340054869422"'
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if (Route::currentRouteName() == 'orders.sent.status.mail') {
            return $url->route('orders.track_code_form', $this->order_id);
        }
        return $url->previous();
    }
}
