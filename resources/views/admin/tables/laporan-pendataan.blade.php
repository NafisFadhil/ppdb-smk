<?php $peserta ??= $laporan ?? $data ?? collect() ?>

<table id="xtable" class="w-100 table table-sm table-bordered table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jalur Pendaftaran</th>
			<th>Asal Sekolah</th>
			<th>No Wa Siswa</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($peserta as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->jurusan->kode ?? '-' }}</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ $row->no_wa_siswa }}</td>
				<td>{{ $row->verifikasi->identitas ? 'Sudah' : 'Belum' }}</td>
			</tr>
			@endforeach
	</tbody>
</table>