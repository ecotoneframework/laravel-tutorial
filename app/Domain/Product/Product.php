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

    private Cost $cost;

    private function __construct(int $productId, Cost $cost)
    {
        $this->productId = $productId;
        $this->cost = $cost;

        $this->recordThat(new ProductWasRegisteredEvent($productId));
    }

    #[CommandHandler("product.register")]
    public static function register(RegisterProductCommand $command) : self
    {
        return new self($command->getProductId(), $command->getCost());
    }

    #[QueryHandler("product.getCost")]
    public function getCost(GetProductPriceQuery $query) : Cost
    {
        return $this->cost;
    }
}
