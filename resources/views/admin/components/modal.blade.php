<?php
$id ??= 'modal';
$size ??= '';
?>

<div class="modal fade" id="{{ $id ?? 'modal' }}">
	<div class="modal-dialog modal-{{ $size ?? 'lg' }}">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{{ $title ?? '' }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{!! $slot ?? $body ?? '' !!}
			</div>
			{{-- <div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> --}}
		</div>
	</div>
</div>