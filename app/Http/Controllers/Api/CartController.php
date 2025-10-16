<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function getCart($user) {
        return Cart::firstOrCreate(['user_id'=>$user->id]);
    }

    public function index(Request $request) {
        $cart = $this->getCart($request->user());
        $cart->load('items.variant.product');
        return response()->json($cart);
    }

    public function add(Request $request) {
        $data = $request->validate([
            'variant_id'=>'nullable|integer|exists:product_variants,id',
            'product_id'=>'nullable|integer|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ]);

        $cart = $this->getCart($request->user());

        // If variant specified use it otherwise create a simple item
        $price = 0;
        $variantId = $data['variant_id'] ?? null;
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $variant->price ?? $variant->product->price;
        } else {
            $price = \App\Models\Product::findOrFail($data['product_id'])->price;
        }

        $item = CartItem::create([
            'cart_id'=>$cart->id,
            'product_variant_id'=>$variantId,
            'quantity'=>$data['quantity'],
            'price'=>$price
        ]);

        return response()->json($item, 201);
    }

    public function remove(Request $request) {
        $data = $request->validate(['item_id'=>'required|integer|exists:cart_items,id']);
        $item = CartItem::findOrFail($data['item_id']);
        $item->delete();
        return response()->json(null, 204);
    }
}
