<?php

namespace Udhuong\PassportAuth\Domain\ValueObjects;

enum SocialProvider: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';
    case GITHUB = 'github';
    case GITLAB = 'gitlab';
    case BITBUCKET = 'bitbucket';
    case SLACK = 'slack';
    case X = 'x';
    case SLACK_OPENID = 'slack-openid';
    case LINKEDIN_OPENID = 'linkedin-openid';
}
