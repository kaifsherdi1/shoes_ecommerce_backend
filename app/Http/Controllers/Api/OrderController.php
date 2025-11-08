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
    $user = $request->user();
    $order = $this->orderService->createFromCart($user, $request->validated());

    // Send email
    \Mail::to($user->email)->send(new \App\Mail\OrderPlacedMail($order));

    return response()->json($order, 201);
}

    public function cancel($id, Request $request)
{
    $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

    if (!in_array($order->status, ['pending', 'processing'])) {
        return response()->json(['message' => 'Order cannot be cancelled now'], 400);
    }

    // update main current status
    $order->update(['status' => 'cancelled']);

    // add history log
    $order->statuses()->create([
        'status' => 'cancelled',
        'note' => 'Cancelled by user'
    ]);
    \Mail::to($request->user()->email)->send(new \App\Mail\OrderCancelledMail($order));


    return response()->json(['message' => 'Order cancelled successfully']);
}
public function requestReturn($id, Request $request)
{
    $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

    if($order->status !== 'delivered') {
        return response()->json(['message' => 'Order not delivered yet'], 400);
    }

    // check delivered within 7 days
    if(now()->diffInDays($order->updated_at) > 7) {
        return response()->json(['message' => 'Return window expired'], 400);
    }

    // update order
    $order->update(['status' => 'return_requested']);

    // add history
    $order->statuses()->create([
        'status' => 'return_requested',
        'note' => 'User requested return'
    ]);
\Mail::to($request->user()->email)->send(new \App\Mail\OrderReturnRequestedMail($order));

    return response()->json(['message' => 'Return requested successfully']);
}
public function approveReturn($id)
{
    $order = Order::findOrFail($id);

    if($order->status !== 'return_requested') {
        return response()->json(['message' => 'Return not requested'], 400);
    }

    // mark order as returned
    $order->update(['status' => 'returned']);

    // add history
    $order->statuses()->create([
        'status' => 'returned',
        'note' => 'Return approved by admin'
    ]);

    return response()->json(['message' => 'Return approved']);
}
public function processRefund($id)
{
    $order = Order::findOrFail($id);

    if($order->status !== 'returned') {
        return response()->json(['message' => 'Return not approved yet'], 400);
    }

    // Razorpay refund code
    $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    $paymentId = $order->payment_meta['payment_id'] ?? null;

    if(!$paymentId) {
        return response()->json(['message' => 'No Payment ID found'], 400);
    }

    $refund = $api->payment->fetch($paymentId)->refund([
        'amount' => $order->total * 100
    ]);

    $order->update(['status'=>'refunded']);

    $order->statuses()->create([
        'status'=>'refunded'
    ]);
\Mail::to($order->user->email)->send(new \App\Mail\OrderRefundedMail($order));

    return response()->json(['message'=>'Refund processed']);
}
public function adminUpdateStatus($id, Request $request)
{
    $request->validate([
        'status' => 'required|in:processing,shipped,out_for_delivery,delivered'
    ]);

    $order = Order::findOrFail($id);

    $order->update(['status'=>$request->status]);

    $order->statuses()->create([
        'status'=>$request->status,
        'note'=>'Admin updated status'
    ]);

    return response()->json([
        'message' => 'Order status updated',
        'order' => $order
    ]);
}
public function adminList()
{
    $orders = Order::with('user','items')->latest()->get();
    return response()->json($orders);
}



}
