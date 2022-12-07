@push('modals')
	@component('admin.components.modal', [
		'id' => $card['id'] ?? 'modalDetail'.$row->id,
		'title' => $card['title'] ?? 'Detail Siswa',
		'size' => 'max'
	])

		<ol>
			@foreach ($inputs as $input)
				@if(!isset($input[0]) || is_null($input[0]))
					<br>
					@continue
				@endif
				<li>
					<b>{{ $input[0] }}</b>
					@isset($input[1])
						: {{ $input[1] }}
					@endisset
				</li>

			@endforeach
		</ol>

	@endcomponent
@endpush