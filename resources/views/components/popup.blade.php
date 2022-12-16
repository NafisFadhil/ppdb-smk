@if(session('pasca_pendaftaran'))
	<?php 
		$kode = session('kode');
		$tagihan = session('tagihan');
	?>

	<div id="modal" class="fixed top-0 right-0 left-0 bottom-0 grid place-items-center z-50 bg-black bg-opacity-25">
		<div class="bg-white rounded-md border shadow w-[460px] max-w-[95vw]">
			<div class="p-7">
				<p class="text-2xl font-bold block text-center">Kode Pendaftaran :</p>
				<h1 class="text-4xl sm:text-5xl text-primary font-bold block text-center p-4">
					{{ $kode }}
				</h1>
				<ol class="pl-3 list-decimal mt-3">
					<li>Screenshoot tampilan ini.</li>
					<li>Datang ke SMK Muhammadiyah Bligo dengan membawa :
						<ol class="list-inside pl-5" style="list-style: lower-alpha">
							<li>Kartu Keluarga (Wajib)</li>
							<li>Akta Kelahiran (Wajib)</li>
							<li>Biaya pendaftaran sebesar {{ NumberHelper::toRupiah($tagihan) }} (Wajib)</li>
							<li>Dokumen Pendukung (Jika Diperlukan)</li>
						</ol>
					</li>
				</ol>
				<button type="button" class="px-5 py-2 mt-4 rounded bg-primary text-white block mx-auto"
				onclick="closeModal()">
					TUTUP
				</button>
				@push('scripts')
					<script>
						function closeModal() {
							let model = document.getElementById('modal');
							model.innerHTML = '';
							model.style.display = 'none';
						}
					</script>
				@endpush
			</div>
		</div>
	</div>
@endif