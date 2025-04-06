<?php

namespace Udhuong\PassportAuth\Presentation\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\LaravelCommon\Presentation\Http\Controllers\Controller;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;
use Udhuong\PassportAuth\Domain\Actions\LoginAction;
use Udhuong\PassportAuth\Domain\Actions\RefreshTokenAction;
use Udhuong\PassportAuth\Domain\Actions\RegisterAction;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\Entities\AuthUser;
use Udhuong\PassportAuth\Presentation\Http\Requests\LoginRequest;
use Udhuong\PassportAuth\Presentation\Http\Requests\RefreshTokenRequest;
use Udhuong\PassportAuth\Presentation\Http\Requests\RegisterRequest;
use Udhuong\PassportAuth\Presentation\Http\Response\GetUserLoggedResponse;
use Udhuong\PassportAuth\Presentation\Http\Response\LoginResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterAction $registerAction,
        private readonly LoginAction $loginAction,
        private readonly RefreshTokenAction $refreshTokenAction,
        private readonly AuthRepository $authRepository
    ) {
    }

    /**
     * Đăng ký tài khoản
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerAction->handle($request->toDto());
        return Responder::success([
            'user_id' => $user
        ], 'Tạo tài khoản thành công');
    }

    /**
     * Đăng nhập tài khoản
     *
     * @throws AppException
     * @throws ConnectionException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->loginAction->handle($request->toDto());
        return Responder::success(
            LoginResponse::format($token),
            'Đăng nhập thành công'
        );
    }

    /**
     * Refresh token
     *
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     * @throws AppException
     * @throws ConnectionException
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $token = $this->refreshTokenAction->handle($request->get('refresh_token'));
        return Responder::success(
            LoginResponse::format($token),
            'Lấy token mới thành công'
        );
    }

    /**
     * Đăng xuất tài khoản
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();
        $this->authRepository->revokedToken($token->id);

        return Responder::ok('Đăng xuất thành công');
    }

    /**
     * Lấy thông tin người dùng đã đăng nhập
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserLogged(Request $request): JsonResponse
    {
        $authUser = new AuthUser();
        $authUser->userId = $request->user()->id;
        $authUser->email = $request->user()->email;
        $authUser->name = $request->user()->name;

        return Responder::success(
            GetUserLoggedResponse::format($authUser),
            'Lấy token mới thành công'
        );
    }
}
