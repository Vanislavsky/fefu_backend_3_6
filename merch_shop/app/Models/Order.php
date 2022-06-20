<?php

namespace App\Models;

use App\Enums\OrderDeliveryType;
use App\Enums\OrderPaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory;

    public static function createFromRequest(array $data, ?Address $address, Cart $cart, User $user)
    {
        $deliveryTypeEnums = OrderDeliveryType::getConstants();
        $paymentMethodEnums = OrderPaymentMethod::getConstants();

        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $address?->id;
        $order->cart_id = $cart->id;
        $order->customer_name = $data['customer_name'];
        $order->customer_email = $data['customer_email'];
        $order->delivery_type = $deliveryTypeEnums[strtoupper($data['delivery_type'])];
        $order->payment_method = $paymentMethodEnums[strtoupper($data['payment_method'])];
        $order->save();

        return $order;
    }
}
