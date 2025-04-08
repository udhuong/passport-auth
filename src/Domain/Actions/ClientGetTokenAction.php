<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\DTOs\GetTokenDTO;
use Udhuong\PassportAuth\Domain\DTOs\LoginDTO;
use Udhuong\PassportAuth\Domain\Entities\Token;

class ClientGetTokenAction
{
    public function __construct(
        private readonly AuthRepository $authRepository,
    )
    {
    }

    /**
     * Server lấy token
     *
     * @param GetTokenDTO $dto
     * @return Token
     * @throws AppException
     * @throws ConnectionException
     */
    public function handle(GetTokenDTO $dto): Token
    {
        $scopesValid = $this->getScopeAssignClient($dto->clientId, $dto->scopes);

        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $dto->clientId,
            'client_secret' => $dto->clientSecret,
            'scope' => sprintf("%s", implode(' ', $scopesValid)),
        ]);
        if (!$response->successful()) {
            throw new AppException($response->json()['error_description'] ?? 'Lỗi không xác định');
        }

        $token = new Token();
        $token->accessToken = $response->json('access_token');
        $token->expiresIn = $response->json('expires_in');
        $token->tokenType = $response->json('token_type');
        $token->scopes = $scopesValid;

        return $token;
    }

    /**
     * Lấy danh sách scope được cấp cho client
     *
     * @param int $clientId
     * @param array $scopes
     * @return array
     */
    private function getScopeAssignClient(int $clientId, array $scopes): array
    {
        $scopesAssignClient = $this->authRepository->getScopesByClientId($clientId);
        return array_intersect($scopes, $scopesAssignClient);
    }
}
