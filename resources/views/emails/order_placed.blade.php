<!DOCTYPE html>
<html>
<head>
    <title>Order Placed</title>
</head>
<body>
    <h2>Your order has been placed successfully!</h2>

    <p>Order ID: {{ $order->id }}</p>
    <p>Status: {{ $order->status }}</p>
    <p>Total: ₹{{ $order->total }}</p>

    <hr>

    <h3>Shipping Details:</h3>
    <p>Name: {{ $order->shipping_address['name'] }}</p>
    <p>Address: {{ $order->shipping_address['address'] }}</p>

    <br><br>
    <p>Thank you for shopping!</p>
</body>
</html>
