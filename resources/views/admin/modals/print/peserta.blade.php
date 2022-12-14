@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalPrint'.$row->id,
		'title' => 'Print',
		'size' => 'sm'
	])

	<?php $buttons = [
		['href' => '/admin/cetak/pendaftaran/'.$row->id, 'label' => 'Pendaftaran'],
		['href' => '/admin/cetak/formulir/'.$row->id, 'label' => 'Formulir'],
	] ?>

	<div class="row" style="gap: .5rem">
		@foreach ($buttons as $btn)
			<div class="col-12">
				@include('admin.modals.print.btn', ['btn' => $btn])
			</div>
		@endforeach
		<p class="text-center mx-auto">
			Lainnya dalam proses <br> pengembangan...
		</p>
	</div>
	
	@endcomponent
@endpush