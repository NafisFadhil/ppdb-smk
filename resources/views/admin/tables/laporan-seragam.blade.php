<?php $cetak = $variant??null === 'cetak' ?>

<table id="xtable" class="table table-striped table-bordered table-sm">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jurusan</th>
			<th>Asal Sekolah</th>

			@if($type === 'pembayaran')
				<th>Ukuran Seragam</th>
			@else
				<th>Ukuran <br> Olahraga</th>
				<th>Ukuran <br> Wearpack</th>
				<th>Ukuran <br> Almamater</th>
			@endif

			@if($type === 'pembayaran')
			<th>Biaya</th>
			<th>Nominal <br> Pembayaran</th>
			<th>Tanggal <br> Pembayaran</th>
			<th>Admin <br> Pembayaran</th>
			<th>Status <br> Pembayaran</th>
			@endif
			
			<th>Keterangan</th>

		</tr>
	</thead>

	<tbody>

			@foreach($laporan as $row)
			<tr>
				<td>
					@if($row->deleted_at) <i class="fa fa-times text-danger"></i>
					@else {{ $loop->iteration }} @endif
				</td>
				<td>{{ $row->jurusan->kode ?? $row->pendaftaran->kode ?? '-' }}</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ $row->jurusan->singkatan }}</td>
				<td>{{ $row->asal_sekolah }}</td>

				@if($type === 'pembayaran')
					<td>{!! ModelHelper::getUkuranSeragam($row->seragam) !!}</td>
				@else
					<td>{{ $row->seragam->ukuran_olahraga }}</td>
					<td>{{ $row->seragam->ukuran_wearpack }}</td>
					<td>{{ $row->seragam->ukuran_almamater }}</td>
				@endif
				
				@if($type === 'pembayaran')
					<td>{{ NumberHelper::toRupiah($row->tagihan->biaya_seragam) }}</td>
					<td>{!! ModelHelper::getNominalBayar($row->tagihan->pembayarans, $bigtype) !!}</td>
					<td>{!! ModelHelper::getTanggalBayar($row->tagihan->pembayarans, $bigtype) !!}</td>
					<td>{!! ModelHelper::getAdminBayar($row->tagihan->pembayarans, $bigtype) !!}</td>
					<td>{!! ModelHelper::getStatusBayar($row->tagihan, $bigtype) !!}</td>
				@endif
				
				{{-- <td>{{ $row->pendaftaran->admin_verifikasi }}</td> --}}
				{{-- <td>{{ ModelHelper::getTanggalTerakhirBayar(
					$row->tagihan->pembayarans,'pendaftaran'
				) ?? ModelHelper::formatTanggal($row->pendaftaran->updated_at) }}</td> --}}
				{{-- <td>{{ $row->verifikasi ? 'Sudah' : 'Belum' }}</td> --}}
				<td>{{ $row->seragam->keterangan }}</td>

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