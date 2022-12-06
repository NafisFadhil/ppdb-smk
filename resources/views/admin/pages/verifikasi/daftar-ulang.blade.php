@extends('layouts.admin')

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
					@foreach ($errors->all() as $error)
						<div class="alert alert-info d-flex flex-row justify-content-between">
							<div>{{ $error }}</div>
						</div>
					@endforeach
					</div>
					<div class="col-12">
						<button class="btn btn-primary" data-toggle="modal" data-target="#setPembayaranDU">Set Pembayaran</button>
						@component('admin.components.modal',['id' => "setPembayaranDU", 'title' =>"Input Pembayaran DU"])
							<form action="/admin/verifikasi-daftar-ulang/payment-edit" method="post">
								@csrf
								@foreach($payment as $pay)
								<div class="form-group">
									<label for="{{ $pay->jalur_pendaftaran }}">{{ $pay->jalur_pendaftaran }}</label>
									<input type="number" name="{{ $pay->jalur_pendaftaran }}" 
									id="{{ $pay->jalur_pendaftaran }}" 
									name="{{ strtolower($pay->jalur_pendaftaran) }}" 
									value="{{ $pay->payment }}"
									class="form-control"
									 />
								</div>
								@endforeach
								<button type="submit" class="btn btn-success">Edit</button>
							</form>
						@endcomponent
					</div>
				</div>
				<table id="xtable" class="w-100 table table-sm table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Nama</th>
							<th>Jalur</th>
							<th>Jenis Kelamin</th>
							<th>Asal Sekolah</th>
							<th>Jurusan</th>
							<th>Angsuran</th>
							<th>Pembayaran</th>
							<th>Status</th>
							<th>Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($peserta as $row)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->kode }}</td>
								<td>{{ $row->nama_lengkap }}</td>
								<td>{{ $row->jalur_pendaftaran }}</td>
								<td>{{ $row->jenis_kelamin }}</td>
								<td>{{ $row->asal_sekolah }}</td>
								<td>{{ StringHelper::toCapital($row->nama_jurusan) }}</td>
								<td>{{ $row->angsuran }}x</td>
								<td>Rp {{ number_format($row->pembayaran,2,',','.') }}</td>
								<td class="text-success">
									{{ $row->status }}
								</td>
								<td>
									<button type="button" title="Input Pembayaran Daftar Ulang" data-toggle="modal" data-target="#input-du{{ $row->id }}" class="btn btn-secondary" {{ $row->status == 'lunas' ? 'disabled' : '' }} >
											<i class="fa fa-dollar-sign"></i> 
									</button>
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