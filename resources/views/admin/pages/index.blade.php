@extends('layouts.admin')

<?php
// Initiation Couters
$jurusan_types = [];
$general_types = ['pendaftaran', 'daftar_ulang', 'seragam'];
$pendaftaran_counter = [];
$daftar_ulang_counter = [];
$seragam_counter = [];
$general_counter = [
	'peserta' => 0,
	'pendaftaran' => 0,
	'daftar_ulang' => 0,
	'seragam' => 0,
];

// Init Counters Each Jurusan
foreach ($data_jurusans as $jurusan) {
	$jurusan_types[] = $jurusan->singkatan;
	$pendaftaran_counter[$jurusan->singkatan] = 0;
	$daftar_ulang_counter[$jurusan->singkatan] = 0;
	$seragam_counter[$jurusan->singkatan] = 0;
}

// Loop All Siswa
foreach ($siswa as $data) {
	$general_counter['peserta']++;

	// General Type Loop
	foreach ($general_types as $type) {

		if ($data->verifikasi->$type) {
			$general_counter[$type]++;

			// Per Jurusan
			$counter_name = $type.'_counter';
			$jurusan = strtolower($data->jurusan->singkatan);
			$$counter_name[$jurusan]++;
		}
		
	}
}

?>

@section('content')
	<div class="row">

		{{-- General Widget Counter --}}
		<div class="col-12 row">
			<h5 class="col-12">Jumlah Peserta Ter-Verifikasi</h5>
			@foreach(['peserta', ...$general_types] as $type)
				<div class="col-md-3 col-sm-6 col-12">
					<div class="info-box shadow">
						<span class="info-box-icon bg-dark">
							<i class="fa fa-user"></i>
						</span>

						<div class="info-box-content">
							<span class="info-box-text">{{ StringHelper::toTitle($type) }}</span>
							<span class="info-box-number">{{ $general_counter[$type] }}</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
			@endforeach
		</div>

		{{-- Per-Jurusan Widget Counter --}}
		@foreach($general_types as $type)
			<div class="col-12 row justify-content-center align-items-center flex-wrap w-100 my-3 my-md-4 px-2" style="gap:.8rem">
				<h5 class="col-12 m-0">Jumlah Ter-Verifikasi {{ StringHelper::toTitle($type) }}</h5>
				@foreach($jurusan_types as $jurusan)
					<div class="" style="flex:1;min-width:200px">
						<div class="info-box shadow m-0">
							<span class="info-box-icon">
								<img src="/dist/img/logo-{{ $jurusan }}.png"
									alt="Logo {{ StringHelper::toTitle($jurusan) }}"
									width="50"
									class=""
									style="aspect-ratio: 1/1">
							</span>

							<div class="info-box-content" style="line-height: 1.25">
								<span class="info-box-text">{{ strtoupper($jurusan) }}</span>
								<?php $counter_name = $type.'_counter'; ?>
								<span class="info-box-number">{{ $$counter_name[$jurusan] }}</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
				@endforeach
			</div>
		@endforeach

	</div>
@endsection