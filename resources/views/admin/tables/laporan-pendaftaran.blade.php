<?php
$cetak = $variant??null === 'cetak';
$counters = [
	'total_tagihan' => 0,
	'total_bayar' => 0,
];
?>

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
				<th>Biaya Pendaftaran</th>
				<th>Nominal <br> Pembayaran</th>
				<th>Tanggal <br> Pembayaran</th>
				<th>Admin <br> Pembayaran</th>
				<th>Status <br> Pembayaran</th>
				@else
				<th>Tanggal Lahir</th>
				<th>No WA Siswa</th>
				<th>No WA Ortu</th>
				<th>Status <br> Pembayaran</th>
			@endif
			
			<th>Keterangan</th>

			@if(!$cetak)
				<th>Cetak</th>
			@endif
			
		</tr>
	</thead>

	<tbody>

			@foreach($laporan as $row)

				<tr>
					<td>
						@if($row->deleted_at) <i class="fa fa-times text-danger"></i>
						@else {{ $loop->iteration }} @endif
					</td>
					<td>{{ $row->jurusan->kode ?? '-' }}</td>
					<td>{{ $row->nama_lengkap }}</td>
					<td>{{ $row->jurusan->singkatan }}</td>
					<td>{{ $row->asal_sekolah }}</td>
					<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
					
					@if($type === 'pembayaran')
						<td>{{ NumberHelper::toRupiah($row->tagihan->biaya_pendaftaran) }}</td>
						<td>{!! ModelHelper::getNominalBayar($row->tagihan->pembayarans, 'pendaftaran') !!}</td>
						<td>{!! ModelHelper::getTanggalBayar($row->tagihan->pembayarans, 'pendaftaran') !!}</td>
						<td>{!! ModelHelper::getAdminBayar($row->tagihan->pembayarans, 'pendaftaran') !!}</td>
						<td>{!! ModelHelper::getStatusBayar($row->tagihan, 'pendaftaran') !!}</td>
					@else
						<td>{{ ModelHelper::formatTanggal($row->tanggal_lahir) }}</td>
						<td>{{$row->no_wa_siswa }}</td>
						<td>{{$row->no_wa_ortu }}</td>
						<td>{!! ModelHelper::getStatusBayar($row->tagihan, 'pendaftaran') !!}</td>
					@endif
					
					<td>{{ $row->pendaftaran->keterangan ?? '-' }}</td>
					
					@if(!$cetak)
						<td>
							<div class="btn-group btn-group-sm">
								<a href="/admin/cetak/pendaftaran/{{ $row->id }}"
									title="Cetak Surat Pendaftaran"
									target="_blank" class="btn btn-secondary">
									<i class="fa fa-print">P</i>
								</a>
								<a href="/admin/cetak/formulir/{{ $row->id }}"
									title="Cetak Formulir Pendaftaran"
									target="_blank" class="btn btn-secondary">
									<i class="fa fa-print">F</i>
								</a>
							</div>
						</td>
					@endif

				</tr>
			@endforeach
	</tbody>

	@if($type === 'pembayaran')
		{{-- <tfoot>
			<tr>
				<td colspan="2">Total Tagihan</td>
				<td>{{ NumberHelper::toRupiah($xlaporan['total_tagihan']) }}</td>
				<td colspan="3"></td>
			</tr>
		</tfoot> --}}
	@endif

	{{-- @if($type === 'pembayaran')
	<tfoot>
		<tr>
			<td colspan="4">Total Pembayaran</td>
			<td colspan="3">{{ "Rp " . number_format($jml, 2, ",", ".") }}</td>
		</tr>
	</tfoot>
	@endif --}}

</table>