@extends('layouts.admin')

<?php 
$widgetStatus = [
	['color' => 'info', 'title' => 'Pendaftar', 'count' => $pendaftaran->count()],
	['color' => '', 'title' => 'Daftar Ulang']
]
?>

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="row">
				@foreach ($widgetStatus as $widget)
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-{{ $widget['color'] }}">
								<i class="{{ $widget['icon'] ?? 'fas fa-user' }}"></i>
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