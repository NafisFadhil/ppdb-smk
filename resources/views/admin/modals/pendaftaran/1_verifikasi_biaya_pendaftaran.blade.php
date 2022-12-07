@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalInputan'.$row->id,
		'title' => 'Input Biaya Pendaftaran'
	])

	<form action="/admin/verifikasi-pendaftaran/biaya/{{ $row->id }}" method="post">
		@csrf

		@foreach ($subinputs as $input)
			@include('admin.components.input', [
				'input' => $input])
		@endforeach

		<div class="form-group text-center">
			<button class="btn btn-secondary">
				Submit
			</button>
		</div>
		
	</form>
	
	@endcomponent
@endpush