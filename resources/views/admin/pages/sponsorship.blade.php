@extends('layouts.admin')

@section('content')
<div class="row gap-2">
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
									<td class="text-success" title="{{ $row->identitas->status->desc }}">
										{{ $row->identitas->status->level }} ({{ $row->identitas->status->sublevel }})
									</td>
									<td>
										<div class="btn-group btn-group-sm">

											{{-- Edit Siswa Sponsorship --}}
											<button type="button" title="Edit Siswa Sponsorship" data-toggle="modal"
											data-target="#modalSponsorship{{ $row->id }}" class="btn btn-warning text-white">
												<i class="fa fa-pen"></i>
												@include('admin.modals.general.sponsorship', [
													'row' => $row->identitas,
													'edit' => true
												])
											</button>

											<button type="button" title="Verifikasi Data Sponsorship" class="btn btn-success" data-toggle="modal"
											data-target="#modalVerifikasi{{ $row->id }}" {{ $row->verifikasi ? 'disabled' : '' }}>
												<i class="fa fa-check"></i>
												@if(!$row->verifikasi)
													<?php
													$user = auth()->user();
													$inputs = [
														['name' => 'nama', 'value' => $row->nama??null, 'attr' => 'disabled'],
														['name' => 'kelas', 'value' => $row->kelas??null, 'attr' => 'disabled'],
														['type' => 'number', 'name' => 'no_wa', 'value' => $row->no_wa??null, 'attr' => 'disabled'],
														['type' => 'hidden', 'name' => 'identitas_id', 'value' => $row->identitas->id??null],
														['name' => 'admin_verifikasi', 'label' => 'Admin', 'value' => $user->name ?? $user->username, 'attr' => 'readonly'],
													] ?>

													@push('modals')
														@component('admin.components.modal', [
															'id' => 'modalVerifikasi'.$row->id,
															'title' => 'Verifikasi Siswa Sponsorship'
														])

															<form action="/admin/verifikasi/sponsorship/{{ $row->id }}" method="post">
																@csrf

																@foreach ($inputs as $input)
																	@include('admin.components.input', [ 'input' => $input ])
																@endforeach

																<div class="form-group text-center">
																	<button type="submit" class="btn btn-success">
																		<i class="fa fa-check"></i> Verifikasi Sponsorship
																	</button>
																</div>
																
															</form>
														
														@endcomponent
													@endpush
												@endif
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