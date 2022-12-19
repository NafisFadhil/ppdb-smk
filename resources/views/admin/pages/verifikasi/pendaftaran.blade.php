@extends('layouts.admin')

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
				'name' => 'admin_pendaftaran',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
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
				'name' => 'admin',
				'label' => 'Nama Admin',
				'value' => auth()->user()->name ?? auth()->user()->username,
				'attr' => 'readonly'
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
				'value' => $row->pendaftaran->kode ?? '',
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
								<td>{{ $row->pendaftaran->kode }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ StringHelper::toCapital($row->nama_jurusan) }}</td>
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->sublevel }}
								</td>
								<td>
									<?php 
											$xpembayaran = isset($row->tagihan->biaya_pendaftaran);
											$xpembayaransiswa = isset($row->pendaftaran->pembayaran_siswa);
											$xverifikasi = $row->pendaftaran->verifikasi_pendaftaran;
											
										?>

									<div class="btn-group btn-group-sm mb-1">
										{{-- Input Siswa Sponsorship --}}
										<button type="button" title="Input Siswa Sponsorship" data-toggle="modal"
										data-target="#modalSponsorship{{ $row->id }}" class="btn btn-secondary" {{ $row->sponsorship ? 'disabled' : '' }} >
											<i class="fa">S+</i>
											@if(!$row->sponsorship)
												@include('admin.modals.general.sponsorship', [ 'row' => $row ])
											@endif
										</button>
										
										{{-- Input Pembayaran --}}
										<button type="button" title="Konfirmasi Biaya Pendaftaran" data-toggle="modal"
										data-target="#modalBiaya{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 1 ? 'disabled' : '' }} >
											<i class="fa fa-dollar-sign"></i> 
											@if($row->status_id === 1)
												@include('admin.modals.pendaftaran.1_verifikasi_biaya_pendaftaran', [
													'row' => $row,
													'subinputs' => $inputs['biaya']($row)
												])
											@endif
										</button>

										{{-- Verifikasi Pembayaran --}}
										<button type="button" title="Verifikasi Pembayaran Siswa" data-toggle="modal"
										data-target="#modalPembayaran{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 2 ? 'disabled' : '' }} >
											<i class="fa fa-check"></i>
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
											<i class="fa fa-user-check"></i>
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
										<button type="button" title="Detail Siswa" data-toggle="modal"
										data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" disabled>
											<i class="fa fa-eye"></i> 
											{{-- @include('admin.modals.general.detail', [
												'row' => $row,
												'inputs' => [
													['Kode Pendaftaran', $row->pendaftaran->kode],
													['Jalur Pendaftaran', ModelHelper::getJalur($row->jalur_pendaftaran)],
													['Nama Lengkap', $row->nama_lengkap],
													['Jenis Kelamin', $row->jenis_kelamin],
													['Asal Sekolah', $row->asal_sekolah],
													['No Wa Siswa', $row->no_wa_siswa],
													['Jurusan', StringHelper::toCapital($row->nama_jurusan)],
													['Biaya Pendaftaran', NumberHelper::toRupiah($row->tagihan->biaya_pendaftaran)],
													['Lunas', ($row->pendaftaran->lunas ? 'Lunas' : 'Belum Lunas')],
													['Keterangan', $row->pendaftaran->keterangan],
												]
											]) --}}
										</button>

										{{-- Tagihan --}}
										<button type="button" title="Detail Tagihan" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/tagihan/{{ $row->id }}'">
											<i class="fa">T</i>
										</button>

										{{-- Data Pembayaran Pendaftaran --}}
										<button type="button" title="Data Pembayaran Pendaftaran" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=pendaftaran'">
											<i class="fa fa-dollar-sign">P</i>
										</button>

										{{-- Edit --}}
										<button type="button" title="Edit Data Pendaftaran" class="btn btn-secondary" onclick="window.location = '/admin/edit/{{ $row->id }}'">
											<i class="fa fa-pen"></i> 
										</button>
										
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				{!! $peserta->links('pagination::bootstrap-4') !!}
			</div>
		</div>
	</div>
</div>
@endsection
