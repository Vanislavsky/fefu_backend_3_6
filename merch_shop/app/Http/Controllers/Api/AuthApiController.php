<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Responsable;
use App\Http\Controllers\Web\Controller;
use App\Http\Requests\LoginApiFormRequest;
use App\Http\Requests\RegisterApiFormRequest;
use App\Models\User;
use App\OpenApi\Parameters\LoginParameters;
use App\OpenApi\Parameters\RegisterParameters;
use App\OpenApi\Responses\ErrorAuthResponse;
use App\OpenApi\Responses\SuccessAuthResponse;
use App\OpenApi\Responses\SuccessLogoutResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use function response;

#[OpenApi\PathItem]
class AuthApiController extends Controller
{
    /**
     * Login
     *
     * @param LoginApiFormRequest
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Parameters(factory: LoginParameters::class)]
    #[OpenApi\Response(factory: SuccessAuthResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorAuthResponse::class, statusCode: 422)]
    public function login(LoginApiFormRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('myapitoken')->plainTextToken;

            return response()->json([
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => [
                'email' => 'wrong email or password',
                'password' => 'wrong email or password'
            ],
        ], 422);
    }

    /**
     * Logout
     *
     * @param Request
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Response(factory: SuccessLogoutResponse::class, statusCode: 200)]
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logged out',
        ]);
    }

    /**
     * Register
     *
     * @param RegisterApiFormRequest
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Parameters(factory: RegisterParameters::class)]
    #[OpenApi\Response(factory: SuccessAuthResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorAuthResponse::class, statusCode: 422)]
    public function register(RegisterApiFormRequest $request)
    {
        $data = $request->validated();

        $user = User::createFromRequest($data);
        $token = $user->createToken('myapitoken')->plainTextToken;

        return response()->json([
           'token' => $token,
        ]);
    }
}
