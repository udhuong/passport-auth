<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\PassportAuth\Domain\Entities\Token;

class RefreshTokenAction
{
    /**
     * Người dùng đăng nhập lấy token
     *
     * @param string $refreshToken
     * @return Token
     * @throws AppException
     * @throws ConnectionException
     */
    public function handle(string $refreshToken): Token
    {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('passport_auth.grant_type.password.client_id'),
            'client_secret' => config('passport_auth.grant_type.password.client_secret'),
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