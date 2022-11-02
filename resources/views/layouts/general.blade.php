@extends('layouts.main')

@section('body')
	<div id="wrapper" class="wrapper w-full min-h-screen bg-gray-100 flex flex-col">
		@include('components.navbar')
		<div id="content" class="flex-1">
			@yield('content')
		</div>
		@include('components.footer')
	</div>
@endsection