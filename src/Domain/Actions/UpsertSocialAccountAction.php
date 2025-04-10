<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Support\Str;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\Contracts\SocialAccountRepository;
use Udhuong\PassportAuth\Domain\Entities\AuthUser;
use Udhuong\PassportAuth\Domain\Entities\SocialAccount;
use Udhuong\PassportAuth\Domain\Entities\Token;

class UpsertSocialAccountAction
{
    public function __construct(
        private readonly SocialAccountRepository $socialAccountRepository,
        private readonly AuthRepository $authRepository,
    ) {}

    /**
     * Đăng nhập hoặc đăng ký người dùng với tài khoản mạng xã hội.
     */
    public function handle(SocialAccount $socialAccount): AuthUser
    {
        // Kiểm tra xem user đã đăng nhập với provider nào chưa
        $socialAccountExist = $this->socialAccountRepository->findByProviderId(
            $socialAccount->providerId,
            $socialAccount->provider->value
        );

        // Kiểm tra xem user đã tồn tại trong hệ thống chưa
        $authUser = $this->authRepository->getUserByEmail($socialAccount->email);
        if (! $authUser) {
            $userId = $this->authRepository->createUserGetId(
                $socialAccount->email,
                $socialAccount->name,
                bcrypt(Str::random(16))
            );
            $authUser = $this->authRepository->getUserByUserId($userId);
        }

        // Nếu người dùng chưa đăng nhập với provider nào
        if (! $socialAccountExist) {
            $socialAccount->userId = $authUser->userId;
            $this->socialAccountRepository->create($socialAccount);
        }

        $token = new Token;
        $token->accessToken = $this->authRepository->getTokenByEmail($socialAccount->email);
        $authUser->token = $token;

        return $authUser;
    }
}
