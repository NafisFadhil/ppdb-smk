<?php

$kode = $row->pendaftaran->kode ?? '-';
if (!is_null($row->jurusan->kode) && !empty($row->jurusan->kode )) {
	$kode .= ' / ' . $row->jurusan->kode;
}

$inputs = [
	[
		'name' => 'nama_siswa', 'value' => $row->nama_lengkap,
		'attr' => 'disabled',
	],
	[
		'name' => 'kode', 'value' => $kode,
		'attr' => 'disabled',
	],
	[
		'name' => 'asal_sekolah', 'value' => $row->asal_sekolah,
		'attr' => 'disabled',
	],
	[
		'name' => 'jurusan', 'value' => $row->jurusan->singkatan,
		'attr' => 'disabled',
	],
	[
		'name' => 'asal_sekolah', 'value' => $row->asal_sekolah,
		'attr' => 'disabled',
	],
	[
		'name' => 'nama_sponsorship', 'value' => $row->sponsorship->nama,
		'attr' => 'disabled',
	],
	[
		'name' => 'kelas_sponsorship', 'value' => $row->sponsorship->kelas,
		'attr' => 'disabled',
	],
	[
		'type' => 'number', 'name' => 'no_wa_sponsorship', 'value' => $row->sponsorship->no_wa,
		'attr' => 'disabled',
	],
] ?>

@push('modals')
	@component('admin.components.modal', [
		'id' => $id ?? 'modalVerifikasiSponsorship'.$row->id,
		'title' => 'Verifikasi Sponsorship'
	])

		<form action="/admin/verifikasi/sponsorship/verifikasi/{{ $row->id }}" method="post">
			@csrf

			@foreach ($inputs as $input)
				@include('admin.components.input', [ 'input' => $input, 'size' => 'sm' ])
			@endforeach

			<div class="form-group text-center">
				<button class="btn btn-success">
					<i class="fa fa-pen"></i> Verifikasi Sponsorship
				</button>
			</div>
			
		</form>
	
	@endcomponent
@endpush