<?php

namespace App;

class Price
{
    protected $value = 0;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return '€ '.number_format($this->asDecimal(), 2);
    }

    public function asCents(): int
    {
        return $this->value;
    }

    public function asDecimal(): float
    {
        return $this->value / 100;
    }
}