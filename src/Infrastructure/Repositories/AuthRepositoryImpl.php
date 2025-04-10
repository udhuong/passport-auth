<?php

namespace Udhuong\PassportAuth\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\Contracts\UserModel;
use Udhuong\PassportAuth\Domain\Entities\AuthUser;

class AuthRepositoryImpl implements AuthRepository
{
    /**
     * Revoked the token by ID.
     */
    public function revokedToken(string $tokenId): void
    {
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $tokenId)
            ->update(['revoked' => true]);
    }

    /**
     * Lấy thông tin người dùng theo email.
     */
    public function getUserByEmail(string $email): ?AuthUser
    {
        $data = DB::table('users')
            ->where('email', $email)
            ->first();

        if (empty($data)) {
            return null;
        }

        $user = new AuthUser;
        $user->userId = $data->id;
        $user->name = $data->name;
        $user->email = $data->email;

        return $user;
    }

    /**
     * Lấy thông tin người dùng theo id.
     */
    public function getUserByUserId(int $userId): ?AuthUser
    {
        $data = DB::table('users')
            ->where('id', $userId)
            ->first();

        if (empty($data)) {
            return null;
        }

        $user = new AuthUser;
        $user->userId = $data->id;
        $user->name = $data->name;
        $user->email = $data->email;

        return $user;
    }

    /**
     * Tạo người dùng mới và trả về ID của người dùng đó.
     */
    public function createUserGetId(string $email, string $name, string $password): int
    {
        return DB::table('users')->insertGetId([
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ]);
    }

    /**
     * Lấy token của người dùng theo email.
     */
    public function getTokenByEmail(string $email): ?string
    {
        $user = app(UserModel::class)->where('email', $email)->first();
        if (empty($user)) {
            return null;
        }

        return $user->createToken('access_token')->accessToken;
    }

    /**
     * Lấy danh sách các scopes của client theo client_id.
     */
    public function getScopesByClientId(int $clientId): array
    {
        return DB::table('oauth_client_scopes')
            ->join('oauth_scopes', 'oauth_client_scopes.scope_id', '=', 'oauth_scopes.id')
            ->where('oauth_client_scopes.client_id', $clientId)
            ->pluck('oauth_scopes.scope')
            ->toArray();
    }
}
