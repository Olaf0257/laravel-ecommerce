<!DOCTYPE html>
<html>
<head>
	<title>Customer Message</title>
</head>
<body>
	<h2>Customer Message</h2>
	
	<h3>
		Customer Name: {{ $request->name }} <br>
		Customer E-mail: {{ $request->email }}
	</h3>

	<br>
	
	<h3>Customer Message:</h3>
	<p style="font-size: 17px">
		{{ $request->message }}
	</p>
</body>
</html>