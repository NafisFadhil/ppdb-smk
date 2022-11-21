@extends('layouts.siswa')

<?php 
	$user = auth()->user();
	$status = $user->level->name;
	$pendaftaran = $user->pendaftaran;
	$identitas = $pendaftaran->identitas;
	$pembayaran = $pendaftaran->pembayaran;
	$overview = [
		['label' => 'Status', 'value' => $status],
		['label' => 'Jalur Pendaftaran', 'value' => $identitas->jalur_pendaftaran],
		['label' => 'Biaya Total', 'value' => NumberHelper::toRupiah(
			$pembayaran->biaya_pendaftaran + $pembayaran->biaya_daftar_ulang + $pembayaran->biaya_seragam
			)],
	]
?>

@section('main')
	<div class="row gap-4">
		<div class="col-12">
			<div class="card bg-gradient-primary">
				<div class="card-body p-4">
					<div class="w-100 d-flex flex-column justify-content-center align-items-center">
						<h3 class="text-white">{{ auth()->user()->name }}</h3>
						<ul class="text-white text-center m-0 p-0" style="list-style: none">
							@foreach ($overview as $item)
								<li>
									<b>{{ $item['label'] }}</b> :
									{{ StringHelper::toTitle( $item['value'] ) }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="col-12">
			<div class="card h-100">
				<div class="card-header pb-0">
					<h6>Progress Overview</h6>
					<p class="text-sm">
						<i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
						<span class="font-weight-bold">24%</span> this month
					</p>
				</div>
				<div class="card-body p-3">
					<div class="timeline timeline-one-side">
						<div class="timeline-block mb-3">
							<span class="timeline-step">
								<i class="ni ni-bell-55 text-success text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
							</div>
						</div>
						<div class="timeline-block mb-3">
							<span class="timeline-step">
								<i class="ni ni-html5 text-danger text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
							</div>
						</div>
						<div class="timeline-block mb-3">
							<span class="timeline-step">
								<i class="ni ni-cart text-info text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
							</div>
						</div>
						<div class="timeline-block mb-3">
							<span class="timeline-step">
								<i class="ni ni-credit-card text-warning text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
							</div>
						</div>
						<div class="timeline-block mb-3">
							<span class="timeline-step">
								<i class="ni ni-key-25 text-primary text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
							</div>
						</div>
						<div class="timeline-block">
							<span class="timeline-step">
								<i class="ni ni-money-coins text-dark text-gradient"></i>
							</span>
							<div class="timeline-content">
								<h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
								<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
@endsection