@extends('layouts.siswa')

<?php 
$user = auth()->user();
$identitas = $user->identitas;
$forms = [
	[
		[
			'variant' => 'blank',
			'title' => 'Data Pokok',
			'inputs' => [
				['name' => 'nama_lengkap', 'attr'=> 'disabled'],
				['name' => 'jalur_pendaftaran', 'attr'=> 'disabled'],
				['name' => 'jenis_kelamin', 'attr'=> 'disabled'],
				['name' => 'tanggal_lahir', 'attr'=> 'disabled'],
				['name' => 'asal_sekolah', 'attr'=> 'disabled'],
			]
		],
		[
			'title' => 'Data Pribadi',
			'inputs' => [
				['name' => 'tempat_lahir'],
				['name' => 'nama_ayah'],
				['name' => 'nama_ibu'],
				['type' => 'number', 'name' => 'jumlah_saudara_kandung'],
			]
		],
		[
			'title' => 'Data Komunikasi',
			'inputs' => [
				['name' => 'no_wa_ortu'],
				['name' => 'no_wa_siswa'],
			]
		],
	],

	[
		[
			'title' => 'Data Lokasi',
			'inputs' => [
				['name' => 'alamat_desa', 'label' => 'Nama Desa'],
				['name' => 'alamat_kec', 'label' => 'Nama Kecamatan'],
				['name' => 'alamat_kota_kab', 'label' => 'Nama Kota/Kab'],
				['type' => 'number', 'name' => 'alamat_rt', 'label' => 'RT'],
				['type' => 'number', 'name' => 'alamat_rw', 'label' => 'RW'],
			]
		],
		[
			'title' => 'Data Nasional',
			'inputs' => [
				['type' => 'number', 'name' => 'nisn', 'label' => 'NISN'],
				['type' => 'number', 'name' => 'no_ujian_nasional', 'label' => 'No Ujian Nasional'],
				['type' => 'text', 'name' => 'no_ijazah', 'label' => 'No Ijazah'],
			]
		],
	],

]
?>

@section('main')
	{{-- <div class="row"> --}}
		<form action="/siswa/daftar-ulang" method="POST" class="row">
		@csrf

		@foreach ($forms as $form)
			<div class="col-12 col-md-6 row gap-4" style="height: max-content">

				@foreach($form as $subform)
					<div class="col-12">
						<div class="card">
							<div class="card-header pb-0">
								<h5> {{ $subform['title'] ?? '' }} </h5>
							</div>

							<div class="card-body">
								
								@foreach ($subform['inputs'] as $input)
									<?php $input = FormHelper::initInput($input) ?>
									
									<div class="form-group">
										<label for="{{ $input['id'] }}" class="form-label">
											{{ $input['label'] }}
										</label>

										<input type="{{ $input['type'] }}"
											name="{{ $input['name'] }}"
											id="{{ $input['id'] }}"
											value="{{ old($input['name']) ?? $identitas[$input['name']] ?? $input['value'] ?? '' }}"
											class="form-control form-control-sm"
											{!! $input['attr'] !!}
										/>
									</div>
								@endforeach

							</div>
						</div>
					</div>
				@endforeach
				
			</div>
		@endforeach

		<div class="col-12 text-center mt-4">
			<button type="submit" class="btn bg-gradient-primary">
				Submit
			</button>
		</div>

	</form>
	{{-- </div> --}}
@endsection