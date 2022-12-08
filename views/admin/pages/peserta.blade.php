@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="w-100 mx-auto" style="max-width: max-content">
		<div class="card">
			<div class="card-body text-center">
				<form action="/admin/peserta">
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fa fa-search"></i>
							</div>
						</div>
						<input type="search" name="search" id="search" class="form-control vw-100" value="{{ old('search') ?? request('search') ?? '' }}" placeholder="Cari nama siswa..." style="max-width: 400px" autofocus>
						<div class="input-group-append">
							<button class="btn btn-primary btn-sm">Temukan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-sm table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Pendaftaran</th>
							<th>Kode Jurusan</th>
							<th>Nama Lengkap</th>
							<th>Jalur Pendaftaran</th>
							<th>Jenis Kelamin</th>
							<th>Asal Sekolah</th>
							<th>Jurusan</th>
							{{-- <th>Admin Pendaftaran</th>
							<th>Admin DU</th>
							<th>Admin Seragam</th> --}}
							<th>Status</th>
							<th>Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($peserta as $row)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->pendaftaran->kode }}</td>
								<td>{{ isset($row->jurusan->kode) ? $row->jurusan->kode : '-' }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ $row->jalur_pendaftaran }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ strtoupper($row->nama_jurusan) }}</td>
								{{-- <td>{{ $row->nama_admin_pendaftaran }}</td>
								<td>{{ $row->nama_admin_du }}</td>
								<td>{{ $row->nama_admin_seragam }}</td> --}}
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->level }} ({{ $row->status->sublevel }})
								</td>
								<td>
									<div class="btn-group btn-group-sm">

										<button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" >
											<i class="fa fa-eye"></i> 
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
														['No Wa Ortu', $row->no_wa_ortu],
														['No Wa Siswa', $row->no_wa_siswa],
														['Keterangan', $row->pendaftaran->keterangan],
														['Admin Input Nominal Pembayaran', $row->pendaftaran->admin_biaya_pendaftaran],
														['Admin Input Pembayaran Siswa', $row->pendaftaran->admin_pembayaran_siswa],
														['Admin Verifikasi Pendaftaran', $row->pendaftaran->admin_verifikasi_pendaftaran],
													] ?>
													<ol>
														@foreach ($inputs as $input)
															<li>
																<b>{{ $input[0] }}</b> 
																@isset($input[1]) : {{ $input[1] }} @endisset
															</li>
														@endforeach
													</ol>
	
												@endcomponent
											@endpush
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
				{!! $peserta->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection