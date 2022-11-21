@if($errors->get('alerts'))
	<?php $alerts = $errors->get('alerts') ?? [] ?>
		@foreach ($alerts as $variant => $alert)
		<?php 
			$icon = 'fas fa-lg ' . ($variant === 'success' ? 'fa-check' : 'fa-exclamation-triangle')
		?>
		
		<script>
			$(function () {
				$(document).Toasts('create', {
					class: 'bg-{!! $variant !!}',
					body: "{!! $alert['msg'] ?? '' !!}",
					title: "{!! $alert['title'] ?? 'Pemberitahuan' !!}",
					icon: "{!! $alert['icon'] ?? $icon !!}",
				})
			})
		</script>

		@endforeach
@endif
