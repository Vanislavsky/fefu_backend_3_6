<?php

namespace App\Http\Controllers\Web;

use function view;

class ProfileWebController extends Controller
{
    public function show()
    {
        return view('profile');
    }
}
