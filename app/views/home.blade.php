<!DOCTYPE HTML>
<html>
<head>
	<title>fontface.ge</title>
	<script src="bower_components/webcomponentsjs/webcomponents.min.js"></script>
	<link rel="import" href="bower_components/polymer/polymer.html">
</head>
<body>
	<h1>Hi!</h1>
	<h3>upload font or visit <a href="webfonts">gallery</a></h3>
	<p>
		ეს ფონტების კონვერტორი შექმნილია unicode ფონტების ვებში <br>
		ხარვეზების გარეშე გამოსაჩენათ <br>
		კონვერტორი იყენებს <a href="http://fontforge.org/">fontforge</a>-ის <br>
		"autoHint" და "autoInstr" ფუნქციებს
	</p>

	{{ Form::open(array('url' => route('home'), 'files'=>true)) }}
		{{ Form::file('files[]', array('multiple'=>true)) }}
		{{ Form::submit('convert')}}
	{{ Form::close() }}

</body>
</html>

