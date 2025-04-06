<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\PassportAuth\Domain\DTOs\LoginDTO;
use Udhuong\PassportAuth\Domain\Entities\Token;

class LoginAction
{
    /**
     * Người dùng đăng nhập lấy token
     *
     * @param LoginDTO $dto
     * @return Token
     * @throws AppException
     * @throws ConnectionException
     */
    public function handle(LoginDTO $dto): Token
    {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport_auth.grant_type.password.client_id'),
            'client_secret' => config('passport_auth.grant_type.password.client_secret'),
            'username' => $dto->email,
            'password' => $dto->password,
            'scope' => '',
        ]);
        if (!$response->successful()) {
            throw new AppException($response->json());
        }

        $token = new Token();
        $token->accessToken = $response->json('access_token');
        $token->refreshToken = $response->json('refresh_token');
        $token->expiresIn = $response->json('expires_in');
        $token->tokenType = $response->json('token_type');

        return $token;
    }
}