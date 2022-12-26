@extends('layouts.admin')

<?php $data = $peserta ?? $data ?>

@section('content')
<div class="row">
	@include('admin.components.filter', ['filters' => $filters])
	
	<div class="col-12">
		<div class="card">
			<div class="card-body p-2">
				@include('admin.tables.'.$table??'')
			</div>
		</div>
	</div>
	
	@include('admin.components.paginate')
</div>
@endsection