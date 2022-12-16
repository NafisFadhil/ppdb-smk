@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	@include('admin.components.bigsearch', ['input' => [
		'type' => 'search', 'name' => 'search', 'placeholder' => 'Cari siswa...'
	]])
	
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="xtable" class="table table-sm table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Pendaftaran</th>
							<th>Kode Jurusan</th>
							<th>Nama Lengkap</th>
							<th>Jalur Pendaftaran</th>
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
								<td>{{ $row->pendaftaran->kode }}</td>
								<td>{{ isset($row->jurusan->kode) ? $row->jurusan->kode : '-' }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ ModelHelper::getJalur($row->jalur_pendaftaran) }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ strtoupper($row->nama_jurusan) }}</td>
								<td class="text-success" title="{{ $row->status->desc }}">
									{{ $row->status->level }} ({{ $row->status->sublevel }})
								</td>
								<td>
									<div class="btn-group btn-group-sm">

										<button type="button" title="Detail Siswa" data-toggle="modal" data-target="#modalDetail{{ $row->id }}" class="btn btn-secondary" >
											<i class="fa fa-eye"></i> 
											@include('admin.modals.general.detail', [
												'row' => $row,
												'inputs' => [
														['Kode Pendaftaran', $row->pendaftaran->kode ?? ''],
														['Kode Jurusan', $row->jurusan->kode ?? ''],
														['Jalur Pendaftaran', ModelHelper::getJalur($row->jalur_pendaftaran)],
														['Nama Lengkap', $row->nama_lengkap],
														['Jenis Kelamin', $row->jenis_kelamin],
														['Asal Sekolah', $row->asal_sekolah],
														['Jurusan', StringHelper::toCapital($row->nama_jurusan)],
														['No Wa Siswa', $row->no_wa_siswa],
													]
											])
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
												@include('admin.modals.general.sponsorship', [ 'row' => $row ])
											@endif
										</button>

										{{-- Print --}}
										<button type="button" title="Print" data-toggle="modal" data-target="#modalPrint{{ $row->id }}" class="btn btn-secondary">
											<i class="fa fa-print"></i>
											@include('admin.modals.print.peserta', ['row' => $row])
										</button>

									</div>

									<div class="btn-group btn-group-sm">
										{{-- Tagihan --}}
										<button type="button" title="Detail Tagihan" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/tagihan/{{ $row->id }}'">
											<i class="fa">T</i>
										</button>
										
										{{-- Data Pembayaran Pendaftaran --}}
										<button type="button" title="Data Pembayaran Pendaftaran" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=pendaftaran'">
											<i class="fa fa-dollar-sign">P</i>
										</button>

										{{-- Data Pembayaran Daftar Ulang --}}
										<button type="button" title="Data Pembayaran Daftar Ulang" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=daftar_ulang'">
											<i class="fa fa-dollar-sign">DU</i>
										</button>

										{{-- Data Pembayaran Seragam --}}
										<button type="button" title="Data Pembayaran Seragam" class="btn btn-secondary d-flex flex-nowrap align-items-center" onclick="window.location = '/admin/pembayaran/{{ $row->id }}?type=seragam'">
											<i class="fa fa-dollar-sign">S</i>
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