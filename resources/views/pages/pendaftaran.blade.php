@extends('layouts.subgeneral', [
	'subtitle' => 'Formulir Pendaftaran'
])

@section('subcontent')
	<form action="/pendaftaran" method="post">
		@csrf
		<div class="p-4 md:p-8 grid grid-cols-1 grid-rows-auto max-w-screen-lg mx-auto">

			@foreach($inputs as $input)
				@include('subcomponents.formulir_inputs', ['input' => $input])
			@endforeach
			
			<button type="submit" class="mt-3 p-2 px-6 bg-primary text-white rounded-lg shadow max-w-max mx-auto hover:">
				Daftar
			</button>
		</div>

	</form>
@endsection