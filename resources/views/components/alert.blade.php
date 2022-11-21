@if($errors->get('alerts'))
	<?php
		$alerts = $errors->get('alerts') ?? [];
		$colors = [
			'error' => 'bg-red-800',
			'warning' => 'bg-yellow-600',
			'success' => 'bg-green-800'
		]
	?>

	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<symbol id="svg-success" fill="currentColor" viewBox="0 0 16 16">
			<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
		</symbol>
		<symbol id="svg-primary" fill="currentColor" viewBox="0 0 16 16">
			<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
		</symbol>
		<symbol id="svg-exclamation" fill="currentColor" viewBox="0 0 16 16">
			<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
		</symbol>
	</svg>
	
	<div class="fixed right-0 top-0 flex flex-col-reverse mt-2 pl-2 gap-2 z-20 w-screen max-w-[300px]">
		@foreach ($alerts as $variant => $msg)
			<?php
				$xvariant = $variant == 'success' || $variant == 'primary' ? $variant : 'exclamation';
				$color = $colors[$variant];
			?>
		
			<div class="{{ $color }} text-white flex-1 rounded-l-lg shadow flex flex-row justify-start items-center w-full overflow-hidden cursor-pointer"
			onclick="$(this).hide(500).delay(500).remove()">

				<div class="min-w-max grid place-items-center">
					<svg class="p-3" width="50" height="50" role="img" aria-label="{{ ucfirst($variant) }}:">
						<use xlink:href="#svg-{{ $xvariant }}" />
					</svg>
				</div>

				<p class="flex-1 h-full leading-5 p-3">
					{!! $msg !!}
				</p>

				<button type="button" class="p-1.5 leading-3 aspect-square mr-2">
					<i class="fas fa-times"></i>
				</button>

			</div>
		@endforeach
	</div>
@endif