<?php 
	$th ??= [];
	$td ??= [];
	$data ??= [];
?>

{{-- @dd(get_defined_vars()) --}}
<div class="w-100" style="overflow-x: auto">
	<table id="xtable" class="mb-0 table table-sm table-bordered table-hover table-sm">
		<thead>
			<tr>
				<th>No</th>
				@foreach ($th as $item)
					<th>{!! $item !!}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $row)
				<tr>
					<td>{{ $loop->iteration }}</td>
					@foreach ($td as $item)
						<td>{{ $item($row) }}</td>
					@endforeach
				</tr>
			@endforeach
			
			@if(count($data) === 0)
				<tr>
					<td colspan="{{ count($th)+2 }}" class="text-center">Belum ada data.</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>