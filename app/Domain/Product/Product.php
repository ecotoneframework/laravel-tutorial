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

    private int $userId;

    private function __construct(int $productId, Cost $cost, int $userId)
    {
        $this->productId = $productId;
        $this->cost = $cost;
        $this->userId = $userId;

        $this->recordThat(new ProductWasRegisteredEvent($productId));
    }

    #[CommandHandler("product.register")]
    public static function register(RegisterProductCommand $command, array $metadata, UserService $userService) : self
    {
        $userId = $metadata["userId"];
        if (!$userService->isAdmin($userId)) {
            throw new \InvalidArgumentException("You need to be administrator in order to register new product");
        }

        return new self($command->getProductId(), $command->getCost(), $userId);
    }

    #[QueryHandler("product.getCost")]
    public function getCost(GetProductPriceQuery $query) : Cost
    {
        return $this->cost;
    }

    #[CommandHandler("product.changePrice")]
    public function changePrice(ChangePriceCommand $command, array $metadata) : void
    {
        if ($metadata["userId"] !== $this->userId) {
            throw new \InvalidArgumentException("You are not allowed to change the cost of this product");
        }

        $this->cost = $command->getCost();
    }
}
