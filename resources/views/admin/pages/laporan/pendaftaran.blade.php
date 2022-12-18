@extends('layouts.laporan')

@section('laporan')
<table id="xtable" class="table table-striped table-bordered table-sm">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode Jursuan</th>
			<th>Nama Lengkap</th>
			<th>Jurusan</th>
			<th>Asal Sekolah</th>
			<th>Jalur Pendaftaran</th>
			<th>Cetak</th>
		</tr>
	</thead>

	<tbody>

		{{-- @if($type == 'pembayaran')
			@foreach($laporan as $lp)
			<tr>
				<td>{{ $lp->kode }}</td>
				<td>{{ $lp->nama_lengkap }}</td>
				<td>{{ Str::upper($lp->nama_jurusan) }}</td>
				<td>{{ $lp->no_wa_siswa }}</td>
				<td>{{ "Rp " . number_format($lp->biaya_pendaftaran, 2, ",", ".") }}</td>
				<td>{{ $lp->updated_at }}</td>
				<td>{{ $lp->admin_biaya_pendaftaran }}</td>
			</tr>
			@php($jml += $lp->biaya_pendaftaran)
			@endforeach

		@else --}}

			@foreach($laporan as $lp)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $lp->jurusan->kode ?? '-' }}</td>
				<td>{{ $lp->nama_lengkap }}</td>
				<td>{{ strtoupper($lp->nama_jurusan) }}</td>
				<td>{{ $lp->asal_sekolah }}</td>
				<td>{{ ModelHelper::getJalur($lp->jalur_pendaftaran) }}</td>
				<td>
					<div class="btn-group btn-group-sm">
						<a href="/admin/cetak/pendaftaran/{{ $lp->id }}"
							title="Cetak Surat Pendaftaran"
							target="_blank" class="btn btn-secondary">
							<i class="fa fa-print">P</i>
						</a>
						<a href="/admin/cetak/formulir/{{ $lp->id }}"
							title="Cetak Formulir Pendaftaran"
							target="_blank" class="btn btn-secondary">
							<i class="fa fa-print">F</i>
						</a>
					</div>
				</td>
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
@endsection