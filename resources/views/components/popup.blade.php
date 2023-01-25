@if((session('session_duplicated') || session('session_id')) && isset($siswa) && !empty($siswa) && count($siswa) > 0)
	<?php 
		$siswa = $siswa[0];
		$kode = $siswa->pendaftaran->kode;
		$tagihan = $siswa->tagihan->biaya_pendaftaran;
		$duplicated = session('session_duplicated');
	?>

	<div id="modal" class="fixed top-0 right-0 left-0 bottom-0 grid place-items-center z-50 bg-black bg-opacity-25">
		<div class="bg-white rounded-md border shadow max-w-[95vw]">
			<div class="p-7">
				<div id="popup">
					@if($duplicated)
						<p class="text-lg font-bold block text-center" style="color: red">
							Maaf, anda sudah terdaftar dengan kode pendaftaran:
						</p>
					@else
						<p class="text-2xl font-bold block text-center">Kode Pendaftaran :</p>
					@endif

					<h1 class="text-4xl sm:text-5xl md:text-6xl text-primary font-bold block text-center pt-4 pb-2">
						{{ $kode }}
					</h1>
					
					<p class="text-lg font-semibold block text-center">{{ $siswa->nama_lengkap }}</p>

					<ol class="pl-3 list-decimal mt-4" style="line-height: 1.5rem">
						<li class="mb-1">Screenshoot tampilan ini.</li>
						<li class="mb-1">Silahkan datang ke SMK Muhammadiyah Bligo dengan membawa:
							<ol class="list-inside pl-5" style="list-style: lower-alpha">
								<li> Fotocopy Akta Kelahiran 4 lembar. </li>
								<li> Fotocopy Kartu Keluarga 4 lembar. </li>
								<li> PAS Foto Hitam Putih 4 lembar. </li>
								<li> Fotocopy Ijazah SMP/MTS/Sederajat (jika sudah ada) 4 lembar. </li>
								<li> Fotocopy Raport SMP/MTS/Sederajat semester 1-5 (disertai halaman identitas siswa) 1 lembar. </li>
								<li> Fotocopy KIP/KKC (bagi yang punya). </li>
								<li> Surat keterangan NISN dari SMP/MTS 1 lembar. </li>
							</ol>
						</li>
						<li>Persyaratan tambahan untuk Prestasi dan Afirmasi Bisa menghubungi WA:
							<ol class="list-inside pl-5" style="list-style: decimal">
								<li>
									<a href="http://wa.me/+62085780190170" class="text-primary">
										085780190170
									</a>
								</li>
								<li>
									<a href="http://wa.me/+62081391870500" class="text-primary">
										081391870500
									</a>
								</li>
							</ol>
						</li>
					</ol>
				</div>
				<div class="w-full flex justify-center items-center gap-2 flex-wrap flex-row mt-4 md:mt-5">
					<button type="button" class="px-4 py-2 rounded bg-primary text-white"
					onclick="document.getElementById('modal').style.display = 'none'">
						TUTUP
					</button>
					<button type="button" class="px-4 py-2 rounded bg-green-800 text-white"
					onclick="javascript:printPopup()">
						SIMPAN
					</button>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		{{-- <script src="/plugins/es6-promise/es6-promise.auto.min.js"></script>
		<script src="/plugins/jspdf/jspdf.umd.min.js"></script>
		<script src="/plugins/html2canvas/html2canvas.min.js"></script> --}}
		<script src="/plugins/html2pdf/html2pdf.bundle.min.js"></script>
		<script>
			function printPopup() {
				let element = document.getElementById('popup');

				return html2pdf().set({
					margin: 10,
					filename: 'kode-pendaftaran.pdf',
					image: {
						type: 'jpeg',
						quality: 1
					},
					// html2canvas: {
					// 	scale: 5,
					// },
					jsPDF: {
						orientation: 'landscape',
						format: 'a5'
					}
				}).from(element).save();
			}
		</script>
	@endpush

@endif