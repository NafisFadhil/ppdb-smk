@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="w-100 mx-auto" style="max-width: max-content">
		<div class="card">
			<div class="card-body text-center">
				<h4>Cari Siswa</h4>
				<form action="/admin/peserta">
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-search"></i>
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
							<th>Jalur Pendaftaran</th>
							<th>Nama Lengkap</th>
							<th>Jenis Kelamin</th>
							<th>Asal Sekolah</th>
							<th>Jurusan</th>
							<th>Admin Pendaftaran</th>
							<th>Admin DU</th>
							<th>Admin Seragam</th>
							<th>Status</th>
							<th>Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($peserta as $row)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->kode }}</td>
								<td>{{ $row->identitas->jalur_pendaftaran }}</td>
								<td>{{ $row->identitas->nama_lengkap }}</td>
								<td>{{ $row->identitas->jenis_kelamin }}</td>
								<td>{{ $row->identitas->asal_sekolah }}</td>
								<td>{{ StringHelper::toTitle($row->identitas->nama_jurusan) }}</td>
								<td>{{ $row->nama_admin_pendaftaran }}</td>
								<td>{{ $row->nama_admin_du }}</td>
								<td>{{ $row->nama_admin_seragam }}</td>
								<td class="text-success" title="{{ $row->level->desc }}">
									{{ StringHelper::toTitle($row->level->name) }} 
									<?php
									$verifname = 'verifikasi_' . ($row->level_id === 1 ? 'pendaftaran' : ($row->level_id === 2 ? 'du' : 'seragam'));
									$verified = $row[$verifname];
									?>
									<span class="text-{{ $verified ? 'success' : 'warning' }}">
										({{ $verified ? 'Ter-Verifikasi' : 'Menunggu Verifikasi' }})
									</span>
								</td>
								<td>
									<button type="button"
										title="Edit Data Pendaftaran"
										class="btn btn-sm btn-secondary"
										onclick="window.location = '/admin/edit/{{ $row->id }}'"
									>
										<i class="fas fa-pen"></i>
									</button>
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