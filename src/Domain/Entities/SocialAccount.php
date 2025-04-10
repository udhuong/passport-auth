<?php

namespace Udhuong\PassportAuth\Domain\Entities;

use Udhuong\PassportAuth\Domain\ValueObjects\SocialProvider;

class SocialAccount
{
    /**
     * ID của người dùng, provider_id
     */
    public string|int $providerId;

    /**
     * ID của người dùng trong hệ thống
     */
    public int $userId;

    /**
     * Tên đăng nhập của người dùng
     */
    public ?string $nickname;

    /**
     * Tên của người dùng
     */
    public string $name;

    /**
     * Địa chỉ email của người dùng
     */
    public ?string $email;

    /**
     * Đường dẫn đến ảnh đại diện của người dùng
     */
    public string $avatar;

    /**
     * Thông tin của người dùng
     */
    public array $user;

    /**
     * Thông tin của bên thứ 3
     */
    public array $attribute;

    /**
     * Token của bên thứ 3
     */
    public string $token;

    /**
     * Token refresh của bên thứ 3
     */
    public ?string $refreshToken;

    /**
     * Thời gian hết hạn của token
     */
    public int $expiresIn;

    /**
     * Scopes đã được cấp phép
     *
     * @var string[]
     */
    public array $approvedScopes = [];

    /**
     * Tên của provider
     */
    public ?SocialProvider $provider;
}
