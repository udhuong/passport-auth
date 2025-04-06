<?php

namespace Udhuong\PassportAuth\Presentation\Http\Requests;

use Udhuong\LaravelCommon\Presentation\Http\Requests\ApiRequest;
use Udhuong\PassportAuth\Domain\DTOs\RegisterDTO;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function toDto(): RegisterDTO
    {
        $dto = new RegisterDTO();
        $dto->name = $this->input('name');
        $dto->email = $this->input('email');
        $dto->password = $this->input('password');
        return $dto;
    }
}