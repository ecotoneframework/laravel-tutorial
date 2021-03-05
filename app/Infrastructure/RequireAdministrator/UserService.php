<?php
namespace App\Infrastructure\RequireAdministrator;

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
