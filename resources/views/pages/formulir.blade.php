@extends('layouts.general')

<?php 
$forms = [
	['title' => 'Data Pendaftaran', 'inputs' => [
		['name' => 'nama_lengkap'],
		['name' => 'jurusan'],
		['name' => 'asal_sekolah'],
	]],
	['title' => 'Data Pribadi', 'inputs' => [
		['type' => 'radio', 'name' => 'jenis_kelamin', 'values' => [
			'Laki-laki', 'Perempuan'
		]],
		['type' => 'number', 'name' => 'nisn', 'label' => 'NISN'],
		['name' => 'tempat_lahir'],
		['type' => 'date', 'name' => 'tanggal_lahir'],
		['type' => 'number', 'name' => 'nomor_nik', 'label' => 'No. NIK'],
		['type' => 'number', 'name' => 'nomor_kk', 'label' => 'No. KK'],
	]],
	['title' => 'Data Lokasi', 'inputs' => [
		['name' => 'nama_jalan'],
		['name' => 'rt', 'label' => 'RT', 'placeholder' => 'No. RT'],
		['name' => 'rw', 'label' => 'RW', 'placeholder' => 'No. RW'],
		['name' => 'nama_desa', 'label' => 'Desa', 'placeholder' => 'Nama Desa'],
		['name' => 'nama_kecamatan', 'label' => 'Kecamatan', 'placeholder' => 'Nama Kecamatan'],
	]]
]
?>

@section('content')
	<main class="w-full relative">
		<div class="max-w-screen-lg mx-auto p-4 md:p-8 lg:p-16 grid grid-cols-1 grid-rows-auto gap-4 sm:gap-8">

			@foreach ($forms as $form)
				<section class="card w-full relative rounded shadow bg-white overflow-hidden">
					<div class="card-header w-full bg-dark text-white px-4 py-1 sm:py-2 flex justify-between items-center">
						<span class="text-lg font-semibold">{{ $form['title'] ?? '' }}</span>
						<button type="button" class="p-1" data-card="toggler" data-toggle="min">
							<i class="fas fa-angle-down"></i>
						</button>
					</div>
					<div class="card-body w-full p-3 2xs:p-5 md:p-10">

						@foreach ($form['inputs'] as $input)
							<?php $input = FormHelper::initInput($input) ?>

							<div class="w-full grid grid-cols-3 grid-rows-auto gap-1 mb-3">
								<label for="{{ $input['id'] }}" class="col-span-3 md:col-span-1 flex items-center relative after:content-[':'] after:block md:after:absolute after:right-0">
									{{ $input['label'] }}
								</label>
								<div class="col-span-3 md:col-span-2">

									@if(in_array($input['type'], ['radio', 'checkbox']))
									@elseif($input['type'] === 'select')
									@else

										<input type="{{ $input['name'] }}"
											name="{{ $input['name'] }}"
											id="{{ $input['id'] }}"
											placeholder="{{ $input['placeholder'] }}"
											value="{{ old($input['name']) ?? $input['value'] }}"
											class="w-full px-3 py-2 bg-white backdrop-brightness-95 rounded border"
											{!! $input['attr'] !!}
										/>

									@endif
									
								</div>
							</div>
						@endforeach
						
					</div>
				</section>
			@endforeach
			
		</div>
	</main>
@endsection