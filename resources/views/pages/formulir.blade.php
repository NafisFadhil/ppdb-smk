@extends('layouts.subgeneral', [
	'subtitle' => 'Formulir Pendaftaran'
])

@section('subcontent')
	<form id="myform" action="/formulir" method="post">
		@csrf
		<div class="p-4 md:p-8 grid grid-cols-1 grid-rows-auto max-w-screen-lg mx-auto my-3">

			<?php $input_iterator = 0 ?>

			@foreach($inputs as $input)
				<?php !in_array($input['type'], ['hidden']) ? $input_iterator += 1 : $input_iterator ?>
				@include('subcomponents.formulir_input', ['input' => $input, 'no' => $input_iterator])
			@endforeach

			<div class="mt-3 w-full flex flex-row justify-center items-center gap-2">
				<button
					type="submit"
					class="g-recaptcha p-2 px-6 bg-primary text-white rounded-lg shadow max-w-max"
					data-sitekey="{{ ConfigHelper::get('recaptcha_site_key') }}" 
					data-callback='onSubmit' 
					data-action='submit'
				> 
					Daftar <i class="fa fa-sign-in-alt"></i>
				</button>
			</div>
		</div>

	</form>
@endsection

@push('scripts')
	{{-- <script src="https://www.google.com/recaptcha/api.js?render={{ ConfigHelper::get('recaptcha_site_key') }}"></script> --}}
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script>
		function onSubmit(token) {
			document.getElementById("myform").submit();
		}
	</script>
@endpush