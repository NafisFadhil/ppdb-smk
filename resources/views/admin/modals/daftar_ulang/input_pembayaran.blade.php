@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalPembayaranDaftarUlang'.$row->id,
		'title' => 'Input Pembayaran Daftar Ulang',
	])

	<form action="/admin/verifikasi/duseragam/pembayaran/daftar-ulang/{{ $row->id }}" method="post">
		@csrf

		@foreach ($subinputs as $input)
			@include('admin.components.input', ['input' => $input])
		@endforeach

		<div class="form-group text-center">
			<button class="btn btn-primary">
				<i class="fa fa-check"></i> Submit
			</button>
		</div>

	</form>

	@endcomponent
@endpush