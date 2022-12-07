@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalDetail'.$row->id,
		'title' => 'Detail Siswa',
		'size' => 'max'
	])

		<ol>
			@foreach ($inputs as $input)
				<li> <b>{{ $input[0] }}</b> : {{ $input[1] }} </li>
			@endforeach
		</ol>

	@endcomponent
@endpush