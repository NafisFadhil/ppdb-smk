@extends('layouts.admin')

<?php
// 'pendaftaran', 'daftar_ulang', 'seragam'
$reqtype = request()->query->get('type') ?? null;
$types = ['identitas'];

if (is_null($reqtype)) {
	array_push($types, 'pendaftaran', 'daftar_ulang', 'seragam');
} else $types[] = $reqtype;

$data = $data ?? $row ?? $siswa ?? $peserta ?? $identitas ?? collect([]);
?>

@section('content')
	<div class="row">
		@foreach($types as $type)
			<?php $xtype = StringHelper::toTitle($type) ?>
		
			<div class="col-12">
				<div class="card">
					<div class="card-header p-2 px-3">
						<h5 class="m-0"> {{ $xtype }} </h5>
					</div>
					<div class="card-body text-sm overflow-x-auto">

						@if($type === 'identitas')
							<table class="table table-borderless table-sm w-auto">
								<tbody>
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
										<td>Jurusan</td>
										<td>:</td>
										<th> {{ $data->jurusan->nama ?? '-' }} </th>
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
								</tbody>
							</table>
						@else
							<table class="table table-bordered table-sm w-100">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal</th>
										<th>Bayar</th>
										<th>Tagihan</th>
										<th>Admin</th>
									</tr>
								</thead>
								<tbody>
									<?php $total_bayar = $total_tagihan = 0; $counter = 0 ?>

									@foreach($data->tagihan->pembayarans as $pembayaran)
										<?php
											if ($pembayaran->type !== $type) continue;
											$total_bayar += $pembayaran->bayar;
											$total_tagihan += $pembayaran->kurang;
											$counter++;
										?>

										<tr>
											<td> {{ $loop->iteration }} </td>
											<td> {{ ModelHelper::formatTanggal($pembayaran->created_at) }} </td>
											<td> {{ NumberHelper::toRupiah($pembayaran->bayar) }} </td>
											<td> {{ NumberHelper::toRupiah($pembayaran->kurang) }} </td>
											<td> {{ $pembayaran->admin->name ?? $pembayaran->admin->username }} </td>
										</tr>
									@endforeach

									@if($counter === 0)
										<tr>
											<td colspan="5" class="text-center">Tidak ada Detail Pembayaran.</td>
										</tr>
									@endif
									
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2">Total Bayar</th>
										<th> {{ NumberHelper::toRupiah($total_bayar) }} </th>
										<th>Total Tagihan</th>
										<th> {{ NumberHelper::toRupiah($data->tagihan['tagihan_'.$type]) }} </th>
									</tr>
								</tfoot>
							</table>
						@endif

					</div>
				</div>
			</div>
		@endforeach
	</div>

@endsection