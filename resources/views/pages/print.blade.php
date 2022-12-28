@extends('layouts.subgeneral', [
	'subtitle' => 'Cetak Lembar Pendaftaran'
])

@section('subcontent')

<div class="p-4 md:p-8 max-w-screen-lg mx-auto my-3">

	<div class="flex flex-col justify-center items-center rounded-lg shadow-lg bg-white p-4 md:p-8 gap-3 mb-4">
		<h1 class="text-2xl font-semibold">Cari Data Pendaftaran</h1>
		<form action="/pendaftaran/print" method="get" class="flex flex-row flex-wrap gap-x-4 gap-y-2">
			<div class="flex-1 min-w-[200px] flex flex-row gap-2 items-center">
				<label for="kode" class="min-w-max">Kode Pendaftaran</label>
				<input
					type="text"
					name="kode"
					id="kode"
					value="{{ old('kode') ?? isset($pendaftaran) ? $pendaftaran->kode ?? '-' : request()->query('kode') ?? '' }}"
					placeholder="P-0XX"
					required autofocus
					class="w-full py-1 px-2 rounded shadow bg-light"
				/>
			</div>
			<div class="flex-1 min-w-[200px] flex flex-row gap-2 items-center">
				<label for="kode" class="min-w-max">NISN</label>
				<input
					type="number"
					name="nisn"
					id="nisn"
					value="{{ old('nisn') ?? isset($pendaftaran) ? $pendaftaran->identitas->nisn : request()->query('nisn') ?? '' }}"
					placeholder="NISN"
					required
					class="w-full py-1 px-2 rounded shadow bg-light"
				/>
			</div>
			<div class="flex flex-row justify-center items-center">
				<button type="submit" class="py-1 px-3 bg-primary text-white rounded-lg shadow-lg max-w-max hover:opacity-90 transition-opacity">
					<i class="fa fa-search"></i> Cari
				</button>
			</div>
		</form>
	</div>
	
	@if(request()->query('kode') && request()->query('nisn'))
		
		<div class="flex flex-col justify-center items-center rounded-lg shadow-lg bg-white p-4 md:p-8 gap-4 mb-4">
			<h1 class="text-2xl font-semibold">Hasil Data Pencarian</h1>
			@isset($pendaftaran)
				<?php $tampil = [
					'Kode Pendaftaran' => $pendaftaran->kode ?? '-',
					'Jalur Pendaftaran' => $pendaftaran->identitas->jalur_pendaftaran,
					'NamaLengkap' => $pendaftaran->identitas->nama_lengkap,
					'Tempat Lahir' => $pendaftaran->identitas->tempat_lahir,
					'Tanggal Lahir' => $pendaftaran->identitas->tanggal_lahir,
					'Jenis Kelamin' => $pendaftaran->identitas->jenis_kelamin,
					'Nama Desa' => $pendaftaran->identitas->alamat_desa,
					'Nama Kecamatan' => $pendaftaran->identitas->alamat_kec,
					'Nama Kota/Kab' => $pendaftaran->identitas->alamat_kota_kab,
					'No RW' => $pendaftaran->identitas->alamat_rw,
					'No RT' => $pendaftaran->identitas->alamat_rt,
					'Nama Ayah' => $pendaftaran->identitas->nama_ayah,
					'Nama Ibu' => $pendaftaran->identitas->nama_ibu,
					'Jumlah Saudara Kandung' => $pendaftaran->identitas->jumlah_saudara_kandung,
					'NIK' => $pendaftaran->identitas->nik,
					'Asal Sekolah' => $pendaftaran->identitas->asal_sekolah,
					'NISN' => $pendaftaran->identitas->nisn,
					'No Ujian Nasional' => $pendaftaran->identitas->no_ujian_nasional,
					'No Ijazah' => $pendaftaran->identitas->no_ijazah,
					'No WA' => $pendaftaran->identitas->no_wa,
					'Jurusan' => $pendaftaran->identitas->jurusan,
				] ?>
				<ul class="grid grid-cols-1 grid-rows-auto justify-items-center gap-2">
					@foreach ($tampil as $label => $value)
						<li class="col-span-1 flex flex-row flex-wrap items-center gap-2">
							<p class="min-w-max"> {{ $label }} : </p>
							<p class="flex-1 font-semibold"> {{ $value }} </p>
						</li>
					@endforeach
				</ul>

				<?php $url = '/pendaftaran/print/cetak?kode='.$pendaftaran->kode ?? '-'.'&nisn='.$pendaftaran->identitas->nisn ?>
				<a href="{{ $url }}" target="_blank" class="p-2 px-6 bg-light rounded-lg shadow max-w-max hover:brightness-90 transition">
					<i class="fa fa-print"></i> Print
				</a>
				
			@else
				<p class="text-lg max-w-screen-sm text-center">Maaf, data tidak ditemukan.</p>
			@endisset
		</div>

	@endif
	
</div>

@endsection