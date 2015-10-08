@extends('index')

@section('content')

<table class="table">
	<thead>
		<tr>
			<th>Room</th>
			<th>Price ({{ $currency }})</th>
		</tr>
	</thead>
	<tbody>
	@foreach($rooms as $room => $price)
		<tr>
			<td>{{ $room }}</td>
			<td>{{ $price }}</td>
		</tr>
	@endforeach
	<tbody>
</table>
@stop