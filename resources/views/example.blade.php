<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/{{ $name }}.css">
</head>
<body>
	<h1 class="original">Example Text საცდელი ტექსტი</h1>
	<h1 class="generated">Example Text საცდელი ტექსტი</h1>
	<h2 class="original">Example Text საცდელი ტექსტი</h2>
	<h2 class="generated">Example Text საცდელი ტექსტი</h2>
	<h3 class="original">Example Text საცდელი ტექსტი</h3>
	<h3 class="generated">Example Text საცდელი ტექსტი</h3>
	<h4 class="original">Example Text საცდელი ტექსტი</h4>
	<h4 class="generated small">Example Text საცდელი ტექსტი</h4>
	<h5 class="original">Example Text საცდელი ტექსტი</h5>
	<h5 class="generated small">Example Text საცდელი ტექსტი</h5>
	<h6 class="original">Example Text საცდელი ტექსტი</h6>
	<h6 class="generated small">Example Text საცდელი ტექსტი</h6>

	<style>
		@font-face{
			font-family: "{{ $name }} __original";
			src: url("fonts/original.{{ $ext }}");
		}
		.original{
			font-family: "{{ $name }} __original";
			display: block;
			border-left: 2px solid red;
			padding-left: 2px;
			margin: 2px;
		}
		.generated{
			font-family: "{{ $name }}";
			display: block;
			border-left: 2px solid green;
			padding-left: 2px;
			margin: 2px;
		}
		.generated.small{
			font-family: "{{ $name }} -small-";
		}
		* {
			font-weight: normal;
		}
		body{
			margin: 0;
		}
	</style>
</body>
</html>
