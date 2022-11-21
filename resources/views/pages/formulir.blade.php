@extends('layouts.subgeneral', [
	'subtitle' => 'Formulir Pendaftaran'
])

@section('subcontent')
	<form action="/formulir" method="post">
		@csrf
		<div class="p-4 md:p-8 grid grid-cols-1 grid-rows-auto max-w-screen-lg mx-auto my-3">

			<?php $input_iterator = 0 ?>

			@foreach($inputs as $input)
				<?php !in_array($input['type'], ['hidden']) ? $input_iterator += 1 : $input_iterator ?>
				@include('subcomponents.formulir_input', ['input' => $input, 'no' => $input_iterator])
			@endforeach
			
			<div class="mt-3 w-full flex flex-row justify-center items-center gap-2">
				<button type="submit" class="p-2 px-6 bg-primary text-white rounded-lg shadow max-w-max">
					Daftar <i class="fas fa-sign-in-alt"></i>
				</button>
			</div>
		</div>

	</form>
@endsection