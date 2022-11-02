@extends('layouts.main')

@section('body')
	<div id="wrapper" class="wrapper w-full min-h-screen bg-gray-100">
		@include('components.navbar')
		<div id="content">
			@yield('content')
		</div>
		@include('components.footer')
	</div>
@endsection