<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'customerName' => $this->customer_name,
            'customerEmail' => $this->customer_email,
            'deliveryType' => $this->delivery_type,
            'paymentMethod' => $this->payment_method,
            'address' => AddressResource::make($this->address)
        ];
    }
}
