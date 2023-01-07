@extends('layouts.admin')

<?php $data = $peserta ?? $data; $type ??= $table ?? '' ?>
<?php $precetak ??= false ?>

@section('content')
<div class="row">
	@include('admin.components.filter', ['filters' => $filters])
	
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-start align-items-center flex-wrap flex-row p-1" style="gap: .5rem">
				@if($type === 'duseragam')
					<?php 
						$queries = request()->getQueryString();
						$queries = is_null($queries) ? null : '?'.$queries.'&type=daftar_ulang';
					?>
					<a href="/admin/laporan/daftar-ulang/precetak{{ $queries }}" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak All-Laporan Daftar Ulang
					</a>

					<?php 
						$queries = request()->getQueryString();
						$queries = is_null($queries) ? null : '?'.$queries.'&type=seragam';
					?>
					<a href="/admin/laporan/seragam/precetak{{ $queries }}" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak All-Laporan Seragam
					</a>
				@else
					<?php 
						$queries = request()->getQueryString();
						$queries = is_null($queries) ? null : '?'.$queries.'&type='.$type;
					?>
					<a href="/admin/laporan/{{ $type }}/precetak{{ $queries }}" target="_blank" class="btn bg-none text-primary btn-sm">
						<i class="fa fa-print"></i> Cetak All-Laporan
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