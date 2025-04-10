<?php

namespace Udhuong\PassportAuth\Domain\Contracts;

use Udhuong\PassportAuth\Domain\Entities\AuthUser;

interface AuthRepository
{
    public function createUser(AuthUser $user): int;

    public function revokedToken(string $tokenId): void;

    public function getUserByEmail(string $email): ?AuthUser;

    public function getUserByUserId(int $userId): ?AuthUser;

    public function createUserGetId(string $email, string $name, string $password): int;

    public function getTokenByEmail(string $email): ?string;

    public function getScopesByClientId(int $clientId): array;
}
