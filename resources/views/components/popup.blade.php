@if(session('session_id') && isset($siswa) && !empty($siswa) && count($siswa))
	<?php 
		$siswa = $siswa[0];
		$kode = $siswa->pendaftaran->kode;
		$tagihan = $siswa->tagihan->biaya_pendaftaran;
	?>

	<div id="modal" class="fixed top-0 right-0 left-0 bottom-0 grid place-items-center z-50 bg-black bg-opacity-25">
		<div class="bg-white rounded-md border shadow max-w-[95vw]">
			<div class="p-7">
				<p class="text-2xl font-bold block text-center">Kode Pendaftaran :</p>
				<h1 class="text-4xl md:text-6xl text-primary font-bold block text-center p-4">
					{{ $kode }}
				</h1>
				<ol class="pl-3 list-decimal mt-3" style="line-height: 1.5rem">
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
				<button type="button" class="px-5 py-2 mt-4 md:mt-5 rounded bg-primary text-white block mx-auto"
				onclick="document.getElementById('modal').style.display = 'none'">
					TUTUP
				</button>
			</div>
		</div>
	</div>
@endif