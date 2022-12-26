<?php 
$inputs = [
	'biaya_duseragam' => function ($row) use ($options) {
		return [
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap,
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'type' => 'number',
				'name' => 'biaya_daftar_ulang',
				'value' => $row->tagihan->biaya_daftar_ulang
			],
			[
				'type' => 'number',
				'name' => 'biaya_seragam',
				'value' => $row->tagihan->biaya_seragam
			],
			[
				'type' => 'select',
				'name' => 'ukuran_olahraga',
				'options' => $options['seragam_olahraga']
			],
			[
				'type' => 'select',
				'name' => 'ukuran_almamater',
				'options' => $options['seragam_almamater']
			],
			[
				'type' => 'select',
				'name' => 'ukuran_wearpack',
				'options' => $options['seragam_wearpack']
			],
			[
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->daftar_ulang->keterangan ?? $row->seragam->keterangan
			],
		];
	},

	'pembayaran_daftar_ulang' => function ($row) {
		return [
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap,
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_daftar_ulang',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang),
				'attr' => 'disabled'
			],
			[
				'name' => 'tagihan_daftar_ulang',
				'value' => NumberHelper::toRupiah($row->tagihan->tagihan_daftar_ulang),
				'attr' => 'disabled'
			],
			[
				'type' => 'number',
				'name' => 'bayar',
				'value' => $row->tagihan->tagihan_daftar_ulang
			],
		];
	},

	'verifikasi_daftar_ulang' => function ($row) {
		return [
			[
				'name' => 'kode_jurusan',
				'value' => $row->jurusan->kode,
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap,
				'attr' => 'disabled'
			],
			[
				'name' => 'jenis_kelamin',
				'value' => ModelHelper::getJenisKelamin($row->jenis_kelamin_id),
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_jurusan',
				'label' => 'Jurusan',
				'value' => StringHelper::toCapital($row->jurusan->singkatan),
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_daftar_ulang',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang),
				'attr' => 'disabled'
			],
			[
				'name' => 'status_pembayaran_daftar_ulang',
				'value' => ModelHelper::getStatusBayar($row->tagihan, 'daftar_ulang'),
				'attr' => 'disabled'
			],
			[
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->daftar_ulang->keterangan ?? '-',
				'attr' => 'disabled'
			],
		];
	},
	
	'pembayaran_seragam' => function ($row) {
		return [
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap,
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_seragam',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_seragam),
				'attr' => 'disabled'
			],
			[
				'name' => 'tagihan_seragam',
				'value' => NumberHelper::toRupiah($row->tagihan->tagihan_seragam),
				'attr' => 'disabled'
			],
			[
				'type' => 'number',
				'name' => 'bayar',
				'value' => $row->tagihan->tagihan_seragam
			],
		];
	},

	'verifikasi_seragam' => function ($row) {
		return [
			[
				'name' => 'kode_jurusan',
				'value' => $row->jurusan->kode,
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap,
				'attr' => 'disabled'
			],
			[
				'name' => 'jenis_kelamin',
				'value' => ModelHelper::getJenisKelamin($row->jenis_kelamin_id),
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_jurusan',
				'label' => 'Jurusan',
				'value' => StringHelper::toCapital($row->jurusan->singkatan),
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_seragam',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_seragam),
				'attr' => 'disabled'
			],
			[
				'name' => 'status_pembayaran_seragam',
				'value' => ModelHelper::getStatusBayar($row->tagihan, 'seragam'),
				'attr' => 'disabled'
			],
			[
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->seragam->keterangan ?? '-',
				'attr' => 'disabled'
			],
		];
	},

];
?>

<table id="xtable" class="w-100 table table-sm table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jalur</th>
			<th>Jenis Kelamin</th>
			<th>Asal Sekolah</th>
			<th>Jurusan</th>
			<th>Status</th>
			<th>Tindakan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($peserta as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->jurusan->kode ?? $row->pendaftaran->kode ?? '-' }}</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
				<td>{{ ModelHelper::getJenisKelamin($row->jenis_kelamin_id) }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ $row->jurusan->singkatan }}</td>
				<td class="text-success" title="{{ $row->status->desc }}">
					{{ $row->status->sublevel }}
				</td>
				<td>
					<div class="btn-group btn-group-sm mb-1">

						{{-- Input Tagihan --}}
						<button type="button" title="Input Tagihan DU & Seragam" data-toggle="modal"
						data-target="#modalBiaya{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 4 ? 'disabled' : '' }} >
							<i class="fa fa-dollar-sign"></i> 
							@if($row->status_id === 4)
								@include('admin.modals.duseragam.1_verifikasi_biaya_duseragam', [
									'row' => $row,
									'subinputs' => $inputs['biaya_duseragam']($row)
								])
							@endif
						</button>

					</div>

					<div class="btn-group btn-group-sm mb-1">

						{{-- Pembayaran DU --}}
						<button type="button" title="Input Pembayaran Daftar Ulang" data-toggle="modal"
						data-target="#modalPembayaranDaftarUlang{{ $row->id }}" class="btn btn-secondary"
						{{ $row->status_id !== 5 || $row->tagihan->lunas_daftar_ulang ? 'disabled' : '' }} >
							<i class="fa fa-dollar-sign">DU</i>
							@if($row->status_id === 5 && !$row->tagihan->lunas_daftar_ulang)
								@include('admin.modals.daftar_ulang.input_pembayaran', [
									'row' => $row,
									'subinputs' => $inputs['pembayaran_daftar_ulang']($row)
								])
							@endif
						</button>
						
						{{-- Verifikasi DU --}}
						<button type="button" title="Verifikasi Daftar Ulang" data-toggle="modal"
						data-target="#modalVerifikasiDaftarUlang{{ $row->id }}" class="btn btn-secondary"
						{{ $row->status_id !== 5 || !$row->tagihan->lunas_daftar_ulang || $row->verifikasi->daftar_ulang ? 'disabled' : '' }} >
							<i class="fa fa-check">DU</i>
							@if($row->status_id === 5 && $row->tagihan->lunas_daftar_ulang && !$row->verifikasi->daftar_ulang)
								@include('admin.modals.daftar_ulang.verifikasi', [
									'row' => $row,
									'subinputs' => $inputs['verifikasi_daftar_ulang']($row)
								])
							@endif
						</button>

					</div>

					<div class="btn-group btn-group-sm mb-1">
						
						{{-- Pembayaran Seragam --}}
						<button type="button" title="Input Pembayaran Seragam" data-toggle="modal"
						data-target="#modalPembayaranSeragam{{ $row->id }}" class="btn btn-secondary"
						{{ $row->status_id !== 5 || $row->tagihan->lunas_seragam ? 'disabled' : '' }} >
							<i class="fa fa-dollar-sign">S</i>
							@if($row->status_id === 5 && !$row->tagihan->lunas_seragam)
								@include('admin.modals.seragam.input_pembayaran', [
									'row' => $row,
									'subinputs' => $inputs['pembayaran_seragam']($row)
								])
							@endif
						</button>

						{{-- Verifikasi Seragam --}}
						<button type="button" title="Verifikasi Seragam" data-toggle="modal"
						data-target="#modalVerifikasiSeragam{{ $row->id }}" class="btn btn-secondary"
						{{ $row->status_id !== 5 || !$row->tagihan->lunas_seragam || $row->verifikasi->seragam ? 'disabled' : '' }} >
							<i class="fa fa-check">S</i>
							@if($row->status_id === 5 && $row->tagihan->lunas_seragam && !$row->verifikasi->seragam)
								@include('admin.modals.seragam.verifikasi', [
									'row' => $row,
									'subinputs' => $inputs['verifikasi_seragam']($row)
								])
							@endif
						</button>

					</div>

					<div class="btn-group btn-group-sm">
						
						{{-- Detail --}}
						{{-- <button type="button" title="Detail Siswa" data-toggle="modal"
						data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" disabled>
							<i class="fa fa-eye"></i> 
						</button> --}}

						{{-- Tagihan --}}
						<a href="/admin/tagihan/{{ $row->id }}" title="Detail Tagihan"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa">T</i>
						</a>

						{{-- Detail Pembayaran DU --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=daftar_ulang" title="Detail Pembayaran Daftar Ulang"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">DU</i>
						</a>

						{{-- Detail Pembayaran Seragam --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=seragam" title="Detail Pembayaran Seragam"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">S</i>
						</a>
						
						{{-- Edit --}}
						<a href="/admin/edit/{{ $row->id }}" title="Edit Data DU & Seragam"
						class="btn btn-warning">
							<i class="fa fa-pen"></i> 
						</a>
						
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>