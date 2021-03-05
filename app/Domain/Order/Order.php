<?php
namespace App\Domain\Order;

use App\Infrastructure\AddUserId\AddUserId;
use Ecotone\Messaging\Attribute\Asynchronous;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\QueryBus;

#[Aggregate]
#[AddUserId]
class Order
{
    #[AggregateIdentifier]
    private int $orderId;

    private int $buyerId;

    /**
     * @var OrderedProduct[]
     */
    private array $orderedProducts;

    private function __construct(int $orderId, int $buyerId, array $orderedProducts)
    {
        $this->orderId = $orderId;
        $this->buyerId = $buyerId;
        $this->orderedProducts = $orderedProducts;
    }

    #[Asynchronous("orders")]
    #[CommandHandler("order.place","place_order_endpoint")]
    public static function placeOrder(PlaceOrderCommand $command, array $metadata, QueryBus $queryBus) : self
    {
        $orderedProducts = [];
        foreach ($command->getProductIds() as $productId) {
            $productCost = $queryBus->sendWithRouting("product.getCost", ["productId" => $productId]);
            $orderedProducts[] = new OrderedProduct($productId, $productCost->getAmount());
        }

        return new self($command->getOrderId(), $metadata["userId"], $orderedProducts);
    }

    #[QueryHandler("order.getTotalPrice")]
    public function getTotalPrice() : int
    {
        $totalPrice = 0;
        foreach ($this->orderedProducts as $orderedProduct) {
            $totalPrice += $orderedProduct->getCost();
        }

        return $totalPrice;
    }
}
