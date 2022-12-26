<?php $data = $data ?? $data ?? $peserta ?? collect() ?>

<table id="xtable" class="table table-sm table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Sponsorship</th>
			<th>Kelas Sponsorship</th>
			<th>No WA <br> Sponsorship</th>
			<th>Kode Siswa</th>
			<th>Nama Siswa</th>
			<th>Asal Sekolah</th>
			<th>Jurusan</th>
			<th>Verifikasi</th>
			<th>Tindakan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->sponsorship->nama }}</td>
				<td>{{ $row->sponsorship->kelas }}</td>
				<td>{{ $row->sponsorship->no_wa }}</td>
				<td>
					{{ $row->pendaftaran->kode ?? '-' }}
					@if(!is_null($row->jurusan->kode) && !empty($row->jurusan->kode ))
						/ {{ $row->jurusan->kode ?? '-' }}
					@endif
				</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ $row->jurusan->singkatan }}</td>
				<td>{{ $row->verifikasi->sponsorship ? 'Sudah' : 'Belum' }}</td>
				<td>
					<div class="btn-group btn-group-sm">

						{{-- Edit Siswa Sponsorship --}}
						<button type="button" title="Edit Siswa Sponsorship" data-toggle="modal"
						data-target="#modalSponsorship{{ $row->id }}" class="btn btn-warning" {{ $row->verifikasi->sponsorship ? 'disabled' : '' }}>
						<i class="fa fa-pen"></i>
							@if(!$row->verifikasi->sponsorship)
								@include('admin.modals.sponsorship.sponsorship', [
									'row' => $row,
									'edit' => true
								])
							@endif
						</button>

						<button type="button" title="Verifikasi Data Sponsorship" class="btn btn-success" data-toggle="modal"
						data-target="#modalVerifikasiSponsorship{{ $row->id }}" {{ $row->verifikasi->sponsorship ? 'disabled' : '' }}>
							<i class="fa fa-check"></i>
							@if(!$row->verifikasi->sponsorship)
								@include('admin.modals.sponsorship.verifikasi', [
									'row' => $row,
								])
							@endif
						</button>

						@if(auth()->user()->level->name === 'super-admin')
							{{-- Hapus --}}
							<a href="sponsorship/hapus/{{ $row->id }}" title="Hapus Data Sponsorship"
							class="btn btn-danger d-flex flex-nowrap align-items-center"
							onclick="return confirm('Konfirmasi penghapusan data...')">
								<i class="fa fa-trash"></i>
							</a>
						@endif

					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>