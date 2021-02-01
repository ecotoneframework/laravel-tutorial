<?php
namespace App\Infrastructure\AddUserId;

use Ecotone\Messaging\Annotation\Interceptor\Presend;

class AddUserIdService
{
    /**
     * @Presend(
     *     pointcut="@(App\Infrastructure\AddUserId\AddUserId)",
     *     changeHeaders=true,
     *     precedence=0
     * )
     */
    public function add() : array
    {
        return ["userId" => 1];
    }
}
