<?php

namespace Udhuong\PassportAuth\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\LaravelCommon\Presentation\Http\Controllers\Controller;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;
use Udhuong\PassportAuth\Domain\Actions\UpsertSocialAccountAction;
use Udhuong\PassportAuth\Domain\Factories\SocialUserFactory;
use Udhuong\PassportAuth\Domain\ValueObjects\SocialProvider;
use Udhuong\PassportAuth\Presentation\Http\Response\SocialLoginResponse;

class SocialAuthController extends Controller
{
    public function __construct(
        private readonly UpsertSocialAccountAction $upsertSocialUserAction
    ) {}

    /**
     * Chuyển hướng đăng nhập qua provider
     */
    public function redirect($provider): mixed
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Đăng nhập qua provider
     *
     * @throws AppException
     */
    public function callback($provider): JsonResponse
    {
        $providerEnum = SocialProvider::tryFrom($provider);
        if (! $providerEnum) {
            throw new AppException('Provider không hợp lệ', 400);
        }

        $socialUserRaw = Socialite::driver($provider)->stateless()->user();
        $socialUser = SocialUserFactory::fromTwoUser($socialUserRaw);
        $socialUser->provider = $providerEnum;

        $authUser = $this->upsertSocialUserAction->handle($socialUser);

        return Responder::success(SocialLoginResponse::format($authUser), 'Đăng nhập thành công');
    }
}
