<?php

namespace Udhuong\PassportAuth\Presentation\Http\Response;

use Udhuong\PassportAuth\Domain\Entities\Token;

class GetTokenResponse
{
    public static function format(Token $token): array
    {
        return [
            'token_type' => $token->tokenType,
            'expires_in' => $token->expiresIn,
            'scope' => $token->scopes,
            'access_token' => $token->accessToken,
        ];
    }
}
