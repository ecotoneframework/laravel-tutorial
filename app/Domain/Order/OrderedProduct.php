<?php
namespace App\Domain\Order;

class OrderedProduct
{
    private int $productId;

    private int $cost;

    public function __construct(int $productId, int $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;
    }

    public function getCost(): int
    {
        return $this->cost;
    }
}