@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	@include('admin.components.bigsearch', ['input' => [
		'type' => 'search', 'name' => 'search', 'placeholder' => 'Cari siswa...'
	]])
	
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="overflow-x: auto">
					<table id="xtable" class="w-100 table table-sm table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama</th>
								<th>Jalur Pendaftaran</th>
								<th>Asal Sekolah</th>
								<th>Status</th>
								<th>Tindakan</th>
							</tr>
						</thead>
						<tbody>
							@foreach($peserta as $row)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $row->jurusan->kode ?? '-' }}</td>
									<td>{{ $row->nama_lengkap }}</td>
									<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
									<td>{{ $row->asal_sekolah }}</td>
									@if($row->verifikasi)
										<td class="text-success">Ter-Verifikasi</td>
									@else
										<td class="text-warning">Belum Verifikasi</td>
									@endif
									<td>
										<div class="btn-group btn-group-sm">
											<a href="/admin/verifikasi/pendataan/edit/{{ $row->id }}" class="btn btn-sm btn-warning text-white {{ $row->verifikasi ? 'disabled' : '' }}">
												<i class="fa fa-pen"></i>
											</a>
											<button type="button" title="Verifikasi Data Identitas" class="btn btn-success" data-toggle="modal"
											data-target="#modalVerifikasi{{ $row->id }}" {{ $row->verifikasi ? 'disabled' : '' }}>
												<i class="fa fa-check"></i>
												@if(!$row->verifikasi)
													<?php
													$user = auth()->user();
													$inputs = [
														['name' => 'kode', 'value' => $row->kode??null, 'attr' => 'disabled'],
														['name' => 'nama_lengkap', 'value' => $row->nama_lengkap??null, 'attr' => 'disabled'],
														['name' => 'jalur_pendaftaran', 'value' => ModelHelper::getJalur($row->jalur_pendaftaran??null), 'attr' => 'disabled'],
														['name' => 'asal_sekolah', 'value' => $row->asal_sekolah??null, 'attr' => 'disabled'],
														['name' => 'admin_verifikasi', 'label' => 'Admin', 'value' => $user->name ?? $user->username, 'attr' => 'readonly'],
													] ?>

													@push('modals')
														@component('admin.components.modal', [
															'id' => 'modalVerifikasi'.$row->id,
															'title' => 'Verifikasi Identitas Siswa'
														])

															<form action="/admin/verifikasi/pendataan/{{ $row->id }}" method="post">
																@csrf

																@foreach ($inputs as $input)
																	@include('admin.components.input', [ 'input' => $input ])
																@endforeach

																<div class="form-group text-center">
																	<button type="submit" class="btn btn-success">
																		<i class="fa fa-check"></i> Verifikasi Identitas
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
				</div>
			</div>
		</div>
	</div>
@endsection