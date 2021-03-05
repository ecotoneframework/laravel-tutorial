<?php
namespace App\Infrastructure;

use Ecotone\Amqp\AmqpBackedMessageChannelBuilder;
use Ecotone\Messaging\Attribute\ServiceContext;

class MessagingConfiguration
{
    #[ServiceContext]
    public function orderChannel()
    {
        return [
            AmqpBackedMessageChannelBuilder::create("orders")
        ];
    }
}
