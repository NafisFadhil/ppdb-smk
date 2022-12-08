@extends('layouts.main')

@push('styles')
	<style>
		:root, html, body {
			font: normal 12px sans-serif;
		}
	</style>
@endpush

@section('body')
	<div id="wrapper" class="bg-white w-full overflow-x-hidden" style="max-width: 214mm">
		<div class="container p-4">
			
			<header class="w-full flex justify-center items-center gap-4">
				<img src="/dist/img/logo-smk.png"
					alt="Logo {{ ConfigHelper::get('nama_sekolah') }}"
					class="w-auto h-20"
				/>
				<div class="flex flex-col justify-start font-bold">
					<p class="uppercase">MAJELIS PENDIDIKAN DASAR DAN MENENGAH</p>
					<p class="uppercase">PIMPINAN DAERAH MUHAMMADIYAH KAB. PEKALONGAN</p>
					<p class="uppercase text-lg font-black">SMK MUHAMMADIYAH BLIGO</p>
					<p class="">Alamat : Sapugarut Gang 7 Buaran Pekalongan 51171 Telp (0285) 441 5132</p>
				</div>
			</header>
	
			<hr class="border border-primary w-full my-1" />

			<div class="flex justify-between items-center border border-black">
				<p class="uppercase p-3 font-semibold border-r border-black">LAMPIRAN A</p>
				<div class="flex-1 flex flex-col justify-center text-center black font-bold">
					<p class="uppercase flex-1 border-b border-black">
						FORMULIR PENDAFTARAN MASUK KELAS X
					</p>
					<p class="uppercase flex-1">
						TAHUN PELAJARAN 2023/2024
					</p>
				</div>
				<p class="uppercase p-3 font-semibold border-l border-black"> F/7.2/WKS2/001 </p>
			</div>

			<section class="grid grid-cols-11 grid-rows-1 my-2">
				<div class="col-span-4 p-2">
					<h1 class="text-xl font-black uppercase leading-5">
						{{ StringHelper::toTitle($siswa->identitas->nama_jurusan) }}
					</h1>
				</div>
				<div class="col-span-7 flex flex-row justify-start gap-1 items-center">
					@for($i = 0; $i < 4; $i++)
						<div class="border-2 border-black grid place-items-center" style="width: 3cm; height: 4cm">
							<p class="font-semibold"> 3x4 </p>
						</div>
					@endfor
				</div>
			</section>

			<section class="grid grid-cols-11 grid-rows-auto gap-2 mb-2 uppercase font-semibold">
				<?php $no = 1 ?>

				<p class="col-span-4"> {{ $no++ }}. jalur pendaftaran </p>
				<p class="col-span-7"> : {{ $siswa->identitas->jalur_pendaftaran }} </p>
				
				<p class="col-span-4"> {{ $no++ }}. nomor urut pendaftaran </p>
				<p class="col-span-7"> : {{ $siswa->kode }} </p>

				<p class="col-span-4"> {{ $no++ }}. nama lengkap </p>
				<p class="col-span-7"> : {{ $siswa->identitas->nama_lengkap }} </p>

				<p class="col-span-4"> {{ $no++ }}. tempat lahir </p>
				<p class="col-span-7"> : {{ $siswa->identitas->tempat_lahir }} </p>

				<p class="col-span-4"> {{ $no++ }}. tanggal lahir </p>
				<p class="col-span-7"> : {{ $siswa->identitas->tanggal_lahir }} </p>

				<p class="col-span-4"> {{ $no++ }}. jenis kelamin </p>
				<p class="col-span-7"> : {{ $siswa->identitas->jenis_kelamin }} </p>

				{{-- alamat tinggal --}}
				<p class="col-span-4"> {{ $no++ }}. alamat tinggal </p>
				<p class="col-span-7"> : [...] </p>
				
				<p class="col-span-4"> {{ $no++ }}. nama ayah </p>
				<p class="col-span-7"> : {{ $siswa->identitas->nama_ayah }} </p>

				<p class="col-span-4"> {{ $no++ }}. nama ibu </p>
				<p class="col-span-7"> : {{ $siswa->identitas->nama_ibu }} </p>

				<p class="col-span-4"> {{ $no++ }}. jumlah saudara kandung </p>
				<p class="col-span-7"> : {{ $siswa->identitas->jumlah_saudara_kandung }} </p>

				<p class="col-span-4"> {{ $no++ }}. nomor induk kependudukan (nik) </p>
				<p class="col-span-7"> : {{ $siswa->identitas->nik }} </p>

				<p class="col-span-4"> {{ $no++ }}. asal smp/mts </p>
				<p class="col-span-7"> : {{ $siswa->identitas->asal_sekolah }} </p>

				<p class="col-span-4"> {{ $no++ }}. nisn </p>
				<p class="col-span-7"> : {{ $siswa->identitas->nisn }} </p>

				<p class="col-span-4"> {{ $no++ }}. no ujian nasional smp/mts </p>
				<p class="col-span-7"> : {{ $siswa->identitas->no_ujian_nasional }} </p>

				<p class="col-span-4"> {{ $no++ }}. no ijazah/tanggal/tahun lulus </p>
				<p class="col-span-7"> : {{ $siswa->identitas->no_ijazah }} </p>

				<p class="col-span-4"> {{ $no++ }}. no wa ortu/wali </p>
				<p class="col-span-7"> : {{ $siswa->identitas->no_wa_ortu }} </p>

				<p class="col-span-4"> {{ $no++ }}. no wa siswa </p>
				<p class="col-span-7"> : {{ $siswa->identitas->no_wa_siswa }} </p>

				<p class="col-span-4"> {{ $no++ }}. pilihan kompetensi keahlian </p>
				<p class="col-span-7"> : {{ StringHelper::toTitle($siswa->identitas->nama_jurusan) }} </p>

			</section>

		</div>
		
	</div>
@endsection