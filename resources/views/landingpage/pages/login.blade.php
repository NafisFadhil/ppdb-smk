@extends('layouts.landingpage')

<?php 
$variant = $variant??'siswa' === 'admin' ? '/admin' : '';
?>

@section('main')
	<div class="container h-100 d-grid p-2" style="place-items: center">
		<div class="card w-100 rounded-2" style="max-width: 325px">
			<div class="card-body text-center">
				<form action="/login{{ $variant }}" method="post">
					@csrf
					
					<h2 class="fw-bolder my-2">Login</h2>
					<div class="my-3">
						@foreach($inputs as $input)
							@include('landingpage.components.input', ['input' => [
								...$input, 'variant' => 'nolabel',
								'size' => 'base',
								'style' => 'text-align: center',
								'class' => 'text-base text-md'
								]])
						@endforeach
					</div>
					<button type="submit" class="btn btn-primary mx-auto">
						Login <i class="fa fa-sign-in-alt"></i>
					</button>

				</form>
			</div>
		</div>
	</div>
@endsection