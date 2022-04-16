<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Web\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('profile'));
    }
}
