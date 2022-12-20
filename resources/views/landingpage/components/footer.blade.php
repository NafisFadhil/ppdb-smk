<footer id="footer" class="bg-dark text-white p-4">
	<div class="row">
		<h1 class="col-12 text-center fw-bold mb-1">PPDB 2023</h1>
		<h5 class="col-12 text-center mb-2">{{ ConfigHelper::get('nama_sekolah') }}</h5>
		<p class="col-12 text-center">{{ ConfigHelper::get('alamat_sekolah') }}</p>
	</div>
	
	<div class="w-100 p-0">
		<p class="fs-7 mx-auto text-center m-0">
			Copyright &copy;2022
			<a href="https://www.smuhblig.sch.id" class="link-light">
				{{ ConfigHelper::get('nama_sekolah') }}.
			</a>
			All Rights Reserved.
		</p>
	</div>
</footer>