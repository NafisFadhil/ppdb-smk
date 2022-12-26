@extends('layouts.general')

<?php 
$isadmin = request()->is('login/admin');
?>

@section('content')
	<section class="p-4">
		<div class="rounded-lg shadow-lg text-center w-[90vw] max-w-[350px] bg-white p-4 sm:p-6">
			<h1 class="text-4xl font-black font-sans mb-2">Login</h1>

			@if(!$isadmin)
				<p class="text-sm mb-4">Masukkan kode jurusan dan tanggal lahir.</p>
			@else
				<p class="text-sm mb-4">Masukkan username dan password.</p>
			@endif

			<form action="/login{{ $isadmin ? '/admin' : null }}" method="post" class="flex flex-col gap-2">
				@csrf
	
				@foreach ($inputs as $input)
					<?php
						$input = FormHelper::initInput($input);
						$error = $errors->has($input['name']);
					?>
				
					<div class="flex w-full flex-col items-center justify-start relative">
						<input type="{{ $input['type'] }}"
							name="{{ $input['name'] }}"
							id="{{ $input['id'] }}"
							placeholder="{{ $input['placeholder'] }}"
							value="{{ old($input['name']) ?? $input['value'] ?? '' }}"
							class="flex-1 w-full px-3 py-1.5 bg-white backdrop-brightness-95 rounded-lg border
							{{ $error?'border-red-800':'' }} text-center outline-none"
							{!! $input['attr'] !!}
						/>

						@if($input['name'] === 'password' && $input['type'] === 'password')
							<button type="button" data-input="#{{ $input['id'] }}" onclick="toggleEye(this)"
							class="absolute top-0 right-0">
								<i class="fa fa-eye py-2.5 px-3"></i>
							</button>
						@endif
						
						@error($input['name'])
							<p class="col-span-3 text-sm text-red-800">
								<i class="fa fa-exclamation-triangle mr-1"></i> {{ __($message) }}
							</p>
						@enderror
					</div>
				@endforeach			
	
				<button type="submit" class=" py-1.5 px-5 rounded-lg bg-primary text-white hover:opacity-90 mt-2 max-w-max mx-auto">
					Login <i class="fa fa-sign-in-alt"></i>
				</button>
				
			</form>
		</div>
	</section>
@endsection

@push('scripts')
<script>
	function toggleEye(elem) {
		let icon = elem.children[0];
		let target = elem.getAttribute('data-input');
		let input = document.querySelector(target);
		let isPassword = input.getAttribute('type') === 'password';
		if (isPassword) {
			input.setAttribute('type', 'text');
			icon.classList.add('text-primary');
		} else {
			input.setAttribute('type', 'password');
			icon.classList.remove('text-primary');
		}
	}
</script>
@endpush