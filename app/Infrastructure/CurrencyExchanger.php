<?php
namespace App\Infrastructure;

use Ecotone\Messaging\Annotation\MessageEndpoint;
use Ecotone\Messaging\Annotation\Poller;
use Ecotone\Messaging\Annotation\Scheduled;

/**
 * @MessageEndpoint()
 */
class CurrencyExchanger
{
    /**
     * @Scheduled(
     *     endpointId="currency_exchanger",
     *     requestChannelName="product.changePrice",
     *     poller=@Poller(
     *          fixedRateInMilliseconds=1000
     *     )
     * )
     */
    public function exchange() : array
    {
        echo "Changing the price\n";
        return ["productId" => 1, "cost" => 120];
    }
}