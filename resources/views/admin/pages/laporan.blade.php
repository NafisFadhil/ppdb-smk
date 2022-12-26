@extends('layouts.admin')

@section('content')
<div class="row">
	@include('admin.components.filter', ['filters' => $filters])
	
	<div class="col-12">
		<div class="card">
			<div class="card-header p-1">
				<a href="/{{ request()->path() }}/cetak?type={{ $type }}" target="_blank" class="btn bg-none text-primary btn-sm">
					<i class="fa fa-print"></i> Cetak Laporan
				</a>
			</div>
			<div class="card-body p-2">
				@include('admin.tables.laporan-'.$bigtype, ['type' => $type, 'laporan' => $laporan])
			</div>
		</div>
	</div>
	
	@include('admin.components.paginate')
</div>
@endsection