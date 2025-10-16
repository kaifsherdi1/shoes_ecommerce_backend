<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createFromCart($user, $data)
    {
        return DB::transaction(function() use ($user, $data) {
            $cart = Cart::with('items.variant.product')->where('user_id',$user->id)->first();
            if (!$cart || $cart->items->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $subtotal = 0;
            foreach ($cart->items as $item) {
                $subtotal += $item->price * $item->quantity;
            }
            $shipping = 50; // fixed or calculated
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id'=>$user->id,
                'status'=>'pending',
                'subtotal'=>$subtotal,
                'shipping'=>$shipping,
                'total'=>$total,
                'shipping_address'=>$data['shipping_address']
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_variant_id'=>$item->product_variant_id,
                    'name'=>$item->variant?->product?->name ?? 'Product',
                    'quantity'=>$item->quantity,
                    'price'=>$item->price,
                    'total'=>$item->price * $item->quantity
                ]);

                // reduce stock if variant exists
                if ($item->variant) {
                    $variant = $item->variant;
                    $variant->decrement('stock', $item->quantity);
                }
            }

            // empty cart
            $cart->items()->delete();
            return $order->load('items');
        });
    }
}
