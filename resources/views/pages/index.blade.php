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
						Siswa mengisi <a href="/formulir" class="text-primary">formulir pendaftaran</a>
						dan simpan kode pendaftaran yang muncul dengan screenshot atau lainnya.
					</li>
					<li class="mb-1.5">
						Siswa datang ke <a href="https://goo.gl/maps/zeZEoYMoG66fbGVg8" target="_blank" class="text-primary">smk muhammadiyah bligo</a> dengan membawa 
						uang pendaftaran dan dokumen persyaratan sebagaimana tertera dalam
						<a href="" class="text-primary">dokumen persyaratan jalur pendaftaran</a>.
					</li>
					<li class="mb-1.5">
						Setelah melakukan pembayaran, siswa akan mendapatkan kode jurusan yang bisa digunakan
						untuk <a href="/login" class="text-primary">login</a> dan memantau proses pendaftaran.
					</li>
					<li class="mb-1.5">
						Siswa sudah diperbolehkan melakukan daftar ulang dan melakukan pembayaran seragam.
					</li>
					<li class="mb-1.5">
						Daftar ulang dilakukan dengan <a href="/login" class="text-primary">login</a> dan
						melengkapi identitas, melakukan pembayaran daftar ulang, dan melakukan pembayaran seragam.
					</li>
					<li class="mb-1.5">
						Untuk pembayaran daftar ulang dan seragam dilakukan dengan datang ke smk muhammadiyah bligo,
						dan menemui panitia bagian pembayaran.
					</li>
					<li class="mb-1.5">
						Panitia akan memverifikasi pelunasan biaya daftar ulang dan seragam, dan memverifikasi kelengkapan
						identitas siswa.
					</li>
					<li class="mb-1.5">
						Setelah diverifikasi, siswa sudah selesai melakukan tahapan
						<a href="/" class="text-primary">PPDB Online 2023</a>.
					</li>
					<li class="mb-1.5">
						Harap pantau <a href="http://www.instagram.com/smkmuhbligo_ig" class="text-secondary">instagram</a>
						dan <a href="https://www.facebook.com/profile.php?id=100015024096175" class="text-secondary">facebook</a>
						untuk informasi tahapan selanjutnya.
					</li>
					<li class="mb-1.5">
						Selanjutnya siswa akan melakukan ujian fisik dan wawancara di
						<a href="https://goo.gl/maps/zeZEoYMoG66fbGVg8" target="_blank"
						class="text-primary" >smk muhammadiyah bligo</a>,
						dan akan diterima jika lulus di semua ujian masuk.
					</li>
				</ol>
			</article>

			<p class="text-center font-semibold text-lg mt-8 mb-3">Pendaftaran Semi-Online</p>
			<article class="max-w-screen-md mx-auto">
				<ol class="list-decimal pl-2">
					<li class="mb-1.5">
						Bagi yang memiliki kendala untuk mengikuti ppdb online, bisa melakukan pendaftaran semi-online.
					</li>
					<li class="mb-1.5">
						Pendaftaran semi-online dilakukan dengan datang ke
						<a href="https://goo.gl/maps/zeZEoYMoG66fbGVg8" target="_blank"
						class="text-primary" >smk muhammadiyah bligo</a>
						dan meminta panitia untuk mengisikan formulirnya.
					</li>
					<li class="mb-1.5">
						Untuk pembayaran sama, yaitu datang ke
						<a href="https://goo.gl/maps/zeZEoYMoG66fbGVg8" target="_blank"
						class="text-primary" >smk muhammadiyah bligo</a> dan melakukan pembayaran
						pada panitia bagian pembayaran.
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