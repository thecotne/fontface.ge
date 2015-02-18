@extends('app')

@section('content')
	{!! Form::open(array('url' => route('font.store'), 'files'=>true)) !!}
		{!! Form::file('files[]', array('multiple'=>true)) !!}
		{!! Form::submit('convert')!!}
	{!! Form::close() !!}
@endsection
