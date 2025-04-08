<?php

namespace Udhuong\PassportAuth\Domain\Entities;

class Token
{
    public string $tokenType;
    public int $expiresIn;
    public string $accessToken;
    public string $refreshToken;
    public array $scopes;
}
