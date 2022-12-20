@extends('layouts.landingpage')

@section('main')
	<form id="myform" action="/formulir" method="post">
		@csrf

		<div class="container p-3 p-md-5">
			<?php $input_iterator = 0 ?>
			
			<div class="text-center mt-4 mb-5 w-100">
				<h2 class="fw-bold mb-1">Formulir Pendaftaran</h2>
				<p class="">Masukkan identitas siswa dibawah ini.</p>
			</div>
			
			@foreach($inputs as $input)
				<?php !in_array($input['name'], ['sub_jalur_pendaftaran_id']) ? $input_iterator += 1 : $input_iterator ?>
				
				@include('landingpage.components.input', ['input' => $input, 'no' => $input_iterator])
			@endforeach

			<div class="mt-3 w-100 text-center">
				<button type="submit" class="btn btn-primary mx-auto px-4" style="max-width: max-content"> 
					Daftar <i class="fa fa-sign-in-alt"></i>
				</button>
			</div>
						
		</div>
		
	</form>
@endsection

@push('styles')
	<style>
		label.input-titiks {position: relative}
		@media screen and (min-width: 768px) {
			label.input-titiks::after {
				content: ':';
				display: grid;
				position: absolute;
				right: -7px;
				top: 0;
			}
		}
	</style>
@endpush

@push('scripts')
	{{-- <script src="https://www.google.com/recaptcha/api.js?render={{ ConfigHelper::get('recaptcha_site_key') }}"></script> --}}
	{{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}
	<script>
		// function onSubmit(token) {
		// 	document.getElementById("myform").submit();
		// }
		let jalurs = document.querySelectorAll('input[name=jalur_pendaftaran_id]');
		let jalurPrestasi = document.querySelector('select[name=sub_jalur_pendaftaran_id]');
		// console.log(jalurPrestasi);
		// document.addEventListener('DOMContentLoaded', () => {
			jalurPrestasi.style.display = 'none';
		// });
		jalurs.forEach(elem => {
			elem.onclick = () => {
				let value = elem.value;
				if (value == 3) {
					jalurPrestasi.style.display = 'inline-block';
				} else jalurPrestasi.style.display = 'none';
			}
			if (elem.hasAttribute('checked')) elem.click();
		})
	</script>
@endpush