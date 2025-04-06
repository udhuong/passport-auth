<?php

namespace Udhuong\PassportAuth\Infrastructure\Repositories;

use Udhuong\PassportAuth\Domain\Contracts\SocialAccountRepository;
use Udhuong\PassportAuth\Domain\Entities\SocialAccount;
use Udhuong\PassportAuth\Domain\ValueObjects\SocialProvider;
use Udhuong\PassportAuth\Infrastructure\Models\SocialAccountModel;

class SocialAccountRepositoryImpl implements SocialAccountRepository
{
    /**
     * @param int|string $providerId
     * @param string $providerName
     * @return SocialAccount|null
     */
    public function findByProviderId(int|string $providerId, string $providerName): ?SocialAccount
    {
        $data = SocialAccountModel::query()
            ->where('provider_id', $providerId)
            ->where('provider_name', $providerName)
            ->first();
        if (empty($data)) {
            return null;
        }

        $socialAccount = new SocialAccount();
        $socialAccount->userId = $data->user_id;
        $socialAccount->providerId = $data->provider_id;
        $socialAccount->provider = SocialProvider::tryFrom($providerName);

        return $socialAccount;
    }

    /**
     * @param SocialAccount $account
     * @return void
     */
    public function create(SocialAccount $account): void
    {
        SocialAccountModel::create([
            'user_id' => $account->userId,
            'provider_id' => $account->providerId,
            'provider_name' => $account->provider->value,
        ]);
    }
}
