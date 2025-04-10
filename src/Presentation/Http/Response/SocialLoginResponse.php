<?php

namespace Udhuong\PassportAuth\Presentation\Http\Response;

use Udhuong\PassportAuth\Domain\Entities\AuthUser;

class SocialLoginResponse
{
    public static function format(AuthUser $authUser): array
    {
        return [
            'token' => $authUser->token->accessToken,
            'user' => [
                'id' => $authUser->userId,
                'name' => $authUser->name,
                'email' => $authUser->email,
            ],
        ];
    }
}
