@extends('layouts.admin')

<?php 
$input_s = [
	'biaya' => function ($row) {
		return [
			['name' => 'jalur_pendaftaran', 'value' => $row->jalur_pendaftaran ?? '', 'attr' => 'readonly'],
			['type' => 'number', 'name' => 'biaya_pendaftaran', 'value' => $row->pendaftaran->biaya_pendaftaran ?? 0],
			['name' => 'admin_biaya_pendaftaran', 'label' => 'Nama Admin', 'value' => auth()->user()->name ?? auth()->user()->username, 'attr' => 'readonly'],
		];
	},
	'pembayaran' => function ($row) {
		return [
			// [
				['name' => 'kode', 'value' => $row->pendaftaran->kode ?? '', 'attr' => 'readonly'],
				['name' => 'nama_lengkap', 'value' => $row->nama_lengkap ?? '', 'attr' => 'readonly'],
				['name' => 'nama_jurusan', 'label' => 'Jurusan', 'value' => StringHelper::toCapital($row->nama_jurusan ?? ''), 'attr' => 'readonly'],
				['name' => 'jalur_pendaftaran', 'value' => $row->jalur_pendaftaran ?? '', 'attr' => 'readonly'],
				['name' => 'admin_pembayaran_siswa', 'label' => 'Nama Admin', 'value' => auth()->user()->name ?? auth()->user()->username, 'attr' => 'readonly'],
				['name' => 'biaya_pendaftaran', 'value' => NumberHelper::toRupiah($row->pendaftaran->biaya_pendaftaran ?? 0), 'attr' => 'readonly'],
				['type' => 'number', 'name' => 'pembayaran_siswa', 'value' => $row->pendaftaran->pembayaran_siswa ?? $row->pendaftaran->biaya_pendaftaran],
				['type' => 'radio', 'name' => 'lunas', 'value' => !$row->pendaftaran->lunas, 'values' => [
					['label' => 'Belum', 'value' => false],
					['label' => 'Sudah', 'value' => true],
				]],
			// ],
			// [
			// ]
		];
	},
	'verifikasi' => function ($row) {
		return [
			['name' => 'kode', 'value' => $row->pendaftaran->kode ?? '', 'attr' => 'readonly'],
			['name' => 'nama_lengkap', 'value' => $row->nama_lengkap ?? '', 'attr' => 'readonly'],
			['name' => 'jenis_kelamin', 'value' => $row->jenis_kelamin ?? '', 'attr' => 'readonly'],
			['name' => 'nama_jurusan', 'label' => 'Jurusan', 'value' => StringHelper::toCapital($row->nama_jurusan ?? ''), 'attr' => 'readonly'],
			['name' => 'jalur_pendaftaran', 'value' => $row->jalur_pendaftaran ?? '', 'attr' => 'readonly'],
			['name' => 'biaya_pendaftaran', 'value' => NumberHelper::toRupiah($row->pendaftaran->biaya_pendaftaran ?? ''), 'attr' => 'readonly'],
			['name' => 'status_pembayaran', 'value' => $row->pendaftaran->lunas ? 'Lunas' : 'Belum Lunas', 'attr' => 'readonly'],
			['name' => 'admin_verifikasi_pendaftaran', 'label' => 'Nama Admin', 'value' => auth()->user()->name ?? auth()->user()->username, 'attr' => 'readonly'],
		];
	}
];
?>

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">    
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
								<td>{{ $row->pendaftaran->kode }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ $row->jalur_pendaftaran }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ StringHelper::toCapital($row->nama_jurusan) }}</td>
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->sublevel }}
								</td>
								<td>
								<?php 
										$xpembayaran = isset($row->pendaftaran->biaya_pendaftaran);
										$xpembayaransiswa = isset($row->pendaftaran->pembayaran_siswa);
										$xverifikasi = $row->pendaftaran->verifikasi_pendaftaran;
										
									?>

								<div class="btn-group btn-group-sm mb-1">

									{{-- Input Pembayaran --}}
									<button type="button" title="Masukkan Biaya Pendaftaran" data-toggle="modal" data-target="#modalInputan{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 1 ? 'disabled' : '' }} >
										<i class="fas fa-dollar-sign"></i> 
										@if($row->status_id === 1)
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalInputan'.$row->id,
													'title' => 'Input Biaya Pendaftaran'
												])

												<form action="/admin/verifikasi-pendaftaran/biaya/{{ $row->id }}" method="post"> @csrf
													<?php $subinputs = $input_s['biaya']($row) ?>	

													@foreach ($subinputs as $input)
														@include('admin.components.input', ['input' => $input])
													@endforeach

													<div class="form-group text-center">
														<button class="btn btn-secondary">
															Submit
														</button>
													</div>
													
												</form>
												
												@endcomponent
											@endpush
										@endif
									</button>

									{{-- Verifikasi Pembayaran --}}
									<button type="button" title="Verifikasi Pembayaran Siswa" data-toggle="modal" data-target="#modalPembayaran{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 2 ? 'disabled' : '' }} >
										<i class="fas fa-check"></i>
										@if($row->status_id < 3)
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalPembayaran'.$row->id,
													'title' => 'Verifikasi Pembayaran Siswa',
												])

												<form action="/admin/verifikasi-pendaftaran/pembayaran/{{ $row->id }}" method="post">
													@csrf <?php $subinputs = $input_s['pembayaran']($row) ?>

													{{-- <div class="row"> --}}
														{{-- @foreach ($subinputers as $subinputs) --}}
															{{-- <div class="col-12 col-md-6"> --}}
																@foreach ($subinputs as $input)
																	@include('admin.components.input', ['input' => $input])
																@endforeach
															{{-- </div> --}}
														{{-- @endforeach --}}
													{{-- </div> --}}

													<div class="form-group text-center">
														<button class="btn btn-secondary">
															<i class="fas fa-check"></i> Verifikasi
														</button>
													</div>
													
												</form>
												
												@endcomponent
											@endpush
										@endif
									</button>

									{{-- Verifikasi Pendaftaran --}}
									<button type="button" title="Verifikasi Pendaftaran" data-toggle="modal" data-target="#modalVerifikasi{{ $row->id }}" class="btn btn-secondary" {{ $row->status_id !== 3 ? 'disabled' : '' }} >
										<i class="fas fa-user-check"></i>
										@if($row->status_id === 3)
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalVerifikasi'.$row->id,
													'title' => 'Verifikasi Siswa',
													'size' => 'xl'
												])

												<form action="/admin/verifikasi-pendaftaran/verifikasi/{{ $row->id }}" method="post">
													@csrf <?php $subinputs = $input_s['verifikasi']($row) ?>

													{{-- <div class="row"> --}}
														{{-- @foreach ($subinputs as $subinput) --}}
															{{-- <div class="col-12 col-md-6"> --}}
																@foreach ($subinputs as $input)
																	@include('admin.components.input', ['input' => $input])
																@endforeach
															{{-- </div> --}}
														{{-- @endforeach --}}
													{{-- </div> --}}

													<div class="form-group text-center">
														<button class="btn btn-secondary">
															<i class="fas fa-check"></i> Verifikasi
														</button>
													</div>
													
												</form>
												
												@endcomponent
											@endpush
										@endif
									</button>
								</div>










									<div class="btn-group btn-group-sm">
										{{-- Details --}}
										<button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" >
											<i class="fas fa-eye"></i> 
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalDetail'.$row->id,
													'title' => 'Detail Siswa',
													'size' => 'max'
												])
	
													<?php $inputs = [
														['Kode Pendaftaran', $row->pendaftaran->kode],
														['Jalur Pendaftaran', $row->jalur_pendaftaran],
														['Nama Lengkap', $row->nama_lengkap],
														['Jenis Kelamin', $row->jenis_kelamin],
														['Asal Sekolah', $row->asal_sekolah],
														['Jurusan', StringHelper::toCapital($row->nama_jurusan)],
														['Biaya Pendaftaran', NumberHelper::toRupiah($row->pendaftaran->biaya_pendaftaran)],
														['Lunas', ($row->pendaftaran->lunas ? 'Lunas' : 'Belum Lunas')],
														['No Wa Ortu', $row->no_wa_ortu],
														['No Wa Siswa', $row->no_wa_siswa],
														['Keterangan', $row->pendaftaran->keterangan],
													] ?>
													<ol>
														@foreach ($inputs as $input)
															<li> <b>{{ $input[0] }}</b> : {{ $input[1] }} </li>
														@endforeach
													</ol>
	
												@endcomponent
											@endpush
										</button>










										{{-- Edit --}}
										<button type="button" title="Edit Data Pendaftaran" class="btn btn-secondary" onclick="window.location = '/admin/edit/{{ $row->id }}'">
											<i class="fas fa-pen"></i> 
										</button>
										
										{{-- Print --}}
										<button type="button" title="Cetak Lembar Pendaftaran" class="btn btn-secondary" {{ $xverifikasi ? '' : 'disabled' }} onclick="window.location = '/admin/print/{{ $row->id }}'" >
											<i class="fas fa-print"></i>
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
