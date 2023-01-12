<?php 
$inputs = [
	'biaya' => function ($row) {
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
				'name' => 'biaya_pendaftaran',
				'value' => $row->tagihan->biaya_pendaftaran
			],
			[
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->pendaftaran->keterangan
			],
		];
	},

	'pembayaran' => function ($row) {
		return [
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_pendaftaran',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'tagihan_pendaftaran',
				'value' => NumberHelper::toRupiah($row->tagihan->tagihan_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'keterangan',
				'value' => $row->pendaftaran->keterangan,
				'attr' => 'disabled'
			],
			[
				'type' => 'number',
				'name' => 'bayar',
				'value' => $row->tagihan->tagihan_pendaftaran
			],
		];
	},

	'verifikasi' => function ($row) {
		return [
			[
				'name' => 'kode',
				'value' => $row->pendaftaran->kode ?? '-' ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'jenis_kelamin',
				'value' => ModelHelper::getJenisKelamin($row->jenis_kelamin_id) ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'asal_sekolah',
				'value' => $row->asal_sekolah,
				'attr' => 'disabled'
			],
			[
				'name' => 'jurusan',
				'value' => StringHelper::toCapital($row->jurusan->singkatan ?? ''),
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_pendaftaran',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_pendaftaran ?? ''),
				'attr' => 'disabled'
			],
			[
				'name' => 'status_pembayaran',
				'value' => $row->tagihan->lunas_pendaftaran ? 'Lunas' : 'Belum Lunas',
				'attr' => 'disabled'
			],
			[
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->pendaftaran->keterangan,
				'attr' => 'disabled'
			],
		];
	}
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
			<th>Tanggal Lahir</th>
			<th>Jurusan</th>
			<th>Status</th>
			<th>Tindakan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($peserta as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->pendaftaran->kode ?? '-' }}</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
				<td>{{ ModelHelper::getJenisKelamin($row->jenis_kelamin_id) }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ ModelHelper::formatTanggal($row->tanggal_lahir) }}</td>
				<td>{{ StringHelper::toCapital($row->jurusan->singkatan) }}</td>
				<td class="text-success" title="{{ $row->status->desc }}">
					{{ $row->status->sublevel }}
				</td>
				<td>
					<?php 
							$xpembayaran = isset($row->tagihan->biaya_pendaftaran);
							$xpembayaransiswa = isset($row->pendaftaran->pembayaran_siswa);
							$xverifikasi = $row->pendaftaran->verifikasi_pendaftaran ?? false;
							
						?>

					<div class="btn-group btn-group-sm mb-1">
						{{-- Input Pembayaran --}}
						<button type="button" title="Input Tagihan" data-toggle="modal"
						data-target="#modalBiaya{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 1 ? 'disabled' : '' }} >
							<i class="fa fa-dollar-sign"></i> 
							@if($row->status_id === 1)
								@include('admin.modals.pendaftaran.1_verifikasi_biaya_pendaftaran', [
									'row' => $row,
									'subinputs' => $inputs['biaya']($row)
								])
							@endif
						</button>

						{{-- Input Pembayaran --}}
						<button type="button" title="Input Pembayaran" data-toggle="modal"
						data-target="#modalPembayaran{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 2 ? 'disabled' : '' }} >
							<i class="fa fa-dollar-sign">P</i>
							@if($row->status_id === 2)
								@include('admin.modals.pendaftaran.2_input_pembayaran', [
									'row' => $row,
									'subinputs' => $inputs['pembayaran']($row)
								])
							@endif
						</button>

						{{-- Verifikasi Pendaftaran --}}
						<button type="button" title="Verifikasi Pendaftaran" data-toggle="modal"
						data-target="#modalVerifikasi{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 3 ? 'disabled' : '' }} >
							<i class="fa fa-check"></i>
							@if($row->status_id === 3)
								@include('admin.modals.pendaftaran.3_verifikasi_pendaftaran', [
									'row' => $row,
									'subinputs' => $inputs['verifikasi']($row)
								])
							@endif
						</button>
					</div>

					<div class="btn-group btn-group-sm">
						{{-- Details --}}
						{{-- <button type="button" title="Detail Siswa" data-toggle="modal"
						data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" disabled>
							<i class="fa fa-eye"></i> 
						</button> --}}

						{{-- Input Siswa Sponsorship --}}
						<button type="button" title="Input Siswa Sponsorship" data-toggle="modal"
						data-target="#modalSponsorship{{ $row->id }}" class="btn btn-secondary" {{ $row->sponsorship ? 'disabled' : '' }} >
							<i class="fa">S+</i>
							@if(!$row->sponsorship)
								@include('admin.modals.sponsorship.sponsorship', [ 'row' => $row ])
							@endif
						</button>

						{{-- Tagihan --}}
						<a href="/admin/tagihan/{{ $row->id }}" title="Detail Tagihan"
							class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa">T</i>
						</a>

						{{-- Detail Pembayaran Pendaftaran --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=pendaftaran" title="Detail Pembayaran Pendaftaran"
							class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">P</i>
						</a>

						{{-- Edit --}}
						<a href="/admin/edit/{{ $row->id }}" title="Edit Data Pendaftaran"
						class="btn btn-warning">
							<i class="fa fa-pen"></i> 
						</a>
						
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>