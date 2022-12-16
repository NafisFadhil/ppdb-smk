<?php
$edit ??= false;
$inputs = [
	['name' => 'nama', 'value' => $row->sponsorship->nama??null, 'opts' => ['required', 'uppercase']],
	['name' => 'kelas', 'value' => $row->sponsorship->kelas??null, 'opts' => ['required', 'uppercase']],
	['type' => 'number', 'name' => 'no_wa', 'value' => $row->sponsorship->no_wa??null, 'opts' => ['required']],
	['type' => 'hidden', 'name' => 'identitas_id', 'value' => $row->id??null],
] ?>

@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalSponsorship'.$row->id,
		'title' => ($edit ? 'Edit' : 'Input') . ' Siswa Sponsorship'
	])

		<form action="/admin/verifikasi/sponsorship{{ $edit ? '/edit/'.$row->id :'' }}" method="post">
			@csrf

			@foreach ($inputs as $input)
				@include('admin.components.input', [ 'input' => $input ])
			@endforeach

			<div class="form-group text-center">
				@if($edit)
					<button class="btn btn-warning text-white">
						<i class="fa fa-pen"></i> Edit Sponsorship
				@else
					<button class="btn btn-primary">
						<i class="fa fa-plus"></i> Tambah Sponsorship
					@endif
				</button>
			</div>
			
		</form>
	
	@endcomponent
@endpush