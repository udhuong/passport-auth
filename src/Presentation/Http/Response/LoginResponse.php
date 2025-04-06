<?php

namespace Udhuong\PassportAuth\Presentation\Http\Response;

use Udhuong\PassportAuth\Domain\Entities\Token;

class LoginResponse
{
    public static function format(Token $token)
    {
        return [
            'token_type' => $token->tokenType,
            'expires_in' => $token->expiresIn,
            'access_token' => $token->accessToken,
            'refresh_token' => $token->refreshToken,
        ];
    }
}