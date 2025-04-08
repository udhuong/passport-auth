<?php

namespace Udhuong\PassportAuth;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use Udhuong\PassportAuth\Domain\Contracts\AuthRepository;
use Udhuong\PassportAuth\Domain\Contracts\SocialAccountRepository;
use Udhuong\PassportAuth\Domain\Contracts\UserModel;
use Udhuong\PassportAuth\Domain\Validate\CustomClientCredentialsGrant;
use Udhuong\PassportAuth\Infrastructure\Repositories\AuthRepositoryImpl;
use Udhuong\PassportAuth\Infrastructure\Repositories\SocialAccountRepositoryImpl;

class PassportAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/passport_auth.php', 'passport_auth');
    }

    public function boot(): void
    {
        $this->registerRepository();

        $this->app->singleton(UserModel::class, function ($app) {
            return $app->make(config('passport_auth.user_model'));
        });

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Nếu cần publish config cho project sử dụng
        // php artisan vendor:publish --tag=passport-auth-config
        $this->publishes([
            __DIR__ . '/../config/passport_auth.php' => config_path('passport_auth.php'),
        ], 'passport-auth-config');

        $this->customPassport();
    }

    private function registerRepository(): void
    {
        $this->app->bind(AuthRepository::class, AuthRepositoryImpl::class);
        $this->app->bind(SocialAccountRepository::class, SocialAccountRepositoryImpl::class);
    }

    private function customPassport(): void
    {
        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        if (Schema::hasTable('oauth_scopes')) {
            $scopes = \DB::table('oauth_scopes')->pluck('id', 'scope')->toArray();
        } else {
            $scopes = [];
        }
        Passport::tokensCan($scopes); //Cần tối ưu lại
    }
}
