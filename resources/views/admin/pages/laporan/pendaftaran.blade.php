@extends('layouts.admin')

{{-- @dd(get_defined_vars()) --}}

<?php
$yearOpts = [];
foreach ($thn as $th) {
    $yearOpts[] = $th->year;
}

$filterInputs = [
    ['variant' => 'nolabel', 'type' => 'select', 'name' => 'type', 'value' => request('type'),
    'options' => [
        ['label' => '-- Pilih Laporan --', 'value' => ''],
        ['label' => 'Pendaftaran', 'value' => 'pendaftaran'],
        ['label' => 'Pembayaran', 'value' => 'pembayaran'],
    ]],
    ['variant' => 'nolabel', 'type' => 'select', 'name' => 'thn', 'value' => request('thn'),
    'options' => [
        ['label' => '-- Pilih Tahun --', 'value' => ''],
        ...$yearOpts,
        ['label' => 'Semua Tahun', 'value' => 'all']
    ]],
]
?>

@section('content')
<div class="row gap-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				@foreach ($errors->all() as $error)
				<div class="alert alert-danger">{{ $error }}</div>
				@endforeach

				<h3 class="card-title mb-2 font-weight-bold">Cetak PDF</h3>

				<form action="" class="row w-100">
					@foreach ($filterInputs as $input)
					<div class="col-12 col-sm-6 col-md-5">
						@include('admin.components.input', ['input' => $input])
					</div>
					@endforeach
					<div class="form-group col-12 col-md-2">
						<button class="btn btn-block btn-primary btn-sm mx-auto" type="submit">
							<i class="fa fa-solid fa-filter"></i> Filter
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if(isset($laporan) && !is_null($laporan))
		@php($jml = 0)
		<div class="col-12">
			<div class="card" id="print-element">

				@if($type === 'pembayaran')
				<div class="card-header">
					<div class="d-flex justify-content-end mt-5 mb-3">
						<div>
							<button class="btn btn-primary" id="cetak-pdf-button">
								<i class="fa fa-solid fa-print"></i> Cetak PDF
							</button>
						</div>
					</div>
				</div>
				@endif
				
				<div class="card-body">
					<table id="{{ $type == 'pendaftaran' ? 'xtable' : '' }}"
						class="table table-striped table-bordered table-responsive">
						<thead>
							<tr>
								<th scope="col">Kode</th>
								<th scope="col">Nama Lengkap</th>
								<th scope="col">Jurusan</th>
								<th scope="col">No WhatsApp</th>
								@if($type == 'pembayaran')
								<th scope="col">Jumlah Pembayaran</th>
								<th scope="col">Tanggal Pembayaran</th>
								<th scope="col">Admin Penerima</th>
								@else
								<th scope="col">Jenis Kelamin</th>
								<th scope="col">Asal Sekolah</th>
								<th scope="col">Jalur Pendaftaran</th>
								<th scope="col">Cetak Pendaftaran</th>
								<th scope="col">Cetak Formulir</th>
								@endif
							</tr>
						</thead>

						<tbody>
							
							@if($type == 'pembayaran')
							@foreach($laporan as $lp)
							<tr>
								<td>{{ $lp->kode }}</td>
								<td>{{ $lp->nama_lengkap }}</td>
								<td>{{ Str::upper($lp->nama_jurusan) }}</td>
								<td>{{ $lp->no_wa_siswa }}</td>
								<td>{{ "Rp " . number_format($lp->biaya_pendaftaran, 2, ",", ".") }}</td>
								<td>{{ $lp->updated_at }}</td>
								<td>{{ $lp->admin_biaya_pendaftaran }}</td>
							</tr>
							@php($jml += $lp->biaya_pendaftaran)
							@endforeach
							
							@else
							@foreach($laporan as $lp)
							<tr>
								<td>{{ $lp->jurusan->kode ?? '-' }}</td>
								<td>{{ $lp->nama_lengkap }}</td>
								<td>{{ Str::upper($lp->nama_jurusan) }}</td>
								<td>{{ $lp->no_wa_siswa }}</td>
								<td>{{ $lp->jenis_kelamin }}</td>
								<td>{{ $lp->asal_sekolah }}</td>
								<td>{{ ModelHelper::getJalur($lp->jalur_pendaftaran) }}</td>
								<td>
									<a href="{{ URL::to('admin/cetak/pendaftaran/'.$lp->id) }}" target="_blank" class="btn btn-secondary">
										<i class="fa fa-print"></i>
									</a>
								</td>
								<td>
									<a href="{{ URL::to('admin/cetak/formulir/'.$lp->id) }}" target="_blank" class="btn btn-secondary">
										<i class="fa fa-print"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>

						@if($type === 'pembayaran')
						<tfoot>
							<tr>
								<td colspan="4">Total Pembayaran</td>
								<td colspan="3">{{ "Rp " . number_format($jml, 2, ",", ".") }}</td>
							</tr>
						</tfoot>
						@endif

					</table>
				</div>
			</div>
		</div>
	@endif
</div>
<script>
	let cetak = document.querySelector('#cetak-pdf-button')
    if(cetak){
        cetak.addEventListener('click', (e) => {
            e.preventDefault()
            window.print()
        })
    }

    window.onclick = (e) => {
        if(e.target.classList.contains('print-pendaftar')){
            let idprint = e.target.dataset.idprint
            document.querySelector('#print-element').id = 'no-print'
            document.querySelector('#print-pend-'+idprint).id = 'print-element'
            window.print()
        }
    }
    
</script>
@endsection