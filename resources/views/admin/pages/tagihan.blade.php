@extends('layouts.admin')

<?php
$types = ['identitas', 'pendaftaran', 'daftar_ulang', 'seragam'];
$data = $data ?? $row ?? $siswa ?? $peserta ?? $identitas ?? collect([]);
?>

@section('content')
	<div class="row">
		@foreach($types as $type)
			<?php $xtype = StringHelper::toTitle($type) ?>
		
			<div class="col-12 col-md-6">
				<div class="card">
					<div class="card-header p-2 px-3">
						<h5 class="m-0"> {{ $xtype }} </h5>
					</div>
					<div class="card-body text-sm">

						<table class="table table-borderless table-sm w-auto">
							<tbody>
								@if($type === 'identitas')
									<tr>
										<td>Nama Lengkap</td>
										<td>:</td>
										<th> {{ $data->nama_lengkap }} </th>
									</tr>
									<tr>
										<td>Kode Pendaftaran</td>
										<td>:</td>
										<th> {{ $data->pendaftaran->kode ?? '-' }} </th>
									</tr>
									<tr>
										<td>Kode Jurusan</td>
										<td>:</td>
										<th> {{ $data->jurusan->kode ?? '-' }} </th>
									</tr>
									<tr>
										<td>Jalur Pendaftaran</td>
										<td>:</td>
										<th> {{ ModelHelper::getJalur($data->jalur_pendaftaran) }} </th>
									</tr>
									<tr>
										<td>Status Pendaftaran</td>
										<td>:</td>
										<th> {{ $data->status->desc }} </th>
									</tr>
								@else
									<tr>
										<td>Biaya {{ $xtype }}</td>
										<td>:</td>
										<th> {{ $data->tagihan['biaya_'.$type] }} </th>
									</tr>
									<tr>
										<td>Tagihan</td>
										<td>:</td>
										<th> {{ $data->tagihan['tagihan_'.$type] }} </th>
									</tr>
									<tr>
										<td>Admin Tagihan</td>
										<td>:</td>
										<th> {{ $data->tagihan['admin_'.$type]->name ?? '-' }} </th>
									</tr>
									<tr>
										<td>Status Pembayaran</td>
										<td>:</td>
										<th> {{ ModelHelper::getStatusBayar($data->tagihan, $type) }} </th>
									</tr>
								@endif

							</tbody>
						</table>
						
					</div>
					@if($type !== 'identitas')
						<div class="card-footer p-0">
							<a href="/admin/pembayaran/{{ $data->id }}?type={{ $type }}" class="btn btn-dark btn-sm btn-block"
							style="border-top-left-radius: 0; border-top-right-radius:0">
								Detail Pembayaran
								<i class="fa fa-arrow-right" style="margin-bottom: -.1rem"></i>
							</a>
						</div>
					@endif
				</div>
			</div>
		@endforeach

		<div class="col-12 p-2">
			<a href="/admin/pembayaran/{{ $data->id }}" class="btn btn-dark btn-sm btn-block mx-auto"
				style="max-width: max-content">
				Detail Semua Pembayaran
			</a>
		</div>
		
	</div>

@endsection