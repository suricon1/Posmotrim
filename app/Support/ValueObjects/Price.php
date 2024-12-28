<?php


namespace App\Support\ValueObjects;


use App\Support\Traits\Makeable;
use InvalidArgumentException;
use Stringable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
      'RUB' => ''
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100

    )
    {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Цена не может быть ниже нуля');
        }

        if (isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException('Такой тип валюты не поддерживается');
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return  number_format($this->value(), 2, ',', ' ') . ' ' . $this->symbol();
    }
}
