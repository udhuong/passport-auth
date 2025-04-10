<?php

namespace Udhuong\PassportAuth\Domain\Entities;

class AuthUser
{
    public int $userId;

    public string $name;

    public string $email;

    public Token $token;
}
