<table id="xtable" class="w-100 table table-sm table-bordered table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jalur Pendaftaran</th>
			<th>Asal Sekolah</th>
			<th>No WA Siswa</th>
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
				<td>{{ $row->no_wa_siswa }}</td>
				@if($row->verifikasi->identitas)
					<td class="text-success">Ter-Verifikasi</td>
				@else
					<td class="text-warning">Belum Verifikasi</td>
				@endif
				<td>
					<div class="btn-group btn-group-sm">
						<a href="/admin/verifikasi/pendataan/edit/{{ $row->id }}" class="btn btn-sm btn-warning text-white"
						{{ $row->verifikasi->identitas ? 'disabled' : '' }}>
							<i class="fa fa-pen"></i>
						</a>
						<button type="button" title="Verifikasi Data Identitas" class="btn btn-success" data-toggle="modal"
						data-target="#modalVerifikasi{{ $row->id }}"
						{{ $row->verifikasi->identitas ? 'disabled' : '' }}>
							<i class="fa fa-check"></i>
							@if(!$row->verifikasi->identitas)
								<?php
								$user = auth()->user();
								$inputs = [
									['name' => 'kode', 'value' => $row->jurusan->kode??null, 'attr' => 'disabled'],
									['name' => 'nama_lengkap', 'value' => $row->nama_lengkap??null, 'attr' => 'disabled'],
									['name' => 'jalur_pendaftaran', 'value' => ModelHelper::getJalur($row->jalur_pendaftaran??null), 'attr' => 'disabled'],
									['name' => 'asal_sekolah', 'value' => $row->asal_sekolah??null, 'attr' => 'disabled'],
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