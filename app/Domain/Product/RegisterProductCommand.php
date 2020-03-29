<?php

namespace App\Domain\Product;

class RegisterProductCommand
{
    private int $productId;

    private int $cost;

    public function __construct(int $productId, int $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;
    }

    public function getProductId() : int
    {
        return $this->productId;
    }

    public function getCost() : int
    {
        return $this->cost;
    }
}