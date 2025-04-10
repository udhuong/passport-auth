<?php

namespace Udhuong\PassportAuth\Domain\Entities;

class AuthUser
{
    public int $userId;

    public string $name;

    public string $email;

    public string $password;

    public Token $token;
}
