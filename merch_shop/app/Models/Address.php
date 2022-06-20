<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public static function createFromRequest(array $requestData): self
    {
        $address = new self();
        $address->city = $requestData['city'];
        $address->street = $requestData['street'];
        $address->house = $requestData['house'];
        $address->apartment = $requestData['apartment'] ?? null;
        $address->save();

        return $address;
    }
}
