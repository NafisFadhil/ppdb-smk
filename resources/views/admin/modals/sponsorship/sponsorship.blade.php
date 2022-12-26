<?php
$edit ??= false;

$modal_title = ($edit ? 'Edit' : 'Input') . ' Siswa Sponsorship';

$last_path = $edit ? 'edit/'.$row->sponsorship->id : $row->id;

$inputs = [
	['name' => 'nama', 'value' => $row->sponsorship->nama??null, 'opts' => ['required', 'uppercase']],
	['name' => 'kelas', 'value' => $row->sponsorship->kelas??null, 'opts' => ['required', 'uppercase']],
	['type' => 'number', 'name' => 'no_wa', 'value' => $row->sponsorship->no_wa??null, 'opts' => ['required']],
	['type' => 'hidden', 'name' => 'identitas_id', 'value' => $row->id??null],
] ?>

@push('modals')
	@component('admin.components.modal', [
		'id' => $id ?? 'modalSponsorship'.$row->id,
		'title' => $modal_title
	])

		<form action="/admin/verifikasi/sponsorship/{{ $last_path }}" method="post">
			@csrf

			@foreach ($inputs as $input)
				@include('admin.components.input', [ 'input' => $input ])
			@endforeach

			<div class="form-group text-center">
				@if($edit)
					<button class="btn btn-warning">
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