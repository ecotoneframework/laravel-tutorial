<?php

namespace App\Domain\Product;

use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\EventBus;

class ProductService
{
    private array $registeredProducts = [];

    #[CommandHandler]
    public function register(RegisterProductCommand $command, EventBus $eventBus) : void
    {
        $this->registeredProducts[$command->getProductId()] = $command->getCost();

        $eventBus->publish(new ProductWasRegisteredEvent($command->getProductId()));
    }

    #[QueryHandler]
    public function getPrice(GetProductPriceQuery $query) : int
    {
        return $this->registeredProducts[$query->getProductId()];
    }
}
