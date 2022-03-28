<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageWebController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pages = Page::query()->paginate(5);
        return view('pages', ['pages' => $pages]);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $slug)
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->first();

        if ($page === null)
            abort(404);

        return view('page', ['page' => $page]);
    }
}
