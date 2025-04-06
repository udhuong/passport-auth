<?php

namespace Udhuong\PassportAuth\Domain\Actions;

use Illuminate\Support\Facades\Hash;
use Udhuong\PassportAuth\Domain\DTOs\RegisterDTO;
use Udhuong\PassportAuth\Domain\Entities\AuthUser;

class RegisterAction
{
    public function handle(RegisterDTO $dto): AuthUser
    {
        $user = AuthUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

    }
}