<?php

namespace Udhuong\PassportAuth\Presentation\Http\Response;

use Udhuong\PassportAuth\Domain\Entities\AuthUser;

class GetUserLoggedResponse
{
    public static function format(AuthUser $authUser): array
    {
        return [
            'id' => $authUser->userId,
            'name' => $authUser->name,
            'email' => $authUser->email,
        ];
    }
}
