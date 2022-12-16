@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<button class="btn btn-block btn-primary mx-auto" data-toggle="modal" data-target="#modalTambahSponsorship" style="max-width: max-content">
					<i class="fa fa-plus"></i> Tambah Sponsorship
				</button>
				@push('modals')
					@component('admin.components.modal', [
						'id' => 'modalTambahSponsorship',
						'title' => 'Tambah Sponsorship'
					])
						<form action="/admin/verifikasi/sponsorship" method="post">
							@csrf <?php $inputs = [
								['name' => 'nama'],
								['name' => 'kelas'],
								['name' => 'no_wa'],
							] ?>

								@foreach ($inputs as $input)
								<?php $input = FormHelper::initInput($input) ?>
								<div class="form-group form-group-sm">
									<label for="{{ $input['id'] }}" class="form-label">{{ $input['label'] }}</label>
									<input type="{{ $input['type'] }}"
										name="{{ $input['name'] }}"
										placeholder="{{ $input['placeholder'] }}"
										value="{{ $input['value'] }}"
										class="form-control form-control-sm"
										{!! $input['attr'] !!}
									/>
								</div>
								@endforeach

								<div class="form-group form-group-sm">
									<label class="form-label"> Siswa Pendaftaran </label>
									<select name="identitas_id" class="form-control form-control-sm select2" style="width: 100%">
										<option value> Pilih Siswa </option>
										@foreach ($peserta as $row)
											<option value="{{ $row->id }}"> {{ $row->nama_lengkap }} ({{ $row->asal_sekolah }}) </option>
										@endforeach
									</select>
								</div>

								<button class="btn btn-primary mx-auto" style="max-width: max-content">
									Tambah
								</button>
							
						</form>
					@endcomponent
				@endpush
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
			<div class="card-body">
					<table id="xtable" class="table table-sm table-bordered table-hover table-responsive">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Sponsorship</th>
								<th>Kelas Sponsorship</th>
								<th>No WA Sponsorship</th>
								<th>Nama Siswa</th>
								<th>Asal Sekolah</th>
								<th>Jurusan</th>
								<th>Status Pendaftaran</th>
								<th>Tindakan</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sponsorship as $row)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $row->nama }}</td>
									<td>{{ $row->kelas }}</td>
									<td>{{ $row->no_wa }}</td>
									<td>{{ $row->identitas->nama_lengkap }}</td>
									<td>{{ $row->identitas->asal_sekolah }}</td>
									<td>{{ strtoupper($row->identitas->nama_jurusan) }}</td>
									<td title="{{ $row->identitas->status->desc }}">
										{{ $row->identitas->status->level }} ({{ $row->identitas->status->sublevel }})
									</td>
									<td>
										<div class="btn-group btn-group-sm">

											<button type="button" title="Edit Data Pendaftaran" class="btn btn-secondary" onclick="window.location = '/admin/verifikasi/sponsorship/edit/{{ $row->id }}'">
												<i class="fa fa-pen"></i>
											</button>

										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				{!! $sponsorship->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection