@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalBiaya'.$row->id,
		'title' => 'Input Biaya Daftar Ulang & Seragam'
	])

	<form action="/admin/verifikasi/duseragam/biaya-duseragam/{{ $row->id }}" method="post">
		@csrf

		@foreach ($subinputs as $input)
			@include('admin.components.input', [
				'input' => $input])
		@endforeach

		<div class="form-group text-center">
			<button class="btn btn-primary">
				Submit
			</button>
		</div>
		
	</form>
	
	@endcomponent
@endpush