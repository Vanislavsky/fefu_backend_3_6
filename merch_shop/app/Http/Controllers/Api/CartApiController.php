<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Requests\CartModificationRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\OpenApi\Responses\CartResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CartApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @param CartModificationRequest $request
     * @return CartResource
     */
    #[OpenApi\Operation(tags: ['cart'], method: 'post')]
    #[OpenApi\Response(factory: CartResponse::class, statusCode: 200)]
    public function __invoke(CartModificationRequest $request)
    {
        $data = $request->validated('modifications');

        $user = Auth::user();
        $session_id = session()->getId();
        $cart = Cart::getOrCreateCart($user, $session_id);

        $productIds = array_column($data, 'product_id');
        $productsById = Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($data as $modification) {
            $cart->setProductQuantity($productsById[$modification['product_id']], $modification['quantity']);
        }

        $cart->recalculateCart();
        $cart->save();

        return new CartResource($cart);
    }
}
