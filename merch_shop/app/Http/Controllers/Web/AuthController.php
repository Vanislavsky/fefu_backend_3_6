<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function back;
use function redirect;
use function view;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function regiserForm()
    {
        return view('auth.register');
    }

    public function login(LoginFormRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data, true)) {
            $request->session()->regenerate();

            return redirect(route('profile'));
        }

        return back()->with([
            'email' => 'invalid'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(RegisterFormRequest $request)
    {
        $data = $request->validated();
        $user = User::createFromRequest($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('profile'));
    }
}
