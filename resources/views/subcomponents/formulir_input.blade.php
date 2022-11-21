<?php
$input = FormHelper::initInput($input);
$error = isset($errors) && $errors->has($input['name']);
$no ??= '00';
?>

@if($input['type'] ==='hidden')

	<input type="{{ $input['type'] }}"
		name="{{ $input['name'] }}"
		id="{{ $input['id'] }}"
		placeholder="{{ $input['placeholder'] }}"
		value="{{ old($input['name']) ?? $input['value'] ?? '' }}"
		class="w-full px-3 py-2 bg-white backdrop-brightness-95 rounded border"
		{!! $input['attr'] !!}
	/>

@else

	<div class="w-full grid grid-cols-3 grid-rows-auto place-items-start justify-items-stretch gap-1 mb-3">
		<label for="{{ $input['id'] }}" class="col-span-3 sm:col-span-1 flex items-center relative after:content-[':'] after:block sm:after:absolute after:right-0">
			{{ $no }}. {{ $input['label'] }}
		</label>
		
		<div class="col-span-3 sm:col-span-2">
			@if(in_array($input['type'], ['radio', 'checkbox']))

				<div class="flex flex-wrap flex-row items-center gap-x-4 gap-y-2">
					@foreach ($input['values'] as $value)
					<?php
						$id = $input['id'] . mt_rand(1, 99);
						$checked = $input['value'] === $value || old($input['name']) === $value;
					?>
						<div class="flex flex-nowrap gap-2 items-center">
							<input type="radio" name="{{ $input['name'] }}" id="{{ $id }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}>
							<label for="{{ $id }}" class="">{{ $value }}</label>
						</div>
					@endforeach
				</div>
			
			@elseif($input['type'] === 'subform')

				<div class="w-full grid grid-cols-1 grid-rows-auto gap-2 mb-3">
					@foreach($input['inputs'] as $input)

					{{-- Row --}}
						<div class="w-full col-span-1 flex flex-row items-center justify-center gap-2">
							@foreach ($input as $subinput)
							{{-- Col --}}

								<?php
									$subinput = FormHelper::initInput($subinput);
									$error = isset($errors) && $errors->has($subinput['name']);
								?>

								<div class="flex-1 grid grid-cols-1 grid-rows-auto">
									<div class="w-full col-span-1 flex flex-col sm:flex-row items-start sm:items-center gap-2">
										<label for="{{ $subinput['id'] }}" class="min-w-max flex items-center relative after:content-[':'] after:block sm:after:absolute after:right-0">
											{{ $subinput['label'] }}
										</label>
										<input type="{{ $subinput['type'] }}"
											name="{{ $subinput['name'] }}"
											id="{{ $subinput['id'] }}"
											placeholder="{{ $subinput['placeholder'] }}"
											value="{{ old($subinput['name']) ?? $subinput['value'] ?? '' }}"
											class="w-full flex-1 px-3 py-2 bg-white backdrop-brightness-95 rounded border {{ $error?'border-red-800':'' }}"
											{!! $subinput['attr'] !!}
										/>
									</div>
									@error($subinput['name'] ?? null)
										<p class="col-span-1 text-sm text-red-800">
											<i class="fas fa-exclamation-triangle mr-1"></i> {{ __($message) }}
										</p>
									@enderror
								</div>

								@endforeach
								
							</div>

					@endforeach
				</div>
			
			@elseif($input['type'] === 'select')

				<select type="{{ $input['type'] }}"
					name="{{ $input['name'] }}"
					id="{{ $input['id'] }}"
					class="w-full px-3 py-2 bg-white backdrop-brightness-95 rounded border {{ $error?'border-red-800':'' }}"
					{!! $input['attr'] !!}
				>
					@foreach ($input['options'] as $option)
						<?php
						if (is_array($option)) {
							$value = $option['value'];
							$label = $option['label'];
						} else $value = $label = $option;
						$selected = $input['value'] === $value || old($input['name']) === $value
						?>
						<option value="{{ $value }}" {{ $selected ? 'selected' : '' }} >
							{{ $label }}
						</option>
					@endforeach	
				</select>

			@else

				<input type="{{ $input['type'] }}"
					name="{{ $input['name'] }}"
					id="{{ $input['id'] }}"
					placeholder="{{ $input['placeholder'] }}"
					value="{{ old($input['name']) ?? $input['value'] ?? '' }}"
					class="w-full px-3 py-2 bg-white backdrop-brightness-95 rounded border {{ $error?'border-red-800':'' }}"
					{!! $input['attr'] !!}
				/>

			@endif
		</div>

		@error($input['name'] ?? null)
			<p class="col-span-3 text-sm text-red-800 -mt-1">
				<i class="fas fa-exclamation-triangle mr-1"></i> {{ __($message) }}
			</p>
		@enderror
	</div>
@endif