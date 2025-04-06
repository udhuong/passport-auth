<?php

namespace Udhuong\PassportAuth\Domain\ValueObjects;

enum SocialProvider: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';
    case GITHUB = 'github';
}