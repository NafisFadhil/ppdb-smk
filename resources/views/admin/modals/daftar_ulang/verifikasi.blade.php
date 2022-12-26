@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalVerifikasiDaftarUlang'.$row->id,
		'title' => 'Verifikasi Daftar Ulang',
	])

	<form action="/admin/verifikasi/duseragam/daftar-ulang/{{ $row->id }}" method="post">
		@csrf

		@foreach ($subinputs as $input)
			@include('admin.components.input', ['input' => $input])
		@endforeach

		<div class="form-group text-center">
			<button class="btn btn-primary">
				<i class="fa fa-check"></i> Verifikasi
			</button>
		</div>

	</form>

	@endcomponent
@endpush