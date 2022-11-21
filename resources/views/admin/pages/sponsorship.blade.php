@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<button class="btn btn-block btn-primary mx-auto" data-toggle="modal" data-target="#modalTambahSponsorship" style="max-width: max-content">
					<i class="fas fa-plus"></i> Tambah Sponsorship
				</button>
				@push('modals')
					@component('admin.components.modal', [
						'id' => 'modalTambahSponsorship',
						'title' => 'Tambah Sponsorship'
					])
						<form action="/admin/sponsorship" method="post">
							@csrf <?php $inputs = [
								['name' => 'nama_sponsorship'],
								['name' => 'kelas_sponsorship'],
								['name' => 'no_wa_sponsorship'],
							] ?>

								@foreach ($inputs as $input)
								<?php $input = FormHelper::initInput($input) ?>
								<div class="form-group form-group-sm">
									<label for="{{ $input['id'] }}" class="form-label">{{ $input['label'] }}</label>
									<input type="{{ $input['type'] }}"
										name="{{ $input['name'] }}"
										placeholder="{{ $input['placeholder'] }}"
										value="{{ $input['value'] }}"
										class="form-control"
										{!! $input['attr'] !!}
									/>
								</div>
								@endforeach

								<div class="form-group form-group-sm">
									<label class="form-label"> Siswa Pendaftaran </label>
									<select name="pendaftaran_id" class="form-control select2" style="width: 100%">
										<option value> Pilih Siswa </option>
										@foreach ($pendaftaran as $row)
											<option value="{{ $row->id }}"> {{ $row->identitas->nama_lengkap }} ({{ $row->identitas->asal_sekolah }}) </option>
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
									<td>{{ $row->nama_sponsorship }}</td>
									<td>{{ $row->kelas_sponsorship }}</td>
									<td>{{ $row->no_wa_sponsorship }}</td>
									<td>{{ $row->pendaftaran->identitas->nama_lengkap }}</td>
									<td>{{ $row->pendaftaran->identitas->asal_sekolah }}</td>
									<td>{{ StringHelper::toTitle($row->pendaftaran->identitas->nama_jurusan) }}</td>
									<td class="text-success" title="{{ $row->pendaftaran->level->desc }}">
										{{ StringHelper::toTitle($row->pendaftaran->level->name) }} 
										<?php $verified = $row->pendaftaran->verifikasi_pendaftaran ?>
										<span class="text-{{ $verified ? 'success' : 'warning' }}">
											({{ $verified ? 'Ter-Verifikasi' : 'Menunggu Verifikasi' }})
										</span>
									</td>
									<td>
										<button type="button"
											title="Edit Data Pendaftaran"
											class="btn btn-sm btn-secondary"
											onclick="window.location = '/admin/edit/{{ $row->id }}'"
										>
											<i class="fas fa-pen"></i>
										</button>
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