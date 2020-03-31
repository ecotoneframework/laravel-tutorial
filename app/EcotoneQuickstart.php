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
            MediaType::APPLICATION_JSON,
            \json_encode(["productId" => 1, "cost" => 100])
        );

        $this->commandBus->convertAndSend(
            "product.changePrice",
            MediaType::APPLICATION_JSON,
            \json_encode(["productId" => 1, "cost" => 110])
        );

        echo $this->queryBus->convertAndSend("product.getCost", MediaType::APPLICATION_JSON, \json_encode(["productId" => 1]));
    }
}