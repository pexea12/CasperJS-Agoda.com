<html>
<head>
	<title>Hotel</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


</head>
<body>
	<div class="container">
		<h1>Hotel Price</h1>
		<hr>
		{!! Form::open(['action' => 'HotelController@find']) !!}
			<div class="form-group">
				{!! Form::label('date', 'Date: ') !!}
				{!! Form::input('date', 'date', date('Y-m-d'), ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('currency', 'Currency: ') !!}
				{!! Form::select('currency', $currencyList, [1], ['class' => 'form-control']) !!}
			</div>
	
			<div class="form-group">
				{!! Form::submit('Send', ['class' => 'btn btn-primary form-control']) !!}
			</div>
		{!! Form::close() !!}
		<hr>
		@yield('content')
	</div>
</body>
</html>

