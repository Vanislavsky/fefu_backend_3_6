<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Responsable;
use App\Http\Controllers\Web\Controller;
use App\OpenApi\Responses\UserResponse;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class UserApiController extends Controller
{
    /**
     * Display user
     *
     * @param Request
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['user'], method: 'GET')]
    #[OpenApi\Response(factory: UserResponse::class, statusCode: 200)]
    public function show(Request $request)
    {
        return $request->user();
    }
}
