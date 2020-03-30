<?php
namespace App\Domain\Product;

class UserService
{
    public function isAdmin(int $userId) : bool
    {
        return $userId === 1;
    }
}