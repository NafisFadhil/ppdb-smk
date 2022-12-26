<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cetak Pendaftaran</title>
	<link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/pdf/css/pdf-formulir.css">
</head>

<body>
	<div class="container-fluid small">
		<div class="row text-uppercase" id="print-element">
			<div class="col-12 d-flex justify-content-center">
				<img src="/pdf/img/kop.png" alt="kop surat" width="90%">
			</div>
			<div class="col-12 d-flex justify-content-center">
				<table class="table-bordered w-90">
					<tr>
						<td rowspan="2" style="vertical-align:center">lampiran a</td>
						<th>FORMULIR PENDAFTARAN MASUK KELAS X</th>
						<td rowspan="2">F/7.2/WKS2/001</td>
					</tr>
					<tr>
						<th>TAHUN PELAJARAN 2023/2024</th>
					</tr>
				</table>
			</div>
			<div class="col-12 d-flex justify-content-center mt-3">
				<div class="row w-90">
					<div class="col-12 col-md-4">
						<h4 class="w-90 font-weight-bold mt-2">
							{{ $data->jurusan->nama ?? null }}
						</h4>
					</div>
					<div class="col-6 col-md-2">
						<div class="photo">Photo <br /> Hitam Putih <br /> 3x4 cm</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="photo">Photo <br /> Hitam Putih <br /> 3x4 cm</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="photo">Photo <br /> Hitam Putih <br /> 3x4 cm</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="photo">Photo <br /> Hitam Putih <br /> 3x4 cm</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="d-flex justify-content-center">
					<div class="row w-90">
						<div class="col-12 small">
							<ol>
								<li>
									<div class="row">
										<div class="col-4 font-weight-bold">
											Jalur Pendaftaran
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 mt-2 w-val">
												<input type="text" class="w-100" value="{{ModelHelper::getJalur($data->jalur_pendaftaran)}}">
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NOMOR URUT PENDAFTARAN
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 w-val">
												<input type="text" class="w-100" value="{{ $data->jurusan->kode ?? $data->pendaftaran->kode ?? '-' }}">
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											nama lengkap
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 w-val">
												<input type="text" class="w-100" value="{{ $data->nama_lengkap }}">
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											tanggal lahir
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 w-val">
												<input type="text" class="w-100" value="{{ $data->new_tanggal_lahir }}">
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											tempat lahir
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 w-val">
												<input type="text" class="w-100" value="{{ $data->tempat_lahir }}">
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											jenis kelamin
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row flex-wrap">
												<div class="d-flex flex-row">
													<div class="mr-2">L</div>
													<input type="checkbox" class="form-control" {{ModelHelper::getJenisKelamin($data->jenis_kelamin_id) == 'LAKI-LAKI' ? 'checked'
													: '' }}>
												</div>
												<div class="d-flex flex-row ml-4">
													<div class="mr-2">P</div>
													<input type="checkbox" class="form-control" {{ModelHelper::getJenisKelamin($data->jenis_kelamin_id) == 'PEREMPUAN' ? 'checked'
													: '' }}>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											alamat tinggal
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-column w-val">
												<div class="d-flex flex-row">
													<div class="w-label">Desa/kel</div>
													<div class="w-input">
														<input type="text" class="w-100" value="{{ $data->alamat_desa }}">
													</div>
												</div>
												<div class="d-flex flex-row mt-1">
													<div class="d-flex justify-content-between flex-wrap w-val">
														<div class="d-flex flex-row w-3">
															<div class="w-label">RT</div>
															<div class="w-input">
																<input type="text" value="{{ $data->alamat_rt }}">
															</div>
														</div>
														<div class="d-flex flex-row w-3">
															<div class="w-label">RW</div>
															<div class="w-input">
																<input type="text" value="{{ $data->alamat_rw }}">
															</div>
														</div>
														<div class="d-flex flex-row w-3">
															<div class="w-label w-l">Gg</div>
															<div class="w-input">
																<input type="text" value="{{ $data->alamat_gg }}">
															</div>
														</div>
													</div>
												</div>
												<div class="d-flex flex-row mt-1">
													<div class="w-label">Kec.</div>
													<div class="w-input">
														<input type="text" class="w-100" value="{{ $data->alamat_kec }}">
													</div>
												</div>
												<div class="d-flex flex-row mt-1">
													<div class="w-label">kab/kota</div>
													<div class="w-input">
														<input type="text" class="w-100" value="{{ $data->alamat_kota_kab }}">
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											Nama Ayah
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row justify-content-between flex-wrap w-val">
												<div class="w-input-between">
													<input type="text" class="w-100" value="{{ $data->nama_ayah }}">
												</div>
												<div class="w-input-label">
													<div>tahun lahir</div>
													<input type="text" value="{{ $data->tahun_lahir_ayah }}">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											Nama Ibu
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row justify-content-between flex-wrap w-val">
												<div class="w-input-between">
													<input type="text" class="w-100" value="{{ $data->nama_ibu }}">
												</div>
												<div class="w-input-label">
													<div>tahun lahir</div>
													<input type="text" value="{{ $data->tahun_lahir_ibu }}">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											jumlah saudara kandung
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<div class="w-input-between">
													<input type="text" class="w-100" value="{{ $data->jumlah_saudara_kandung }}">
												</div>
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NO INDUK KEPENDUDUKAN (NIK)
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<input type="text" class="w-100" value="{{ $data->nik }}">
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											ASAL SMP/MTs
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<input type="text" class="w-100" value="{{ $data->asal_sekolah }}">
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NISN
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<input type="text" class="w-100" value="{{ $data->nisn }}">
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NO UJIAN NASIONAL SMP/MTs
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<input type="text" class="w-100" value="{{ $data->no_ujian_nasional }}">
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NO IJAZAH/TANGGAL/TAHUN LULUS
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row justify-content-between flex-wrap w-val">
												<div class="w-input-between">
													<input type="text" class="w-100" value="{{ $data->no_ijazah }}">
												</div>
												<div class="w-input-label w-input-label-diff justify-content-end">
													<input type="text" class="ml-4 w-between">
												</div>
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											NO WA
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row w-val">
												<input type="text" class="w-100" value="{{ $data->no_wa_siswa }}">
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											BUTA WARNA
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-row flex-wrap">
												<div class="d-flex flex-row">
													<input type="checkbox" class="form-control">
													<div class="ml-2">Ya</div>
												</div>
												<div class="d-flex flex-row ml-4">
													<input type="checkbox" class="form-control">
													<div class="ml-2">tidak</div>
												</div>
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="row mt-1">
										<div class="col-4 font-weight-bold">
											PILIHAN KOMPETENSI KEAHLIAN
										</div>
										<div class="col-8 d-flex flex-row">
											<div>
												<span class="font-weight-bold">: </span>
											</div>
											<div class="ml-2 d-flex flex-column flex-wrap">
												<div class="font-weight-bold text-capitalize">Pilihan kedua :</div>
												<ul>
													<li>
														<div class="d-flex flex-row">
															<input type="checkbox" class="form-control">
															<div class="ml-2">TEKNIK DAN BISNIS SEPEDA MOTOR</div>
														</div>
													</li>
													<li>
														<div class="d-flex flex-row">
															<input type="checkbox" class="form-control">
															<div class="ml-2">TEKNIK KENDARAAN RINGAN OTOMOTIF</div>
														</div>
													</li>
													<li>
														<div class="d-flex flex-row">
															<input type="checkbox" class="form-control">
															<div class="ml-2">FARMASI KLINIS DAN KOMUNITAS</div>
														</div>
													</li>
													<li>
														<div class="d-flex flex-row">
															<input type="checkbox" class="form-control">
															<div class="ml-2">AKUNTANSI DAN KEUANGAN LEMBAGA</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ol>
						</div>

						<div class="col-12 small font-weight-bold mt-2 text-lowercase">
							<span class="text-capitalize">Dengan</span> ini saya menyatakan bahwa data yang diisi dalam formulir
							pendaftaran ini adalah benar
						</div>
						<div class="col-12 small font-weight-bold mt-2 text-capitalize d-flex justify-content-end">
							Bligo, {{ $data->date_now }}
						</div>
						<div class="col-12 small font-weight-bold mt-2 text-capitalize d-flex justify-content-between">
							<div class="ttd">
								Orang Tua/Wali
							</div>
							<div class="ttd">
								Calon Peserta Didik,
							</div>
						</div>

						<div class="col-12 small font-weight-bold mt-2 text-lowercase mt-2 mb-2">
							<span class="text-capitalize">* Diisi</span> dengan menggunakan huruf kapital/besar
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/plugins/jquery/jquery.min.js"></script>
<script>
	$(":input").prop("disabled", true);
    window.onload = () => window.print()
</script>

</html>