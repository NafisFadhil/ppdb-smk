@extends('layouts.admin')

@section('content')
	<form id="filterForm" action="" class="row">
		@include('admin.components.filter', ['filters' => $filters, 'errors' => $errors])
	</form>

	<div class="col-12 p-0">
		<div class="card">
			<div class="card-header p-1">
				<a href="/{{ request()->path() }}/cetak?type={{ $type }}" target="_blank" class="btn bg-none text-primary btn-sm">
					<i class="fa fa-print"></i> Cetak Laporan
				</a>
			</div>
			<div class="card-body p-2" style="overflow-x: auto; font-size: 12px">
				@include('admin.pages.table.'.$bigtype, ['type' => $type, 'laporan' => $laporan])
			</div>
		</div>
	</div>

	@if($laporan->hasPages())
		<div class="col-12 p-0">
			<div class="card">
				<div class="card-body pb-0 pt-4">
					<div class="mx-auto" style="max-width: max-content">
						{!! $laporan->links('pagination::bootstrap-4') !!}
					</div>
				</div>
			</div>
		</div>
	@endif
		
	</div>
@endsection