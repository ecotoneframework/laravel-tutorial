<?php
namespace App\Domain\Product;

use Ecotone\Modelling\Annotation\Aggregate;
use Ecotone\Modelling\Annotation\AggregateIdentifier;
use Ecotone\Modelling\Annotation\CommandHandler;
use Ecotone\Modelling\Annotation\QueryHandler;
use Ecotone\Modelling\WithAggregateEvents;

/**
 * @Aggregate()
 */
class Product
{
    use WithAggregateEvents;

    /**
     * @AggregateIdentifier()
     */
    private int $productId;

    private Cost $cost;

    private function __construct(int $productId, Cost $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;

        $this->record(new ProductWasRegisteredEvent($productId));
    }

    /**
     * @CommandHandler(inputChannelName="product.register")
     */
    public static function register(RegisterProductCommand $command) : self
    {
        return new self($command->getProductId(), $command->getCost());
    }

    /**
     * @QueryHandler(inputChannelName="product.getCost")
     */
    public function getCost(GetProductPriceQuery $query) : Cost
    {
        return $this->cost;
    }
}