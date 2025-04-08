<?php

namespace Udhuong\PassportAuth\Domain\Validate;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;

class CustomClientCredentialsGrant extends ClientCredentialsGrant
{
    /**
     * Custom lại validate thêm scope
     *
     * @param $request
     * @return ClientEntityInterface
     * @throws OAuthServerException
     */
    public function validateClient($request): ClientEntityInterface
    {
        $client = parent::validateClient($request);
        // Lấy scope từ request
        $scopes = $request->getParsedBody()['scope'] ?? '';
        if (!$scopes) {
            return $client;
        }

        $requestedScopes = [];
        if (is_string($scopes)) {
            $requestedScopes = explode(' ', $scopes);
        } elseif (is_array($scopes)) {
            $requestedScopes = $scopes;
        }

        if (!$requestedScopes) {
            return $client;
        }

        // Kiểm tra scope có thuộc client này không
        $clientScopes = app(AuthRepository::class)->getScopesByClientId($client->getIdentifier());
        foreach ($requestedScopes as $scope) {
            if (!in_array($scope, $clientScopes, true)) {
                throw OAuthServerException::invalidScope($scope);
            }
        }

        return $client;
    }
}
