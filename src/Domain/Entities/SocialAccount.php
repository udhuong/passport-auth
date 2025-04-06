<?php

namespace Udhuong\PassportAuth\Domain\Entities;

use Udhuong\PassportAuth\Domain\ValueObjects\SocialProvider;

class SocialAccount
{
    /**
     * ID của người dùng, provider_id
     * @var string|int $providerId
     */
    public string|int $providerId;

    /**
     * ID của người dùng trong hệ thống
     * @var int $userId
     */
    public int $userId;

    /**
     * Tên đăng nhập của người dùng
     * @var string|null $nickname
     */
    public ?string $nickname;

    /**
     * Tên của người dùng
     * @var string $name
     */
    public string $name;

    /**
     * Địa chỉ email của người dùng
     * @var string|null $email
     */
    public ?string $email;

    /**
     * Đường dẫn đến ảnh đại diện của người dùng
     * @var string $avatar
     */
    public string $avatar;

    /**
     * Thông tin của người dùng
     * @var array $user
     */
    public array $user;

    /**
     * Thông tin của bên thứ 3
     * @var array $attribute
     */
    public array $attribute;
    /**
     * Token của bên thứ 3
     * @var string $token
     */
    public string $token;

    /**
     * Token refresh của bên thứ 3
     * @var string|null $refreshToken
     */
    public ?string $refreshToken;

    /**
     * Thời gian hết hạn của token
     * @var int $expiresIn
     */
    public int $expiresIn;

    /**
     * Scopes đã được cấp phép
     * @var $approvedScopes string[]
     */
    public array $approvedScopes = [];

    /**
     * Tên của provider
     * @var ?SocialProvider $provider
     */
    public ?SocialProvider $provider;
}
