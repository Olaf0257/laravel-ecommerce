<!DOCTYPE html>
<html>
<head>
	<title>Transactional Email</title>

	<style>
		.btn {
	        background: #212121;
	        color: #e9e9e9 !important;
	        border-radius: 5px;
	        padding: 12px 50px;
	        text-decoration: none;
	    }

        .btn:hover {
            background: lighten(#212121, 10%);
        }
	</style>
</head>
<body>
	<h3>Hello, {{ $order->user ? $order->user->name : $order->cc_first_name.' '.$order->cc_last_name }}</h3>
	<h2>Thank you for your order.</h2>
	
	<h3>You will find a summary of your recent purchase below.</h3>
	
	<p style="font-size: 17px">
		Order ID: {{ $order->id }} <br>
		Order Tax: {{ presentPrice($order->tax) }} <br>
		@if ($order->discount) 
			Order Discount: {{ presentPrice($order->discount) }} <br> 
		@endif
		Order Total: {{ presentPrice($order->total) }} <br>
		Payment Method: {{ $order->payment_gateway == 'paytabs' ? 'Credit Card' : ucfirst($order->payment_gateway) }}
	</p>

	<hr style="color: #eee">

	<h3>Items Ordered</h3>
	<p>
		@foreach ($order->products as $product)
			<p style="font-size: 16px">
				Item Name: {{ $product->name }} <br>
				Item Price: {{ presentPrice($product->price) }} <br>
				Item Quantity: {{ $product->pivot->quantity }}
			</p>
			<hr style="margin: 0 200px 0 0;color: #ebebeb">
		@endforeach
	</p> <br>


	<p>You can get further details about your order by logging into our website.</p>
	<a class="btn" href="{{ config('app.url') }}">Go to Website</a> <br> <br>

	<p>Thank you again for choosing us.</p>
	<p>regards,</p>
	<p>{{ config('app.name') }}</p>
</body>
</html>