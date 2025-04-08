<?php

namespace Udhuong\PassportAuth\Presentation\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;
use Udhuong\PassportAuth\Domain\Actions\ClientGetTokenAction;
use Udhuong\PassportAuth\Presentation\Http\Requests\ClientGetTokenRequest;
use Udhuong\PassportAuth\Presentation\Http\Response\GetTokenResponse;

class ClientCredentialController
{
    public function __construct(
        private readonly ClientGetTokenAction $clientGetTokenAction
    ) {
    }

    /**
     * Client lấy token để server gọi server
     *
     * @param ClientGetTokenRequest $request
     * @return JsonResponse
     * @throws ConnectionException
     * @throws AppException
     */
    public function getToken(ClientGetTokenRequest $request): JsonResponse
    {
        $token = $this->clientGetTokenAction->handle($request->toDto());
        return Responder::success(
            GetTokenResponse::format($token),
            'Đăng nhập thành công'
        );
    }
}
