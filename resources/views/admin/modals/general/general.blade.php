@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalPrint'.$row->id,
		'title' => 'Print',
		'size' => 'sm'
	])

	<?php
	$level = auth()->user()->level->name;
	$buttons = [];
	if ($level === 'super-admin') $buttons = [
		['href' => '/admin/laporan/pendaftaran/', 'label' => 'Pendaftaran'],
		['href' => '/admin/laporan/daftar-ulang/', 'label' => 'Daftar Ulang'],
		['href' => '/admin/laporan/seragam/', 'label' => 'Seragam'],
	]; elseif ($level === 'admin-duseragam') $buttons = [
		['href' => '/admin/laporan/pendaftaran/', 'label' => 'Pendaftaran'],
		['href' => '/admin/laporan/daftar-ulang/', 'label' => 'Daftar Ulang'],
	]; elseif ($level === 'admin-pendaftaran') $buttons = [
		['href' => '/admin/laporan/pendaftaran/', 'label' => 'Pendaftaran'],
		['href' => '/admin/laporan/formulir/', 'label' => 'Daftar Ulang'],
	];
	?>

	<div class="row" style="gap: .5rem">
		@foreach ($buttons as $btn)
			<div class="col-12">
				<a href="{{ $btn['href'] }}" target="_blank" class="btn btn-primary btn-block">
					Laporan {!! $btn['label'] !!}
				</a>
			</div>
		@endforeach
	</div>
	
	@endcomponent
@endpush