@extends('app')

@section('content')
	<h1>Hi!</h1>
	<h3>upload font or visit <a href="webfonts">gallery</a></h3>
	<p>
		ეს ფონტების კონვერტორი შექმნილია unicode ფონტების ვებში <br>
		ხარვეზების გარეშე გამოსაჩენათ <br>
		კონვერტორი იყენებს <a href="http://fontforge.org/">fontforge</a>-ის <br>
		"autoHint" და "autoInstr" ფუნქციებს
	</p>

	<a href="{{ route('font.create') }}">ფონტის ატვირთვა</a>
@endsection
