<!DOCTYPE html>
<html>
<head>
    <title>Refund Processed</title>
</head>
<body>
    <h2 style="font-size:20px; font-weight:bold;">✅ Refund Processed</h2>

    <p>Hello,</p>

    <p>Your refund for order <strong>#{{ $order->id }}</strong> has been successfully completed.</p>

    <p>Refund Amount: <strong>₹{{ $order->total }}</strong></p>

    <br>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
