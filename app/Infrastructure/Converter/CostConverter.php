<?php
namespace App\Infrastructure\Converter;

use App\Domain\Product\Cost;
use Ecotone\Messaging\Annotation\Converter;
use Ecotone\Messaging\Annotation\ConverterClass;

/**
 * @ConverterClass()
 */
class CostConverter
{
    /**
     * @Converter()
     */
    public function convertFrom(Cost $cost) : int
    {
        return $cost->getAmount();
    }

    /**
     * @Converter()
     */
    public function convertTo(int $amount) : Cost
    {
        return new Cost($amount);
    }
}