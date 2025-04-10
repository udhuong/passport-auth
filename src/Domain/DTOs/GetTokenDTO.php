<?php

namespace Udhuong\PassportAuth\Domain\DTOs;

class GetTokenDTO
{
    public int $clientId;

    public string $clientSecret;

    public array $scopes = [];
}
