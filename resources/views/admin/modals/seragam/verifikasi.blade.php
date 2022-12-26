@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalVerifikasiSeragam'.$row->id,
		'title' => 'Verifikasi Seragam',
	])

	<form action="/admin/verifikasi/duseragam/seragam/{{ $row->id }}" method="post">
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