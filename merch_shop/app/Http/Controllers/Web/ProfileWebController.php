<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use function view;

class ProfileWebController extends Controller
{
    public function show(Request $request)
    {
        return view('profile', ['user' => (new UserResource(Auth::user()))->toArray($request), 'login_way' => session('login_way', 'app')]);
    }
}
