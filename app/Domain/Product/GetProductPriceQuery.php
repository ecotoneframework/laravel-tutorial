<?php

namespace App\Domain\Product;

class GetProductPriceQuery
{
    private int $productId;

    public function getProductId() : int
    {
        return $this->productId;
    }
}