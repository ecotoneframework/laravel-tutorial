<?php
namespace App\Infrastructure\AddUserId;

use Ecotone\Messaging\Attribute\Interceptor\Presend;

class AddUserIdService
{
    #[Presend(0, AddUserId::class, true)]
    public function add() : array
    {
        return ["userId" => 1];
    }
}
