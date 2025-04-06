<?php

namespace Udhuong\PassportAuth\Presentation\Http\Requests;

use Udhuong\LaravelCommon\Presentation\Http\Requests\ApiRequest;
use Udhuong\PassportAuth\Domain\DTOs\LoginDTO;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function toDto(): LoginDTO
    {
        $dto = new LoginDTO();
        $dto->email = $this->input('email');
        $dto->password = $this->input('password');
        return $dto;
    }
}