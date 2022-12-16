@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalPembayaranSeragam'.$row->id,
		'title' => 'Input Pembayaran Seragam',
	])

	<form action="/admin/verifikasi/duseragam/pembayaran/seragam/{{ $row->id }}" method="post">
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
				<i class="fa fa-check"></i> Submit
			</button>
		</div>

	</form>

	@endcomponent
@endpush