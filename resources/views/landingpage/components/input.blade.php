<?php
$input = FormHelper::initInput($input);
$error = isset($errors) && $errors->has($input['name']);
$no = isset($no) && !empty($no) ? $no.'.' : null;
$size = $input['size'] ?? 'sm';
?>

@if($input['type'] === 'hidden')

	<input type="{{ $input['type'] }}"
		name="{{ $input['name'] }}"
		id="{{ $input['id'] }}"
		placeholder="{{ $input['placeholder'] }}"
		value="{{ old($input['name']) ?? $input['value'] ?? '' }}"
		class="form-control form-control-{{ $size }}"
		class="{{ $input['class'] ?? '' }}"
		style="{{ $input['style'] ?? '' }}"
		{!! $input['attr'] !!}
	/>

@else

	<div class="form-group row {{ $input['name'] === 'sub_jalur_pendaftaran_id' ? 'mb-0' : 'mb-2' }}">
		
		@if($input['name'] === 'sub_jalur_pendaftaran_id')
			<label class="form-label d-none d-sm-block col-12 col-md-4 m-0 p-0">
			</label>
		@elseif(!in_array($input['variant'], ['nolabel', 'filter']))
			<label for="{{ $input['id'] }}" class="form-label text-{{ $size }} col-12 col-md-4 input-titiks">
				{{ $no }} {{ $input['label'] }}
				{!! in_array('required', $input['opts']) ?
					'<small class="text-primary"><b>*</b></small>' : ''
				!!}
			</label>
		@else
		@endif
		
		@if(in_array($input['variant'], ['nolabel']))
			<div class="col-12">
		@else
			<div class="col-12 col-md-8">
		@endif

			@if(in_array($input['type'], ['radio', 'checkbox']))

				@foreach ($input['values'] as $values)
				<?php
					if (is_array($values)) {
						$value = $values['value'];
						$label = $values['label'];
					} else $value = $label = $values;
					
					$id = $input['id'] . rand(1, 99999);
					$checked = $input['value'] == $value || old($input['name']) == $value;
					$checked = $checked || (
						$input['name'] === 'jalur_pendaftaran_id' && $input['value']??old($input['name'])??0 > 3 && $value == 3
					);
				?>
					<div class="form-check d-inline-block mr-2">
						<input type="radio"
							name="{{ $input['name'] }}"
							id="{{ $id }}"
							value="{{ $value }}"
							class="form-check-input"
							class="{{ $input['class'] ?? '' }}"
							style="{{ $input['style'] ?? '' }}"
							{!! $input['attr'] !!}
							@checked($checked)
						/>
						<label for="{{ $id }}" class="form-check-label">{{ $label }}</label>
					</div>
				@endforeach
			
			@elseif($input['type'] === 'select')

				<select type="{{ $input['type'] }}"
					name="{{ $input['name'] }}"
					id="{{ $input['id'] }}"
					class="form-control form-control-{{ $size }} {{ $error?'is-invalid':'' }}"
					style="width: 100%"
					class="{{ $input['class'] ?? '' }}"
					style="{{ $input['style'] ?? '' }}"
					{!! $input['attr'] !!}
				>
					@foreach ($input['options'] as $option)
						<?php
						if (is_array($option)) {
							$value = $option['value'];
							$label = $option['label'];
						} else $value = $label = $option;
						
						$selected = !$loop->first && $input['value'] == $value || old($input['name']) == $value;
						?>
						<option value="{{ $value }}" {{ $selected ? 'selected' : null }}>
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
					class="form-control form-control-{{ $size }} {{ $error?'is-invalid':'' }} 
					{{ in_array('uppercase', $input['opts']) ? 'input-uppercase' : '' }}"
					class="{{ $input['class'] ?? '' }}"
					style="{{ $input['style'] ?? '' }}"
					{!! $input['attr'] !!}
				/>

			@endif
		</div>

		@error($input['name'])
			<span class="col-12 error invalid-feedback">
				__($message)
			</span>
		@enderror
		
	</div>
@endif