<?php

namespace Udhuong\PassportAuth\Domain\Contracts;

use Udhuong\PassportAuth\Domain\Entities\SocialAccount;

interface SocialAccountRepository
{
    public function findByProviderId(string|int $providerId, string $providerName): ?SocialAccount;

    public function create(SocialAccount $account): void;
}
