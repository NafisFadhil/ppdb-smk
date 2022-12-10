@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ $form['action'] ?? '' }}" method="{{ $form['method'] ?? 'post' }}">
					@csrf @isset($form['submethod']) @method($form['submethod']) @endisset

					@foreach ($form['inputs'] as $input)
						@include('admin.components.input', ['input' => $input])
					@endforeach

					<div class="form-group text-center">
						@isset($form['button'])
							<button type="submit" class="btn {{ $form['button']['variant'] }} btn-block mx-auto"
								style="max-width: max-content">
								{!! $form['button']['content'] !!}
							</button>
						@endisset
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection