<?php

namespace Udhuong\PassportAuth\Database\Seeders;

use Illuminate\Database\Seeder;

class OAuthScopesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('oauth_clients')->truncate();
        \DB::table('oauth_scopes')->truncate();
        \DB::table('oauth_client_scopes')->truncate();
        \DB::table('oauth_clients')->insert([
            [
                'id' => 1,
                'name' => 'Laravel-Base Personal Access Client',
                'secret' => 'Ue8OYaxscQIXNzaTBvt1RsPb4xvvKqD7cj3cpJpB',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Laravel-Base Password Grant Client',
                'secret' => 'VoxSPtV94RXdk1iI0zAfr9OjxO7HUUKWg3XcGX2i',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Service A',
                'secret' => 'VpQiAjj4bcNy3k824hYkkTvSuafsFaxqdH9ktncn',
                'provider' => null,
                'redirect' => '',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Service B',
                'secret' => 'Mlywol1309HhETjhAJnbryQAbXsrlY1fyitQCcGP',
                'provider' => null,
                'redirect' => '',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        \DB::table('oauth_scopes')->insert([
            [
                'resource' => 'team_a',
                'scope' => 'team_a:service_a.user.read',
            ],
            [
                'resource' => 'team_a',
                'scope' => 'team_a:service_a.user.write',
            ]
        ]);

        \DB::table('oauth_scopes')->insert([
            [
                'client_id' => 3,
                'scope_id' => 1,
            ]
        ]);
    }
}
