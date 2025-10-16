<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest {
    public function authorize() { return $this->user() != null; }
    public function rules() {
        return [
            'shipping_address'=>'required|array',
            'shipping_address.name'=>'required|string',
            'shipping_address.line1'=>'required|string',
            'shipping_address.city'=>'required|string',
            'shipping_address.postal_code'=>'required|string',
            'payment_method'=>'required|string' // e.g., 'stripe' or 'cod'
        ];
    }
}
