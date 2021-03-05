<?php
namespace App\Domain\Product;

use Ecotone\Modelling\Attribute\EventHandler;

class ProductNotifier
{
    #[EventHandler]
    public function notifyAbout(ProductWasRegisteredEvent $event) : void
    {
        echo "Product with id {$event->getProductId()} was registered!\n";
    }
}
