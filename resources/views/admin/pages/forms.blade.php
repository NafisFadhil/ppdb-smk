@extends('layouts.admin')

<?php
$form = FormHelper::initForm($form);

function htmlFormOnly($subform, $row = false) { ?>
	<form action="{{ $subform['action'] }}"
	method="{{ $subform['method'] }}"
	enctype="{{ $subform['enctype'] }}"
	class="{{ $row ? 'row gap-2' : 'false' }}">
		@isset($subform['submethod'])
			@method($subform['submethod'])
		@endisset
		@csrf 
<?php }

function htmlButtonOnly($button) { ?>
	<a href="{{ back()->getTargetUrl() }}" class="btn btn-sm btn-secondary mx-auto"
	style="max-width: max-content">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
	<button type="submit" class="btn btn-sm btn-{{ $button['variant'] }} mx-auto"
	style="max-width: max-content">
		{!! $button['content'] !!}
	</button>
<?php } ?>

@section('content')

	@if ($form['variant'] === 'dimensionalform')

		<div class="row" style="gap: 1rem">
			@foreach ($form['inputs'] as $subform)
				<div class="col-12 col-md-6">	
					<div class="card">
						@isset($subform['title'])
							<div class="card-header">
								<h5> {{ $subform['title'] }} </h5>
							</div>
						@endisset
						<div class="card-body">
							{!! htmlFormOnly($subform) !!}
				
								@foreach ($subform['inputs'] as $input)
									@include('admin.components.input', ['input' => $input])
								@endforeach
					
								<div class="form-group text-center mb-3">
									{!! htmlButtonOnly($subform['button']) !!}
								</div>

							</form>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		
	@elseif ($form['variant'] === 'multiform')

		{!! htmlFormOnly($form, true) !!}
			@foreach ($form['inputs'] as $subform)
				<div class="{{ $form['cols'] }}">
					<div class="card">
						@isset($subform['title'])
							<div class="card-header m-0 py-2 px-3">
								<h5 class="m-0"> {{ $subform['title'] }} </h5>
							</div>
						@endisset

						<div class="card-body">
							@foreach ($subform['inputs'] as $input)
								@include('admin.components.input', ['input' => $input])
							@endforeach
						</div>
					</div>
				</div>
			@endforeach

			<div class="col-12 text-center mb-3">
				{!! htmlButtonOnly($form['button']) !!}
			</div>
		</form>
		
	@else

		{!! htmlFormOnly($form, true) !!}
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						{!! htmlFormOnly($form) !!}
			
						@foreach ($form['inputs'] as $input)
							@include('admin.components.input', ['input' => $input])
						@endforeach
			
						<div class="form-group text-center mb-3">
							{!! htmlButtonOnly($form['button']) !!}
						</div>

						</form>
			
					</div>
				</div>
			</div>
		</form>

	@endif

@endsection

@push('scripts')
	<script>
		let jalurs = document.querySelectorAll('input[name=jalur_pendaftaran_id]');
		let jalurPrestasi = document.querySelector('select[name=sub_jalur_pendaftaran_id]');
		jalurPrestasi.style.display = 'none';
		jalurs.forEach(elem => {
			elem.onclick = () => {
				let value = elem.value;
				if (value == 3) {
					jalurPrestasi.style.display = 'inline-block';
				} else jalurPrestasi.style.display = 'none';
			}
			if (elem.hasAttribute('checked')) elem.click();
		})
	</script>
@endpush