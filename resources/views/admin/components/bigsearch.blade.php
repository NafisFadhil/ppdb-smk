<?php
$variant ??= 'default';
$input = FormHelper::initInput($input);
?>

<div class="w-100 mx-auto" style="max-width: max-content">
	<div class="card">
		<div class="card-body text-center">
			@if($variant !== 'noform') <form action=""> @endif
				<div class="input-group d-flex flex-nowrap">
					<div class="input-group-prepend">
						<div class="input-group-text">
							<i class="fa fa-search"></i>
						</div>
					</div>
					<input
						type="search"
						name="{{ $input['name'] }}"
						id="{{ $input['id'] }}"
						class="form-control vw-100"
						value="{{ old('search') ?? request('search') ?? '' }}"
						placeholder="{{ $input['placeholder'] }}" style="max-width: 400px"
						autofocus autocomplete="false"
					>
					<div class="input-group-append">
						<button class="btn btn-primary btn-sm">Temukan</button>
					</div>
				</div>
			@if($variant !== 'noform') </form> @endif
		</div>
	</div>
</div>