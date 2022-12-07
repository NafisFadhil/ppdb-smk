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
								<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ strtoupper($row->nama_jurusan) }}</td>
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->level }} ({{ $row->status->sublevel }})
								</td>
								<td>
									<div class="btn-group btn-group-sm">

										<button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" >
											<i class="fa fa-eye"></i> 
											@include('admin.modals.general.detail', [
												'row' => $row,
												'inputs' => [
														['Kode Pendaftaran', $row->pendaftaran->kode],
														['Kode Jurusan', $row->jurusan->kode],
														['Jalur Pendaftaran', ModelHelper::getJalur($row->jalur_pendaftaran)],
														['Nama Lengkap', $row->nama_lengkap],
														['Jenis Kelamin', $row->jenis_kelamin],
														['Asal Sekolah', $row->asal_sekolah],
														['Jurusan', StringHelper::toCapital($row->nama_jurusan)],
														['No Wa Siswa', $row->no_wa_siswa],
													]
											])
										</button>

										<button type="button" title="Detail Tagihan" data-toggle="modal" data-target="#modalDetailTagihan{{ $row->id }}" class="btn btn-secondary" >
											<i class="fa fa-search-dollar"></i> 
											@include('admin.modals.general.detail', [
												'row' => $row,
												'card' => [
													'id' => 'modalDetailTagihan'.$row->id,
													'title' => 'Detail Biaya dan Tagihan'
												],
												'inputs' => [
													['Pendaftaran'],
														['Biaya Pendaftaran', NumberHelper::toRupiah($row->tagihan->biaya_pendaftaran)],
														['Tagihan Pendaftaran', NumberHelper::toRupiah($row->tagihan->tagihan_pendaftaran)],
														['Status Pendaftaran', $row->tagihan->lunas_pendaftaran ? 'Lunas' : 'Belum Lunas'],
														['Admin Biaya Pendaftaran', $row->tagihan->admin_pendaftaran],
														[],
														['Daftar Ulang'],
														['Biaya Daftar Ulang', NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang)],
														['Tagihan Daftar Ulang', NumberHelper::toRupiah($row->tagihan->tagihan_daftar_ulang)],
														['Status Daftar Ulang', $row->tagihan->lunas_daftar_ulang ? 'Lunas' : 'Belum Lunas'],
														['Admin Biaya Daftar Ulang', $row->tagihan->admin_daftar_ulang],
														[],
														['Seragam'],
														['Biaya Seragam', NumberHelper::toRupiah($row->tagihan->biaya_seragam)],
														['Tagihan Seragam', NumberHelper::toRupiah($row->tagihan->tagihan_seragam)],
														['Status Seragam', $row->tagihan->lunas_seragam ? 'Lunas' : 'Belum Lunas'],
														['Admin Biaya Seragam', $row->tagihan->admin_seragam],
													]
											])
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