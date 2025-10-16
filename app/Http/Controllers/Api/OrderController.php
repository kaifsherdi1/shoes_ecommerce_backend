<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function index(Request $request) {
        $orders = $request->user()->orders()->with('items')->get();
        return response()->json($orders);
    }

    public function show($id) {
        $order = Order::with('items')->findOrFail($id);
        return response()->json($order);
    }

    public function checkout(CheckoutRequest $request) {
        $order = $this->orderService->createFromCart($request->user(), $request->validated());
        return response()->json($order, 201);
    }
}
