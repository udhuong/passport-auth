<?php

namespace Udhuong\PassportAuth\Presentation\Http\Requests;

use Udhuong\LaravelCommon\Presentation\Http\Requests\ApiRequest;

class RefreshTokenRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'refresh_token' => 'required',
        ];
    }
}
