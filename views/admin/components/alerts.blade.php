@if($errors->get('alerts'))
	<?php $alerts = $errors->get('alerts') ?? [] ?>
		@foreach ($alerts as $variant => $msg)
		<?php 
			$icon = 'fa fa-lg ' . ($variant === 'success' ? 'fa-check' : 'fa-exclamation-triangle')
		?>
		
		<script>
			$(function () {
				$(document).Toasts('create', {
					class: 'bg-{{ $variant }}',
					body: "{!! $msg !!}",
					title: "Pemberitahuan",
					icon: "{!! $icon !!}",
				})
			})
		</script>

		@endforeach
@endif
