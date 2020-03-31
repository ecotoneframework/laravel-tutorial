<?php
namespace App\Infrastructure\AddUserId;

use Ecotone\Messaging\Annotation\Interceptor\Before;
use Ecotone\Messaging\Annotation\Interceptor\MethodInterceptor;

/**
 * @MethodInterceptor()
 */
class AddUserIdService
{
    /**
     * @Before(
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