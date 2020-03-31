<?php
namespace App\Infrastructure\RequireAdministrator;

use Ecotone\Messaging\Annotation\Interceptor\Before;
use Ecotone\Messaging\Annotation\Interceptor\MethodInterceptor;
use Ecotone\Messaging\Annotation\Parameter\Header;

/**
 * @MethodInterceptor()
 */
class UserService
{
    /**
     * @Before(
     *     pointcut="@(App\Infrastructure\RequireAdministrator\RequireAdministrator)",
     *     parameterConverters={
     *         @Header(parameterName="userId", headerName="userId", isRequired=false)
     *     },
     *     precedence=1
     * )
     */
    public function isAdmin(?string $userId) : void
    {
        if ($userId != 1) {
            throw new \InvalidArgumentException("You need to be administrator in order to register new product");
        }
    }
}