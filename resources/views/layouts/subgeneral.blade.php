@extends('layouts.general')

@section('content')
	<main class="w-full relative">
		<section class="grid place-items-center bg-primary text-white p-8 lg:p-16">
			<h1 class="md:text-3xl text-2xl font-bold"> {{ $subtitle }} </h1>
		</section>
		@yield('subcontent')
	</main>
@endsection