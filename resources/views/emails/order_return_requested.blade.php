<!DOCTYPE html>
<html>
<head>
    <title>Return Requested</title>
</head>
<body>
    <h2 style="font-size:20px; font-weight:bold;">🔁 Return Requested</h2>

    <p>Hello,</p>

    <p>Your request for return of order <strong>#{{ $order->id }}</strong> has been submitted.</p>

    <p>Our team will verify the request and update you shortly.</p>

    <br>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
