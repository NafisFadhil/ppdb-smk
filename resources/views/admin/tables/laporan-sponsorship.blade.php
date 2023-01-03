<?php $data = $data ?? $data ?? $peserta ?? $laporan ?? collect() ?>

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
			</tr>
		@endforeach
	</tbody>
</table>