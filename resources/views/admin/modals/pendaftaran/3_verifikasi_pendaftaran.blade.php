@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalVerifikasi'.$row->id,
		'title' => 'Verifikasi Pendaftaran',
	])

	<form action="/admin/verifikasi/pendaftaran/verifikasi/{{ $row->id }}" method="post">
		@csrf

		{{-- <div class="row"> --}}
			{{-- @foreach ($subinputs as $subinput) --}}
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