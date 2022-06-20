<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => ['required','min:2', 'max:255'],
            'customer_email' => ['required', 'email:rfc'],
            'delivery_type' => ['required'],
            'payment_method' => ['required'],
            'delivery_address.city' => ['required_if:delivery_type, courier'],
            'delivery_address.street' => ['required_if:delivery_type, courier'],
            'delivery_address.house' => ['required_if:delivery_type, courier'],
            'delivery_address.apartments' => ['nullable']
        ];
    }
}
