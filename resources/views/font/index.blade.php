@extends('app')

@section('content')

@foreach ($fonts as $font)
	<div>
		<a href="/font/{{ $font->fontFamily }}">{{ $font->fontFamily }}</a>
	</div>
@endforeach

@endsection
