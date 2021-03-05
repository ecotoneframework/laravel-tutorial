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
        $this->commandBus->sendWithRouting(
            "product.register",
            \json_encode(["productId" => 1, "cost" => 100]),
            MediaType::APPLICATION_JSON
        );

        $this->commandBus->sendWithRouting(
            "product.changePrice",
            \json_encode(["productId" => 1, "cost" => 110]),
            MediaType::APPLICATION_JSON
        );

        echo $this->queryBus->sendWithRouting("product.getCost", \json_encode(["productId" => 1]), MediaType::APPLICATION_JSON);
    }
}
