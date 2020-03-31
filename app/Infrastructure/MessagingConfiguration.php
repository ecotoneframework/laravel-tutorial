<?php
namespace App\Infrastructure;

use Ecotone\Amqp\AmqpBackedMessageChannelBuilder;
use Ecotone\Messaging\Annotation\ApplicationContext;
use Ecotone\Messaging\Annotation\Extension;

/**
 * @ApplicationContext()
 */
class MessagingConfiguration
{
    /**
     * @Extension()
     */
    public function orderChannel()
    {
        return [
            AmqpBackedMessageChannelBuilder::create("orders")
        ];
    }
}