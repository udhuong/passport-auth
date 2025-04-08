<?php

namespace Udhuong\PassportAuth\Presentation\Http\Requests;

use Udhuong\LaravelCommon\Presentation\Http\Requests\ApiRequest;
use Udhuong\PassportAuth\Domain\DTOs\GetTokenDTO;

class ClientGetTokenRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'client_id' => 'required|int',
            'client_secret' => 'required|string',
            'scopes' => 'nullable|array',
            'scopes.*' => 'nullable|string|distinct',
        ];
    }

    public function toDto(): GetTokenDTO
    {
        $dto = new GetTokenDTO();
        $dto->clientId = (int)$this->input('client_id');
        $dto->clientSecret = $this->input('client_secret');
        $dto->scopes = $this->input('scopes', []);
        return $dto;
    }
}
