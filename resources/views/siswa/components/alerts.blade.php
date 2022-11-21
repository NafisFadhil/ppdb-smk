@if($errors->has('alerts'))
	<div class="position-fixed top-0 end-1 p-2 row vw-100" style="z-index: 5; max-width: 275px">
		@foreach ($errors->get('alerts') as $variant => $msg)
			<?php $icon = $variant === 'success' ? 'check' : 'exclamation-triangle' ?>
			<div class="w-100 alert alert-{{ $variant }} d-flex align-items-center gap-2 text-white fade show mb-2">
				<i class="fa fa-{{ $icon }} fa-2x"></i>
				<p class="m-0" style="flex: 1;line-height: 1.25rem">{!! $msg !!}</p>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		@endforeach
	</div>
@endif