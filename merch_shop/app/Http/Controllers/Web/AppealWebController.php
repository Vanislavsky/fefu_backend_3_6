<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\AppealWebFormRequest;
use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;
use function redirect;
use function view;

class AppealWebController extends Controller
{
    public function form()
    {
        return view('appeal', ['success' => session('success', false)]);
    }

    public function send(AppealWebFormRequest $request)
    {
        $data = $request->validated();

        $appeal = new Appeal();
        $appeal->name = $data['name'];
        $appeal->phone = PhoneSanitizer::sanitize($data['phone']);
        $appeal->email = $data['email'];
        $appeal->message = $data['message'];
        $appeal->save();

        return redirect(route('appeal.form'))->with(['success' => true]);
    }
}
