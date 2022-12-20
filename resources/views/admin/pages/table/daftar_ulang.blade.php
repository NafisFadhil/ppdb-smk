<?php $cetak = $variant??null === 'cetak' ?>

<table id="xtable" class="table table-striped table-bordered table-sm">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jurusan</th>
			<th>Asal Sekolah</th>
			<th>Jalur</th>

			@if($type === 'pembayaran')
				<th>Biaya</th>
				<th>Status</th>
				<th>Admin Pembayaran</th>
			@endif
			
			<th>Admin DU</th>
			<th>Verifikasi Pendataan</th>
			<th>Keterangan</th>

			{{-- @if(!$cetak)
				<th>Cetak</th>
			@endif --}}
			
		</tr>
	</thead>

	<tbody>

			@foreach($laporan as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->jurusan->kode ?? '-' }}</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ strtoupper($row->nama_jurusan) }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
				
				@if($type === 'pembayaran')
					<td>{{ NumberHelper::toRupiah($row->tagihan->biaya_daftar_ulang) }}</td>
					<td>{!! ModelHelper::getStatusBayar($row->tagihan, $bigtype) !!}</td>
					<td>{!! ModelHelper::getAdminBayar($row->tagihan->pembayarans, $bigtype) !!}</td>
				@endif
				
				<td>{{ $row->pendaftaran->admin_verifikasi }}</td>
				<td>{{ $row->verifikasi ? 'Sudah' : 'Belum' }}</td>
				<td>{{ $row->pendaftaran->keterangan }}</td>

				{{-- @if(!$cetak)
					<td>
						<div class="btn-group btn-group-sm">
							<a href="/admin/cetak/pendaftaran/{{ $row->id }}"
								title="Cetak Surat DU"
								target="_blank" class="btn btn-secondary">
								<i class="fa fa-print">P</i>
							</a>
							<a href="/admin/cetak/formulir/{{ $row->id }}"
								title="Cetak Formulir DU"
								target="_blank" class="btn btn-secondary">
								<i class="fa fa-print">F</i>
							</a>
						</div>
					</td>
				@endif --}}

			</tr>
			@endforeach
	</tbody>

	{{-- @if($type === 'pembayaran')
	<tfoot>
		<tr>
			<td colspan="4">Total Pembayaran</td>
			<td colspan="3">{{ "Rp " . number_format($jml, 2, ",", ".") }}</td>
		</tr>
	</tfoot>
	@endif --}}

</table>