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

    private int $cost;

    private function __construct(int $productId, int $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;

        $this->record(new ProductWasRegisteredEvent($productId));
    }

    /**
     * @CommandHandler()
     */
    public static function register(RegisterProductCommand $command) : self
    {
        return new self($command->getProductId(), $command->getCost());
    }

    /**
     * @QueryHandler()
     */
    public function getCost(GetProductPriceQuery $query) : int
    {
        return $this->cost;
    }
}