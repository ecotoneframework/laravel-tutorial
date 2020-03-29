<?php

namespace App\Domain\Product;

use Ecotone\Messaging\Annotation\MessageEndpoint;
use Ecotone\Modelling\Annotation\CommandHandler;
use Ecotone\Modelling\Annotation\QueryHandler;
use Ecotone\Modelling\EventBus;

/**
 * @MessageEndpoint()
 */
class ProductService
{
    private array $registeredProducts = [];

    /**
     * @CommandHandler()
     */
    public function register(RegisterProductCommand $command, EventBus $eventBus) : void
    {
        $this->registeredProducts[$command->getProductId()] = $command->getCost();

        $eventBus->send(new ProductWasRegisteredEvent($command->getProductId()));
    }

    /**
     * @QueryHandler()
     */
    public function getPrice(GetProductPriceQuery $query) : int
    {
        return $this->registeredProducts[$query->getProductId()];
    }
}