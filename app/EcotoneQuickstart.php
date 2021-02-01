<?php

namespace App;

use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;
use Ecotone\Messaging\Conversion\MediaType;

class EcotoneQuickstart
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function run() : void
    {
        $this->commandBus->convertAndSend(
            "product.register",
            MediaType::APPLICATION_X_PHP_ARRAY,
            ["productId" => 1, "cost" => 100]
        );
        $this->commandBus->convertAndSend(
            "product.register",
            MediaType::APPLICATION_X_PHP_ARRAY,
            ["productId" => 2, "cost" => 300]
        );

        $orderId = 990;
        $this->commandBus->convertAndSend(
            "order.place",
            MediaType::APPLICATION_X_PHP_ARRAY,
            ["orderId" => $orderId, "productIds" => [1,2]]
        );

        echo $this->queryBus->convertAndSend("order.getTotalPrice", MediaType::APPLICATION_X_PHP_ARRAY, ["orderId" => $orderId]);
    }
}
