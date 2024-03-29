@extends('app')

@section('content')
	@foreach ($fonts as $name)
		<a href="/webfonts/{{ $name }}/{{ $name }} [fontface.ge].zip">Download {{ $name }}</a>
		<iframe class="font_review" src="/webfonts/{{ $name }}/example.html"></iframe>
	@endforeach

	<style>
		.font_review{
			display: block;
			border: 0;
			border-bottom: #ccc 1px;
			padding: 0;
			margin: 0;
			height: 400px;
			width: 100%;
		}
		body{
			padding: 30px;
		}
	</style>
@endsection
