@extends('app')

@section('content')

@foreach ($fonts as $font)
	<div>
		<a href="/font/{{ $font }}">{{ $font }}</a>
	</div>
@endforeach

@endsection
