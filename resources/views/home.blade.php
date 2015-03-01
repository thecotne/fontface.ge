@extends('app')

@section('content')
	<section vertical center-justified layout>
		<div horizontal center-justified layout class="homepage">
			<summary>
				<h1 class="homepage-title">welcome to fontface.ge</h1>
				<p class="homepage-line2">
					we make life easier
				</p>
				<p class="homepage-line3">
					<a href="{{ route('font.create') }}">
						<paper-button raised unresolved>
							upload file
						</paper-button>
					</a>
					or
					<a href="/font">
						<paper-button raised unresolved>
							visit gallery
						</paper-button>
					</a>
				</p>
			</summary>
		</div>
	</section>
@endsection
