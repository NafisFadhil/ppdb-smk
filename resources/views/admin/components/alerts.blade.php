@if($errors->get('alerts'))
	<?php $alerts = $errors->get('alerts') ?? [] ?>
		@foreach ($alerts as $variant => $msg)
			<?php 
				$msg = is_array($msg) ? $msg : [$msg];
				$icon = 'fa fa-lg ' . ($variant === 'success' ? 'fa-check' : 'fa-exclamation-triangle')
			?>
		
			@foreach($msg as $message)
				<script>
					$(function () {
						$(document).Toasts('create', {
							class: 'bg-{{ $variant }}',
							body: "{!! $message !!}",
							title: "Pemberitahuan",
							icon: "{!! $icon !!}",
						})
					})
				</script>
			@endforeach

		@endforeach
@endif
