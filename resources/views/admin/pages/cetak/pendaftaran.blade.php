@extends('layouts.print')

@section('wrapper')
	<h1 class="text-center"> {{ $title }} </h1>
	<br>
	<table class="w-100 table table-sm table-bordered mx-auto" style="max-width: 90%">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Jursuan</th>
				<th>Nama Lengkap</th>
				<th>Jurusan</th>
				<th>Asal Sekolah</th>
				<th>Jalur Pendaftaran</th>
			</tr>
		</thead>
	
		<tbody>
	
			@foreach($laporan as $lp)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $lp->jurusan->kode ?? '-' }}</td>
					<td>{{ $lp->nama_lengkap }}</td>
					<td>{{ strtoupper($lp->nama_jurusan) }}</td>
					<td>{{ $lp->asal_sekolah }}</td>
					<td>{{ ModelHelper::getJalur($lp->jalur_pendaftaran) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection