@extends('layouts.admin')

<?php 
$inputs = [
	'biaya_duseragam' => function ($row) {
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
				'name' => 'admin_duseragam',
				'label' => 'Nama Admin',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
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
				'name' => 'keterangan',
				'placeholder' => '(Opsional)',
				'value' => $row->duseragam->keterangan
			],
		];
	},

	'pembayaran_daftar_ulang' => function ($row) {
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
				'name' => 'admin',
				'label' => 'Nama Admin',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
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
			],
		];
	},

	'pembayaran_seragam' => function ($row) {
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
				'name' => 'admin',
				'label' => 'Nama Admin',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
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
			],
		];
	},

	'verifikasi' => function ($row) {
		return [
			[
				'name' => 'kode_jurusan',
				'value' => $row->jurusan->kode ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_lengkap',
				'value' => $row->nama_lengkap ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'jenis_kelamin',
				'value' => $row->jenis_kelamin ?? '',
				'attr' => 'disabled'
			],
			[
				'name' => 'nama_jurusan',
				'label' => 'Jurusan',
				'value' => StringHelper::toCapital($row->nama_jurusan ?? ''),
				'attr' => 'disabled'
			],
			[
				'name' => 'jalur_pendaftaran',
				'value' => ModelHelper::getJalur($row->jalur_pendaftaran),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_daftar_ulang',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang ?? ''),
				'attr' => 'disabled'
			],
			[
				'name' => 'biaya_seragam',
				'value' => NumberHelper::toRupiah($row->tagihan->biaya_seragam ?? ''),
				'attr' => 'disabled'
			],
			[
				'name' => 'status_pembayaran_daftar_ulang',
				'value' => $row->tagihan->lunas_daftar_ulang ? 'Lunas' : 'Belum Lunas',
				'attr' => 'disabled'
			],
			[
				'name' => 'status_pembayaran_seragam',
				'value' => $row->tagihan->lunas_seragam ? 'Lunas' : 'Belum Lunas',
				'attr' => 'disabled'
			],
			[
				'name' => 'admin_verifikasi',
				'label' => 'Nama Admin',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
		],
		];
	}
];
?>

@section('content')
<div class="row gap-2">
	@include('admin.components.bigsearch', ['input' => [
		'type' => 'search', 'name' => 'search', 'placeholder' => 'Cari siswa...'
	]])
	
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="xtable" class="w-100 table table-sm table-bordered table-hover">
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
								<td>{{ $row->jurusan->kode ?? '-' }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ StringHelper::toCapital($row->nama_jurusan) }}</td>
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->sublevel }}
								</td>
								<td>
									<div class="btn-group btn-group-sm mb-1">

										{{-- DUSeragam --}}
										<button type="button" title="Konfirmasi Biaya Daftar Ulang & Seragam" data-toggle="modal"
										data-target="#modalBiaya{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 4 ? 'disabled' : '' }} >
											<i class="fa fa-dollar-sign"></i> 
											@if($row->status_id === 4)
												@include('admin.modals.duseragam.1_verifikasi_biaya_duseragam', [
													'row' => $row,
													'subinputs' => $inputs['biaya_duseragam']($row)
												])
											@endif
										</button>


										{{-- Pembayaran DU --}}
										<button type="button" title="Input Pembayaran Daftar Ulang" data-toggle="modal"
										data-target="#modalPembayaranDaftarUlang{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 5 || $row->tagihan->lunas_daftar_ulang ? 'disabled' : '' }} >
											<i class="fa fa-check">DU</i>
											@if($row->status_id === 5)
												@include('admin.modals.daftar_ulang.input_pembayaran', [
													'row' => $row,
													'subinputs' => $inputs['pembayaran_daftar_ulang']($row)
												])
											@endif
										</button>


										{{-- Pembayaran Seragam --}}
										<button type="button" title="Input Pembayaran Seragam" data-toggle="modal"
										data-target="#modalPembayaranSeragam{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 5 || $row->tagihan->lunas_seragam ? 'disabled' : '' }} >
											<i class="fa fa-check">S</i>
											@if($row->status_id === 5)
												@include('admin.modals.seragam.input_pembayaran', [
													'row' => $row,
													'subinputs' => $inputs['pembayaran_seragam']($row)
												])
											@endif
										</button>

										{{-- Verifikasi DU & Seragam --}}
										<button type="button" title="Verifikasi DU & Seragam" data-toggle="modal"
										data-target="#modalVerifikasi{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 6 || !$row->tagihan->lunas_daftar_ulang || !$row->tagihan->lunas_seragam ? 'disabled' : '' }} >
											<i class="fa fa-user-check"></i>
											@if($row->status_id === 6)
												@include('admin.modals.duseragam.2_verifikasi_duseragam', [
													'row' => $row,
													'subinputs' => $inputs['verifikasi']($row)
												])
											@endif
										</button>
									</div>

									<div class="btn-group btn-group-sm">
										{{-- Details --}}
										<button type="button" title="Detail Siswa" data-toggle="modal"
										data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" disabled>
											<i class="fa fa-eye"></i> 
											{{-- @include('admin.modals.general.detail', [
												'row' => $row,
												'inputs' => [
													['Kode DU & Seragam', $row->duseragam->kode],
													['Jalur Pendaftaran', ModelHelper::getJalur($row->jalur_pendaftaran)],
													['Nama Lengkap', $row->nama_lengkap],
													['Jenis Kelamin', $row->jenis_kelamin],
													['Asal Sekolah', $row->asal_sekolah],
													['Jurusan', StringHelper::toCapital($row->nama_jurusan)],
													['Biaya Daftar Ulang', NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang)],
													['Tagihan Daftar Ulang', ($row->tagihan->tagihan_daftar_ulang ? 'Lunas' : 'Kurang ' . NumberHelper::toRupiah($row->tagihan->tagihan_daftar_ulang))],
													['Biaya Seragam', NumberHelper::toRupiah($row->tagihan->biaya_seragam)],
													['Tagihan Seragam', ($row->tagihan->tagihan_seragam ? 'Lunas' : 'Kurang ' . NumberHelper::toRupiah($row->tagihan->tagihan_seragam))],
													['No Wa Siswa', $row->no_wa_siswa],
													['Keterangan', $row->tagihan->keterangan],
												]
											]) --}}
										</button>

										{{-- Tagihan --}}
										<button type="button" title="Detail Tagihan" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/tagihan/{{ $row->id }}'">
											<i class="fa">T</i>
										</button>

										{{-- Data Pembayaran DU --}}
										<button type="button" title="Data Pembayaran Daftar Ulang" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=daftar_ulang'">
											<i class="fa fa-dollar-sign">DU</i>
										</button>

										{{-- Data Pembayaran Seragam --}}
										<button type="button" title="Data Pembayaran Seragam" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=seragam'">
											<i class="fa fa-dollar-sign">S</i>
										</button>
										
										{{-- Edit --}}
										<button type="button" title="Edit Data DU & Seragam" class="btn btn-secondary" onclick="window.location = '/admin/edit/{{ $row->id }}'">
											<i class="fa fa-pen"></i> 
										</button>
										
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				{!! $peserta->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection
