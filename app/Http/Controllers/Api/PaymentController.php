<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $payment;
    public function __construct(PaymentService $payment) {
        $this->payment = $payment;
    }

    public function verify(Request $request) {
        $payload = $request->all();
        // Implementation depends on gateway — here we just call service
        $result = $this->payment->verify($payload);
        return response()->json($result);
    }
}
