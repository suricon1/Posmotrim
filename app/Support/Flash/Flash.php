<?php

namespace App\Support\Flash;

use Session;

final class Flash
{

    // Вывод флешек в видах
//    @if($message = flash()->get())
//        <div class="{{$message->class()}}">
//            {{$message->message()}}
//        </div>
//    @endif


    protected const MESSAGE_KEY = 'shop_flash_message';
    protected const MESSAGE_CLASS_KEY = 'shop_flash_class';

    protected $session;

    public function __construct (Session $session)
    {
        $this->session = $session;
    }

    public function get(): ?FlashMessage
    {
        $message = $this->session::get(self::MESSAGE_KEY);
        if(!$message){
            return null;
        }
        return new FlashMessage($message, $this->session::get(self::MESSAGE_CLASS_KEY, ''));
    }

    public function info(string $message)
    {
        $this->flash($message, 'info');
    }

    public function alert(string $message)
    {
        $this->flash($message, 'flash');
    }

    private function flash(string $message, string $name)
    {
        $this->session::flash(self::MESSAGE_KEY, $message);
        $this->session::flash(self::MESSAGE_CLASS_KEY, config("flash.$name"));
    }
}
