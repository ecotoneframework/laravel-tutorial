<?php
namespace App\Domain\Product;

class ChangePriceCommand
{
    private int $productId;

    private Cost $cost;

    public function getProductId() : int
    {
        return $this->productId;
    }

    public function getCost() : Cost
    {
        return $this->cost;
    }
}