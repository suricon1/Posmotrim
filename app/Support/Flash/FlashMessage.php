<?php


namespace App\Support\Flash;


final class FlashMessage
{
    protected $message;
    protected $class;

    public function __construct( string $message, string $class)
    {
        $this->message = $message;
        $this->class = $class;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function class(): string
    {
        return $this->class;
    }
}
