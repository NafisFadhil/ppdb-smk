@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalPembayaran'.$row->id,
		'title' => 'Verifikasi Pembayaran Siswa',
	])

	<form action="/admin/verifikasi-pendaftaran/pembayaran/{{ $row->id }}" method="post">
		@csrf

		{{-- <div class="row"> --}}
			{{-- @foreach ($subinputers as $subinputs) --}}
			{{-- <div class="col-12 col-md-6"> --}}
				@foreach ($subinputs as $input)
				@include('admin.components.input', [
				'input' => $input])
				@endforeach
				{{-- </div> --}}
			{{-- @endforeach --}}
			{{-- </div> --}}

		<div class="form-group text-center">
			<button class="btn btn-secondary">
				<i class="fa fa-check"></i> Verifikasi
			</button>
		</div>

	</form>

	@endcomponent
@endpush