<?php

namespace Udhuong\PassportAuth\Domain\Factories;

use Laravel\Socialite\Two\User;
use Udhuong\PassportAuth\Domain\Entities\SocialAccount;

class SocialUserFactory
{
    /**
     * @param User $user
     * @return SocialAccount
     */
    public static function fromTwoUser(User $user): SocialAccount
    {
        $socialUser = new SocialAccount();
        $socialUser->providerId = $user->getId();
        $socialUser->nickname = $user->getNickname();
        $socialUser->name = $user->getName();
        $socialUser->email = $user->getEmail();
        $socialUser->avatar = $user->getAvatar();
        $socialUser->user = $user->getRaw();
        $socialUser->attribute = $user->user;
        $socialUser->token = $user->token;
        $socialUser->refreshToken = $user->refreshToken;
        $socialUser->expiresIn = $user->expiresIn;
        $socialUser->approvedScopes = $user->approvedScopes;
        return $socialUser;
    }
}