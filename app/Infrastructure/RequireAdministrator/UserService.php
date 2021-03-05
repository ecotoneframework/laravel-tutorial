<?php
namespace App\Infrastructure\RequireAdministrator;

use Ecotone\Messaging\Attribute\Interceptor\Before;
use Ecotone\Messaging\Attribute\Parameter\Header;

class UserService
{
    #[Before(1, RequireAdministrator::class)]
    public function isAdmin(#[Header("userId")] ?string $userId) : void
    {
        if ($userId != 1) {
            throw new \InvalidArgumentException("You need to be administrator in order to register new product");
        }
    }
}
