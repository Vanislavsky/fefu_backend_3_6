<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Web\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\OpenApi\RequestBodies\OrderRequestBody;
use App\OpenApi\Responses\EmptyCartResponse;
use App\OpenApi\Responses\ErrorCreateOrderResponse;
use App\OpenApi\Responses\OrderResponse;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class OrderApiController extends Controller
{
    /**
     * send new order
     */
    #[OpenApi\Operation(tags: ['cart'], method: 'post')]
    #[OpenApi\RequestBody(factory: OrderRequestBody::class)]
    #[OpenApi\Response(factory: OrderResponse::class, statusCode: 200)]
        #[OpenApi\Response(factory: ErrorCreateOrderResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: EmptyCartResponse::class, statusCode: 422)]
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $cart = Cart::getOrCreateCart($user, null);
        if ($cart->isEmpty()) {
            return new JsonResponse([
                'message' => 'cart is empty'
            ], status: 422);
        }

        $address = null;
        if (isset($data['delivery_address']['city'])) {
            $address = Address::createFromRequest($data['delivery_address']);;
        }

        $cart->user_id = null;
        $cart->session_id = null;
        $cart->save();

        $order = Order::createFromRequest($data, $address, $cart, $user);

        return new OrderResource($order);
    }
}
