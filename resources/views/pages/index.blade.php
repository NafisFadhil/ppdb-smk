@extends('layouts.general')

@section('content')

	@include('components.popup')

	{{-- Header Section --}}
	<header class="w-full bg-primary text-white">
		<div class="max-w-screen-lg mx-auto px-4 sm:px-8 py-8 md:py-14 lg:py-20 text-center md:text-left">
			<h1 class="text-xl xs:text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black mb-4 md:mb-7">
				Penerimaan Peserta Didik Baru <br> Tahun Pelajaran 2023 / 2024
			</h1>
			<p class="max-w-screen-sm mb-5 md:mb-7 text-sm sm:text-base">
				SMK Muhammadiyah Bligo membuka pendaftaran peserta didik baru (PPDB)
				Tahun Pelajaran 2023 - 2024 mulai tanggal 3 Januari 2023 dengan beberapa jalur pendaftaran.
			</p>
			<a href="/formulir" class="px-5 py-2 shadow-lg text-primary bg-white rounded">
				Daftar Online <i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</header>

	{{-- Jurusan Section --}}
	<section id="jurusanSection" class="w-full bg-white">
		<div class="max-w-screen-lg mx-auto w-full px-4 py-10 md:p-16 text-center">
			<h1 class="text-2xl md:text-3xl font-bold mb-1">
				Jurusan
			</h1>
			<p class=" mb-4 md:mb-6">
				Beberapa jurusan yang tersedia di SMK Muhammadiyah Bligo.
			</p>
			
			<div class="flex flex-row flex-wrap justify-center items-center gap-4 md:gap-6">
				@foreach($data_jurusan as $jurusan)
				<div class="text-center flex-1 min-w-[80px] max-w-[80px] md:max-w-[100px]">
					<img src="/dist/img/logo-{{ $jurusan->singkatan }}.png"
					title="{{ $jurusan->nama }}"
					alt="Logo Jurusan {{ $jurusan->singkatan }}"
					class="w-full mx-auto aspect-square h-auto">
					<p class="font-bold uppercase text-center text-sm sm:text-base">{{ $jurusan->singkatan }}</p>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	
	{{-- Jalur Pendaftaran Section --}}
	<section id="jalurPendaftaranSection" class="w-full relative bg-gray-100">
		<div class="max-w-screen-lg mx-auto px-5 md:px-8 py-10 md:py-16">
			<h1 class="text-2xl md:text-3xl font-bold text-center mb-2">
				Jalur Pendaftaran
			</h1>
			<p class="mb-4 text-center">
				Jalur pendaftaran yang tersedia sebagai berikut.
			</p>

			<?php $jalurs = [
				'umum' => ['3 Januari', '7 Juli'],
				'prestasi' => ['3 Januari', '19 April'],
				'afirmasi' => ['3 Januari', '19 April'],
			] ?>

			<div class="flex flex-wrap flex-row justify-center items-center gap-4 md:gap-6 max-w-screen-md mx-auto">
				@foreach($jalurs as $jalur => $tgl)
					<div class="flex-1 min-w-max bg-primary text-white bg-gradient text-center px-4 py-8
					rounded-lg">
						<h4 class="text-2xl font-black"> {{ StringHelper::toTitle($jalur) }} </h4>
						<p class="">
							{{ $tgl[0] }} - {{ $tgl[1] }} 2023
						</p>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	{{-- Persyaratan Section --}}
	<section id="penduanSection" class="w-full bg-white">
		<div class="max-w-screen-lg mx-auto px-4 py-8 md:py-14">
			<h1 class="text-2xl md:text-3xl font-bold text-center mb-2">
				Panduan Pendaftaran
			</h1>
			<p class="mb-4 text-center">
				Adapun tahapan dalam mengikuti ppdb online sebagai berikut.
			</p>

			<article class="max-w-screen-md mx-auto">
				<ol class="list-decimal pl-2 big-marker">
					<li class="mb-1.5">
						Pendaftaran On-line
						<ul class="mb-1.5 sm:pl-3 pl-1 dash-marker">
							<li>Link : <a href="/" class="text-primary">http://ppdb.smkmuhbligo.sch.id</a></li>
							<li>Simpan kode pendaftaran yang muncul dengan screenshot atau lainnya.</li>
						</ul>
					</li>
					<li class="mb-1.5">
						Verifikasi Berkas
						<ul class="mb-1.5 sm:pl-3 pl-1 dash-marker">
							<li>Datang Ke SMK dengan membawa Dokumen
								<ol class="sm:pl-4 pl-2 mb-1" style="list-style:decimal">
									<li>Fotokopi Akta Kelahiran (4 lembar)</li>
									<li>Fotokopi Kartu Keluarga (4 lembar)</li>
									<li>Fotokopi Hitam Putih 3X4 (4 lembar)</li>
									<li>Fotokopi Ijazah SMP/MTs/Sederajat (Bagi Yang Sudah Punya - 4 lembar)</li>
									<li>Fotokopi Rapor SMP/MTs/Sederajat Semester 1-5 (Disertai Halaman Identitas Siswa - 1 lembar)</li>
									<li>Fotokopi KIP / KKC (Bagi Yang Punya - 1 lembar)</li>
									<li>Surat Keterangan NISN dari SMP/MTs (1 lembar)</li>
									<li>Persyaratan Tambahan (Khusus Jalur Prestasi dan Afiliasi)</li>
								</ol>
							</li>
							<li>Biaya Pendaftaran Rp. 50.000,- Semua Jurusan</li>
						</ul>
					</li>
					<li class="mb-1.5">
						Verifikasi Administrasi
						<ul class="mb-1.5 sm:pl-3 pl-1 dash-marker">
							<li>Melakukan Daftar Ulang dan Administrasi Seragam dilakukan di SMK Muhammadiyah Bligo.</li>
						</ul>
					</li>
					<li class="mb-1.5">
						Test Fisik dan Wawancara
						<ul class="mb-1.5 sm:pl-3 pl-1 dash-marker">
							<li>Sehat jasmani, tidak bertindik, tidak bertato, rambut tidak diwarnai</li>
							<li>Tidak buta warna untuk jurusan Teknik (TSM, TKJ, TKR)</li>
						</ul>
					</li>
				</ol>
			</article>
		</div>
	</section>

	{{-- Berkas Section --}}
	<section id="berkasSection" class="w-full bg-primary text-white">
		<div class="max-w-screen-lg mx-auto px-4 py-8 md:py-14">
			<h1 class="text-2xl md:text-3xl font-bold text-center mb-2">
				Berkas Pendaftaran
			</h1>
			<p class="mb-4 text-center">
				Unduh berkas atau dokumen pendaftaran ppdb online 2023.
			</p>

			<div class="flex flex-wrap justify-center items-center gap-4">
				<?php $berkas = [
					[
						'label' => 'Persyaratan',
						'href' => '/storage/berkas/persyaratan-jalur-ppdb-2023.pdf',
					],
				] ?>

				@foreach($berkas as $row)
					<a href="{{ $row['href'] }}" class="flex-1 max-w-max px-4 py-2 text-center
					rounded bg-white text-black hover:bg-secondary transition" download>
						<i class="fa fa-download mr-1.5"></i> {!! $row['label'] !!}
					</a>
				@endforeach
			</div>
		</div>
	</section>

@endsection