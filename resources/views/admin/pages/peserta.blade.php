@extends('layouts.admin')

@section('content')
<div class="row">
	{{-- @include('admin.components.bigsearch', ['input' => [
		'type' => 'search', 'name' => 'search', 'placeholder' => 'Cari siswa...'
	]]) --}}
	@include('admin.components.filter', ['filters' => $filters])
	
	<div class="col-12">
		<div class="card">
			<div class="card-body p-2">
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
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->level }} ({{ $row->status->sublevel }})
								</td>
								<td>
									<div class="btn-group btn-group-sm">

										<button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" disabled>
											<i class="fa fa-eye"></i> 
											{{-- @include('admin.modals.general.detail', [
												'row' => $row,
												'inputs' => [
														['Kode Pendaftaran', $row->pendaftaran->kode ?? ''],
														['Kode Jurusan', $row->jurusan->kode ?? ''],
														['Jalur Pendaftaran', ModelHelper::getJalur($row->jalur_pendaftaran)],
														['Nama Lengkap', $row->nama_lengkap],
														['Jenis Kelamin', $row->jenis_kelamin],
														['Asal Sekolah', $row->asal_sekolah],
														['Jurusan', StringHelper::toCapital($row->jurusan->singkatan)],
														['No Wa Siswa', $row->no_wa_siswa],
													]
											]) --}}
										</button>

										{{-- Edit --}}
										<button type="button" title="Edit Data Pendaftaran" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/edit/{{ $row->id }}'">
											<i class="fa fa-pen"></i>
										</button>

										{{-- Input Siswa Sponsorship --}}
										<button type="button" title="Input Siswa Sponsorship" data-toggle="modal"
										data-target="#modalSponsorship{{ $row->id }}" class="btn btn-secondary" {{ $row->sponsorship ? 'disabled' : '' }} >
											<i class="fa">S+</i>
											@if(!$row->sponsorship)
												@include('admin.modals.sponsorship.sponsorship', [ 'row' => $row ])
											@endif
										</button>

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
										{{-- Tagihan --}}
										<button type="button" title="Detail Tagihan" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/tagihan/{{ $row->id }}'">
											<i class="fa">T</i>
										</button>
										
										{{-- Detail Pembayaran Pendaftaran --}}
										<button type="button" title="Detail Pembayaran Pendaftaran" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=pendaftaran'">
											<i class="fa fa-dollar-sign">P</i>
										</button>

										{{-- Detail Pembayaran Daftar Ulang --}}
										<button type="button" title="Detail Pembayaran Daftar Ulang" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=daftar_ulang'">
											<i class="fa fa-dollar-sign">DU</i>
										</button>

										{{-- Detail Pembayaran Seragam --}}
										<button type="button" title="Detail Pembayaran Seragam" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=seragam'">
											<i class="fa fa-dollar-sign">S</i>
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
	
	@include('admin.components.paginate')
</div>
@endsection