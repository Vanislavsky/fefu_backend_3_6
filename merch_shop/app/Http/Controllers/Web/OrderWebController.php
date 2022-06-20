<?php

namespace App\Http\Controllers\Web;

use App\Enums\OrderDeliveryType;
use App\Enums\OrderPaymentMethod;
use App\Http\Requests\StoreOrderRequest;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderWebController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('checkout.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $cart = Cart::getOrCreateCart($user, null);
        if ($cart->isEmpty()) {
            return back()->withErrors([
                '' => 'cart is empty'
            ]);
        }
        $address = null;
        if (isset($data['delivery_address']['city'])) {
            $address = Address::createFromRequest($data['delivery_address']);
        }

        $cart->user_id = null;
        $cart->session_id = null;
        $cart->save();

        Order::createFromRequest($data, $address, $cart, $user);

        return redirect(route('profile'));
    }

}
