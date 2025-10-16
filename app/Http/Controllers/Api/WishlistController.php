<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected function getWishlist($user) {
        return Wishlist::firstOrCreate(['user_id'=>$user->id]);
    }

    public function index(Request $request) {
        $w = $this->getWishlist($request->user());
        $w->load('items.product');
        return response()->json($w);
    }

    public function add(Request $request) {
        $data = $request->validate(['product_id'=>'required|integer|exists:products,id']);
        $w = $this->getWishlist($request->user());

        $existing = $w->items()->where('product_id', $data['product_id'])->first();
        if ($existing) return response()->json($existing, 200);

        $item = WishlistItem::create([
            'wishlist_id'=>$w->id,
            'product_id'=>$data['product_id']
        ]);

        return response()->json($item, 201);
    }

    public function remove(Request $request) {
        $data = $request->validate(['product_id'=>'required|integer|exists:products,id']);
        $w = $this->getWishlist($request->user());
        $w->items()->where('product_id', $data['product_id'])->delete();
        return response()->json(null,204);
    }
}
