<?php
namespace App\Domain\Product;

use Ecotone\Messaging\Annotation\MessageEndpoint;
use Ecotone\Modelling\Annotation\EventHandler;

/**
 * @MessageEndpoint()
 */
class ProductNotifier
{
    /**
     * @EventHandler()
     */
    public function notifyAbout(ProductWasRegisteredEvent $event) : void
    {
        echo "Product with id {$event->getProductId()} was registered!\n";
    }
}