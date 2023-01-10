@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					@foreach($inputs as $input)
						<?php $input = FormHelper::initInput($input) ?>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection