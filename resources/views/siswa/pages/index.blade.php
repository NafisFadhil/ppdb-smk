@extends('layouts.siswa')

<?php 
	$user = auth()->user();
	$identitas = $user->identitas;
	$status = $identitas->status;
	$pendaftaran = $identitas->pendaftaran;
	$jurusan = $identitas->jurusan;
	$seragam = $identitas->seragam;

	$overviewCard = [
		['label' => 'Status', 'value' => $status->level],
		['label' => 'Kode Pendaftaran', 'value' => $pendaftaran->kode ?? '(Belum Ada)'],
		['label' => 'Kode Jurusan', 'value' => $jurusan->kode ?? '(Belum Ada)'],
		['label' => 'Kode Seragam', 'value' => $seragam->kode ?? '(Belum Ada)'],
	];

	$identitasCard = [
		'title' => 'Data Pribadi',
		'list' => [
			['Nama', $identitas->nama_lengkap],
			['Asal Sekolah', $identitas->asal_sekolah],
			['Jenis Kelamin', $identitas->jenis_kelamin],
			['Tanggal Lahir', $identitas->tanggal_lahir],
			['Jalur Pendaftaran', $identitas->jalur_pendaftaran],
			['Jurusan', StringHelper::toCapital($identitas->nama_jurusan)],
		]
	];

	$progressCard = [
		'title' => 'Progress Overview',
		'icons' => [
			'on' => ['fa fa-check', 'success'],
			'off' => ['fa fa-times', 'danger'],
			'in' => ['fa fa-clock', 'primary'],
		]
	];

?>

@section('main')
	<div class="row g-4">
		{{-- Overview Card --}}
		<div class="col-12">
			<div class="card bg-gradient-primary">
				<div class="card-body p-4">
					<div class="w-100 d-flex flex-column justify-content-center align-items-center">
						<h3 class="text-white m-0">{{ auth()->user()->name }}</h3>
						<p class="text-white m-0 mb-2">{{ $status->desc }}</p>
						<ul class="text-white text-center m-0 p-0" style="list-style: none">
							@foreach ($overviewCard as $item)
								<li>
									<b>{{ $item['label'] }}</b> :
									{{ $item['value'] }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>

		{{-- Identitas Card --}}
		<div class="col-md-6 col-12">
			<div class="card h-auto">
				<div class="card-header pb-0">
					<h6>{{ $identitasCard['title'] }}</h6>
				</div>
				<div class="card-body p-3">
					<ol class="">
						@foreach ($identitasCard['list'] as $item)
							<li class="">
								<b>{{ $item[0] }}</b> : {{ $item[1] }}
							</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>

		{{-- Progress Overview Card --}}
		<div class="col-md-6 col-12">
			<div class="card h-100">
				<div class="card-header pb-0">
					<h6>{{ $progressCard['title'] }}</h6>
				</div>
				<div class="card-body p-3">
					<div class="timeline timeline-one-side">

						@foreach ($xstatus as $xstat)
							<?php
								$icon = $xstat->id < $status->id ? $progressCard['icons']['on'] : (
									$xstat->id > $status->id ? $progressCard['icons']['off'] : $progressCard['icons']['in']
								);
							?>
							<div class="timeline-block mb-3">
								<span class="timeline-step">
									<i class="{{ $icon[0] }} text-{{ $icon[1] }} text-gradient"></i>
								</span>
								<div class="timeline-content">
									<h6 class="text-dark text-sm font-weight-bold mb-0">
										{{ $xstat->level }} > {{ $xstat->sublevel }}
									</h6>
									<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
										{{ $xstat->desc }}
									</p>
								</div>
							</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection