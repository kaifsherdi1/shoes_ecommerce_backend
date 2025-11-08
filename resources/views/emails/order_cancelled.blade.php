<!DOCTYPE html>
<html>
<head>
    <title>Order Cancelled</title>
</head>
<body>
    <h2 style="font-size:20px; font-weight:bold;">❌ Order Cancelled</h2>

    <p>Hello,</p>

    <p>Your order <strong>#{{ $order->id }}</strong> has been cancelled successfully.</p>

    <p>Status: <strong>{{ $order->status }}</strong></p>

    <br>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
