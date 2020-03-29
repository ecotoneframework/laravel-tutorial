<?php

namespace App\Domain\Product;

class Cost
{
    private int $amount;

    public function __construct(int $amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("The cost should not negative or zero, {$amount} given.");
        }

        $this->amount = $amount;
    }

    public function getAmount() : int
    {
        return $this->amount;
    }

    public function __toString()
    {
        return (string)$this->amount;
    }
}