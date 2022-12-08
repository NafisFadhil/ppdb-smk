<?php
$id ??= 'modal';
$size ??= 'lg';
$max = $size === 'max';
?>

<div class="modal fade" id="{{ $id }}">
	<div class="modal-dialog modal-{{ $max ? 'xl' : $size }}" {!! $max ? 'style="max-width: max-content"' : '' !!}>
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
		</div>
	</div>
</div>