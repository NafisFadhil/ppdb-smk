<table id="xtable" class="table table-sm table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Jalur</th>
			<th>Jenis Kelamin</th>
			<th>Asal Sekolah</th>
			<th>Jurusan</th>
			<th>Tanggal Lahir</th>
			<th>No WA Siswa</th>
			<th>No WA Ortu</th>
			<th>Status</th>
			<th>Tindakan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($peserta as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>
					{{ $row->pendaftaran->kode ?? '-' }}
					@isset($row->jurusan->kode)
						<br> {{ $row->jurusan->kode }}
					@endisset
				</td>
				<td>{{ $row->nama_lengkap }}</td>
				<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
				<td>{{ ModelHelper::getJenisKelamin($row->jenis_kelamin_id) }}</td>
				<td>{{ $row->asal_sekolah }}</td>
				<td>{{ $row->jurusan->singkatan }}</td>
				<td>{{ ModelHelper::formatTanggal($row->tanggal_lahir) }}</td>
				<td>{{ $row->no_wa_siswa }}</td>
				<td>{{ $row->no_wa_ortu }}</td>
				<td class="text-success" title="{{ $row->status->desc }}">
					{{ $row->status->level }} ({{ $row->status->sublevel }})
				</td>
				<td>
					<div class="btn-group btn-group-sm">

						{{-- <button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}"
							class="btn btn-secondary" disabled>
							<i class="fa fa-eye"></i> 
						</button> --}}

						{{-- Edit --}}
						<a href="/admin/edit/{{ $row->id }}" title="Edit Data Pendaftaran"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-pen"></i>
						</a>

						{{-- Tagihan --}}
						<a href="/admin/tagihan/{{ $row->id }}" title="Detail Tagihan"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa">T</i>
						</a>

						{{-- Input Siswa Sponsorship --}}
						{{-- <button type="button" title="Input Siswa Sponsorship" data-toggle="modal"
						data-target="#modalSponsorship{{ $row->id }}" class="btn btn-secondary" {{ $row->sponsorship ? 'disabled' : '' }} >
							<i class="fa">S+</i>
							@if(!$row->sponsorship)
								@include('admin.modals.sponsorship.sponsorship', [ 'row' => $row ])
							@endif
						</button> --}}

						@if(auth()->user()->level->name === 'super-admin')
							{{-- Hapus --}}
							<a href="/admin/hapus/{{ $row->id }}" title="Hapus Data Pendaftaran"
							class="btn btn-danger d-flex flex-nowrap align-items-center"
							onclick="return confirm('Konfirmasi penghapusan data...')">
								<i class="fa fa-trash"></i>
							</a>
						@endif

					</div>

					<div class="btn-group btn-group-sm">
						{{-- Detail Pembayaran Pendaftaran --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=pendaftaran" title="Detail Pembayaran Pendaftaran"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">P</i>
						</a>

						{{-- Detail Pembayaran Daftar Ulang --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=daftar_ulang" title="Detail Pembayaran Daftar Ulang"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">DU</i>
						</a>

						{{-- Detail Pembayaran Seragam --}}
						<a href="/admin/pembayaran/{{ $row->id }}?type=seragam" title="Detail Pembayaran Seragam"
						class="btn btn-secondary d-flex flex-nowrap align-items-center">
							<i class="fa fa-dollar-sign">S</i>
						</a>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>