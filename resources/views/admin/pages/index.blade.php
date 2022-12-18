@extends('layouts.admin')

<?php 
$counters = [
	'peserta' => $peserta->count(),
	'pendaftar' => 0,
	'duseragam' => 0,
	'lulus' => 0,
];

foreach ($peserta as $item) {
	if ($item->status_id > 0 && $item->status_id < 4) $counters['pendaftar']++;
	elseif ($item->status_id > 3 && $item->status_id < 7) $counters['duseragam']++;
	else $counters['lulus']++;

	if ($item->jurusan) $jurusanCounters[strtolower($item->nama_jurusan)]++;
}

$widgetStatus = [
	['title' => 'Peserta', 'count' => $counters['peserta']],
	['title' => 'Pendaftar', 'count' => $counters['pendaftar']],
	['title' => 'DU & Seragam', 'count' => $counters['duseragam']],
];

$widgetJurusan = [];
foreach ($jurusanCounters as $key => $count) {
	$widgetJurusan[] = ['color' => 'primary', 'title' => strtoupper($key), 'count' => $count];
}
?>

@section('content')
	<div class="row" style="gap: 1rem">
		<div class="col-12">
			<div class="row justify-content-center">
				@foreach ($widgetStatus as $widget)
					<div class="col-12 col-sm-6 col-md-4">
						<div class="info-box info-box-dark">
							<span class="info-box-icon bg-dark">
								<i class="{{ $widget['icon'] ?? 'fa fa-user' }}"></i>
							</span>
							<div class="info-box-content">
								<span class="info-box-text">{{ $widget['title'] ?? null }}</span>
								<span class="info-box-number">{{ $widget['count'] ?? null }}</span>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>

		<div class="col-12">
			<h5>Jumlah Peserta Per-Jurusan</h5>
			<div class="row justify-content-center">
				@foreach ($jurusanCounters as $jurusan => $count)
					<div class="col-12 col-sm-4 col-md-3">
						<div class="info-box">
							<span class="info-box-icon">
								<img src="/dist/img/logo-{{ strtolower($jurusan) }}.png" alt="Logo {{ $jurusan }}" width="75" class="">
							</span>
							<div class="info-box-content">
								<span class="info-box-text text-uppercase">{{ $jurusan }}</span>
								<span class="info-box-number">{{ $count }}</span>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection