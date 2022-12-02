@extends('layouts.admin')

<?php 
$counters = [
	'peserta' => $peserta->count(),
	'pendaftar' => 0,
	'daftar_ulang' => 0,
	'seragam' => 0
];
foreach ($peserta as $item) {
	if ($item->status_id > 0 && $item->status_id < 4) $counters['pendaftar'] += 1;
	elseif ($item->status_id > 3 && $item->status_id < 7) $counters['daftar_ulang'] += 1;
	elseif ($item->status_id > 6 && $item->status_id < 10) $counters['seragam'] += 1;
}
$widgetStatus = [
	['color' => 'info', 'title' => 'Peserta', 'count' => $counters['peserta']],
	['color' => 'primary', 'title' => 'Pendaftar', 'count' => $counters['pendaftar']],
	['color' => 'warning', 'title' => 'Daftar Ulang', 'count' => $counters['daftar_ulang']],
	['color' => 'success', 'title' => 'Seragam', 'count' => $counters['seragam']]
];
?>

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="row">
				@foreach ($widgetStatus as $widget)
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-{{ $widget['color'] }}">
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
	</div>
@endsection