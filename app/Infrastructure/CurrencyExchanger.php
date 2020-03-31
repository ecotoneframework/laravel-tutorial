<?php
namespace App\Infrastructure;

use Ecotone\Messaging\Annotation\InboundChannelAdapter;
use Ecotone\Messaging\Annotation\MessageEndpoint;
use Ecotone\Messaging\Annotation\Poller;

/**
 * @MessageEndpoint()
 */
class CurrencyExchanger
{
    /**
     * @InboundChannelAdapter(
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