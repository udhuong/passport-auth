<?php

namespace Udhuong\PassportAuth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccountModel extends Model
{
    protected $table = 'social_accounts';
    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
    ];

    public function user()
    {
        return $this->belongsTo(config('passport_auth.user_model'));
    }
}
