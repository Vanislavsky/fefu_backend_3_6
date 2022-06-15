<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartWebController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $session_id = session()->getId();
        $cart = Cart::getOrCreateCart($user, $session_id);

        return view('cart.cart', ['cart' => new CartResource($cart)]);
    }
}
