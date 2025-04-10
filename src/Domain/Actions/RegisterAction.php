<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Support\Facades\Hash;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\DTOs\RegisterDTO;
use Udhuong\PassportAuth\Domain\Entities\AuthUser;

class RegisterAction
{
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {}

    /**
     * Đăng ký tài khoản
     */
    public function handle(RegisterDTO $dto): AuthUser
    {
        $authUser = new AuthUser;
        $authUser->name = $dto->name;
        $authUser->email = $dto->email;
        $authUser->password = Hash::make($dto->password);
        $authUser->userId = $this->authRepository->createUser($authUser);

        return $authUser;
    }
}
