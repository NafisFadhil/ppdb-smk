@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="xtable" class="table table-sm table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th style="overflow-wrap:initial">No</th>
							<th style="overflow-wrap:initial">Kode Pendaftaran</th>
							<th style="overflow-wrap:initial">Jalur Pendaftaran</th>
							<th style="overflow-wrap:initial">Nama Lengkap</th>
							<th style="overflow-wrap:initial">Jenis Kelamin</th>
							<th style="overflow-wrap:initial">Asal Sekolah</th>
							<th style="overflow-wrap:initial">Jurusan</th>
							<th style="overflow-wrap:initial">Biaya Pendaftaran</th>
							<th style="overflow-wrap:initial">Status</th>
							<th style="overflow-wrap:initial">Keterangan</th>
							<th style="overflow-wrap:initial">Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($peserta as $row)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->kode }}</td>
								<td>{{ $row->identitas->jalur_pendaftaran }}</td>
								<td>{{ $row->identitas->nama_lengkap }}</td>
								<td>{{ $row->identitas->jenis_kelamin }}</td>
								<td>{{ $row->identitas->asal_sekolah }}</td>
								<td>{{ StringHelper::toTitle($row->identitas->nama_jurusan) }}</td>
								<td>{{ $row->pembayaran->biaya_pendaftaran }}</td>
								<td class="{{ $row->verifikasi_pendaftaran ? 'text-success' : 'text-warning' }}">
									{{ $row->verifikasi_pendaftaran ? 'Ter-Verifikasi' : 'Menunggu Verifikasi' }}
								</td>
								<td>{{ $row->pembayaran->ket_pendaftaran }}</td>
								<td>
									<?php 
										$xpembayaran = isset($row->pembayaran->biaya_pendaftaran) && $row->pembayaran->biaya_pendaftaran !== 0;
										$xverifikasi = $row->level->verifikasi_pendaftaran;
									?>
									<div class="btn-group btn-group-sm">
										<button type="button"
											title="Masukkan Pembayaran"
											data-toggle="modal"
											data-target="#modalPembayaran{{ $row->id }}"
											class="btn btn-secondary"
											{{ $xverifikasi ? 'disabled' : '' }}
										>
											<i class="fas fa-dollar-sign"></i>
										</button>
										@if(!$xverifikasi)
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalPembayaran'.$row->id,
													'title' => 'Input Biaya Pendaftaran'
												])

												<form action="/admin/verifikasi/pendaftaran/pembayaran/{{ $row->id }}" method="post">
													@csrf <?php $inputs = [
														['name' => 'jalur_pendaftaran', 'value' => $row->identitas->jalur_pendaftaran ?? '', 'attr' => 'readonly'],
														['name' => 'biaya_pendaftaran', 'value' => $row->pembayaran->biaya_pendaftaran ?? ''],
														['name' => 'ket_pendaftaran', 'label' => 'Keterangan', 'placeholder' => '(Opsional)', 'value' => $row->pembayaran->ket_pendaftaran ?? ''],
														['name' => 'nama_admin', 'value' => auth()->user()->nama_lengkap ?? auth()->user()->username, 'attr' => 'readonly'],
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

													<div class="form-group text-center">
														<button class="btn btn-primary">
															Submit
														</button>
													</div>
													
												</form>
												
												@endcomponent
											@endpush
										@endif

										<button type="button"
											title="Verifikasi Siswa"
											data-toggle="modal"
											data-target="#modalVerifikasi{{ $row->id }}"
											class="btn btn-secondary"
											{{ $xverifikasi || !$xpembayaran ? 'disabled' : '' }}
										>
											<i class="fas fa-check"></i>
										</button>
										@if(!$xverifikasi)
											@push('modals')
												@component('admin.components.modal', [
													'id' => 'modalVerifikasi'.$row->id,
													'title' => 'Verifikasi Siswa'
												])

												<form action="/admin/verifikasi/pendaftaran/verifikasi/{{ $row->id }}" method="post">
													@csrf <?php $inputs = [
														['name' => 'kode', 'value' => $row->kode ?? '', 'attr' => 'readonly'],
														['name' => 'nama_lengkap', 'value' => $row->identitas->nama_lengkap ?? '', 'attr' => 'readonly'],
														['name' => 'nama_jurusan', 'label' => 'Jurusan', 'value' => $row->identitas->nama_jurusan ?? '', 'attr' => 'readonly'],
														['name' => 'jalur_pendaftaran', 'value' => $row->identitas->jalur_pendaftaran ?? '', 'attr' => 'readonly'],
														['name' => 'biaya_pendaftaran', 'value' => $row->pembayaran->biaya_pendaftaran ?? '', 'attr' => 'readonly'],
														['name' => 'nama_admin', 'value' => auth()->user()->nama_lengkap ?? auth()->user()->username, 'attr' => 'readonly'],
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

													<div class="form-group text-center">
														<button class="btn btn-success">
															<i class="fas fa-check"></i> Verifikasi
														</button>
													</div>
													
												</form>
												
												@endcomponent
											@endpush
										@endif
										
										<button type="button"
											title="Edit Data Pendaftaran"
											class="btn btn-secondary"
											onclick="window.location = '/admin/edit/{{ $row->id }}'"
										>
											<i class="fas fa-pen"></i>
										</button>

										<button type="button"
											title="Cetak Lembar Pendaftaran"
											class="btn btn-secondary"
											{{ $xverifikasi ? '' : 'disabled' }}
											onclick="window.location = '/admin/print/{{ $row->id }}'"
										>
											<i class="fas fa-print"></i>
										</button>
										
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! $peserta->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection