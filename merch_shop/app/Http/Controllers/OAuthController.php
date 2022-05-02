<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class OAuthController extends Controller
{
    private const ALLOWED_PROVIDERS = ['vkontakte', 'google'];

    public function getValidatedProvider(string $provider)
    {
        if(!in_array($provider, self::ALLOWED_PROVIDERS, true))
            abort(404);
        return $provider;
    }

    public function processOAuthException(Throwable $exception, string $provider)
    {
        Log::error($exception->getMessage());
        return view('auth.oauth_login_failed', ['provider' => $provider, 'error' => $exception->getMessage()]);
    }

    public function redirectToservice(Request $request, string $provider)
    {
        $provider = $this->getValidatedProvider($provider);
        try {
            $result = Socialite::driver($provider)
                ->scopes(config('services.' . $provider . 'scopes'))
                ->redirect();
        } catch (Throwable $exception) {
            $result = $this->processOAuthException($exception, $provider);
        }

        return $result;
    }

    public function login(Request $request, string $provider)
    {
        $provider = $this->getValidatedProvider($provider);

        try {
            /** @var AbstractUser $socialUser */
            $oauthUser = Socialite::with($provider)->user();
        } catch (Throwable $exception) {
            return $this->processOAuthException($exception, $provider);
        }

        $dbUserByOauthId = User::where("{$provider}_id", $oauthUser->id)->first();
        $dbUserByOauthEmail = User::query()
            ->whereNull("{$provider}_id")
            ->whereNotNull('email')
            ->where('email', $oauthUser->email)->first();

        $oauthUserData = [
            "{$provider}_id" => $oauthUser->getId(),
            "{$provider}_logged_in_at" => Carbon::now(),
        ];

        if ($dbUserByOauthId !== null) {
            $dbUserByOauthId->update($oauthUserData);
            $appAuthUser = $dbUserByOauthId;
        } else {
            $oauthUserData = [
                "{$provider}_id" => $oauthUser->getId(),
                "{$provider}_logged_in_at" => Carbon::now(),
                "{$provider}_registered_at" => Carbon::now(),
            ];

            if ($dbUserByOauthEmail !== null) {
                $dbUserByOauthEmail->update($oauthUserData);
                $appAuthUser = $dbUserByOauthEmail;
            } else {
                $appAuthUser = User::create(array_merge([
                    'name' => $oauthUser->getName() ?? $oauthUser->getNickName(),
                    'email' => $oauthUser->getEmail()
                ], $oauthUserData));
            }
        }

        Auth::login($appAuthUser);
        $request->session()->regenerate();

        return redirect(route('profile'));
    }
}
