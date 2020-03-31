<?php
namespace App\Domain\Order;

class PlaceOrderCommand
{
    private int $orderId;
    /**
     * @var int[]
     */
    private array $productIds;

    /**
     * @return int[]
     */
    public function getProductIds(): array
    {
        return $this->productIds;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }
}