@extends('layouts.admin')

<?php $data = $peserta ?? $data ?>

@section('content')
<div class="row">
	@include('admin.components.filter', ['filters' => $filters])
	
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-start align-items-center flex-wrap flex-row p-1" style="gap: .5rem">
				@if($type === 'duseragam')
					<a href="/admin/laporan/daftar-ulang/precetak?type=daftar_ulang" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak Pre-Laporan Daftar Ulang
					</a>
					<a href="/admin/laporan/seragam/precetak?type=seragam" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak Pre-Laporan Seragam
					</a>
				@else
					<a href="/admin/laporan/{{ $type }}/precetak?type={{ $type }}" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak Pre-Laporan
					</a>
				@endif
			</div>
			<div class="card-body p-2">
				@include('admin.tables.verifikasi-'.$table??'')
			</div>
		</div>
	</div>
	
	@include('admin.components.paginate')
</div>
@endsection