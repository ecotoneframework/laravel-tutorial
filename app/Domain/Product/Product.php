<?php
namespace App\Domain\Product;

use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\WithAggregateEvents;

#[Aggregate]
class Product
{
    use WithAggregateEvents;

    #[AggregateIdentifier]
    private int $productId;

    private int $cost;

    private function __construct(int $productId, int $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;

        $this->recordThat(new ProductWasRegisteredEvent($productId));
    }

    #[CommandHandler]
    public static function register(RegisterProductCommand $command) : self
    {
        return new self($command->getProductId(), $command->getCost());
    }

    #[QueryHandler]
    public function getCost(GetProductPriceQuery $query) : int
    {
        return $this->cost;
    }
}
