<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;

class ProfileWebController extends Controller
{
    public function show()
    {
        return view('profile');
    }
}
