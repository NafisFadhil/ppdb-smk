@extends('layouts.subgeneral', [
	'subtitle' => 'Hasil Penerimaan'
])

@section('subcontent')
	<div class="p-4 md:p-8 max-w-screen-xl mx-auto">
		<table class="w-full table table-auto text-left bg-white rounded-lg">
			<style>
				table th, table td { padding: .25rem }
			</style>
			<thead>
				<tr>
					<th>No</th>
					<th>Kode</th>
					<th>Nama Lengkap</th>
					<th>Asal Sekolah</th>
					<th>Jenis Kelamin</th>
					<th>NISN</th>
					<th>Jalur Pendaftaran</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $siswa)
					<tr class="border-t">
						<td class=""> {{ $loop->iteration }} </td>
						<td class=""> {{ $siswa->kode }} </td>
						<td class=""> {{ $siswa->identitas->nama_lengkap }} </td>
						<td class=""> {{ $siswa->identitas->asal_sekolah }} </td>
						<td class=""> {{ $siswa->identitas->jenis_kelamin }} </td>
						<td class=""> {{ $siswa->identitas->nisn }} </td>
						<td class=""> {{ $siswa->identitas->jalur_pendaftaran }} </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection