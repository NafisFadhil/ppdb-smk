<?php $data = $peserta ?? $data ?? $laporan ?>

@if($data->hasPages())
<div class="col-12">
	<div class="card">
		<div class="card-body p-2 p-sm-3 p-md-4 text-center">
			<div class="mx-auto">
				{!! $data->links('vendor.pagination.bootstrap-4') !!}
			</div>
		</div>
	</div>
</div>
@endif