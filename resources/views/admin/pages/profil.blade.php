@extends('layouts.admin')

<?php
$user = auth()->user();
$inputs = [
	['type' => 'file', 'name' => 'avatar', 'label' => null, 'value' => $user->avatar],
	['type' => 'text', 'name' => 'name', 'label' => 'Nama Admin', 'value' => $user->name, 'attr' => 'disabled'],
	['type' => 'text', 'name' => 'username', 'label' => null, 'value' => $user->username, 'attr' => 'disabled'],
	['type' => 'password', 'name' => 'password', 'label' => 'Password Baru', 'placeholder' => ''],
]
?>

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="mx-auto text-center mb-3" style="max-width: max-content">
						<img src="{{ $user->avatar }}" alt="User Avatar Image" width="160" class="img-circle elevation-1">
						<br>
					</div>

					<form action="/admin/profil" method="post" enctype="multipart/form-data">
						@csrf
						
						@foreach ($inputs as $input)
							@include('admin.components.input', ['input' => $input])
						@endforeach

						<button type="submit" class="btn btn-primary btn-block mx-auto" style="max-width: max-content">
							<i class="fa fa-pen"></i> Ubah Profil
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection