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
        $this->commandBus->convertAndSendWithMetadata(
            "product.register",
            MediaType::APPLICATION_JSON,
            \json_encode(["productId" => 1, "cost" => 100]),
            [
                "userId" => 1
            ]
        );

        $this->commandBus->convertAndSendWithMetadata(
            "product.changePrice",
            MediaType::APPLICATION_JSON,
            \json_encode(["productId" => 1, "cost" => 110]),
            [
                "userId" => 1
            ]
        );

        echo $this->queryBus->convertAndSend("product.getCost", MediaType::APPLICATION_JSON, \json_encode(["productId" => 1]));
    }
}