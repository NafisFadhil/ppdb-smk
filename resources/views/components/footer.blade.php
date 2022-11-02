<footer id="footer" class="bg-dark  text-white">
	<div class="w-full px-3 py-10 max-w-screen-xs mx-auto text-center flex flex-col justify-center items-center gap-3">
		<h1 class="text-4xl font-bold -mb-2">PPDB 2023</h1>
		<p class="text-xl font-semibold">{{ ConfigHelper::get('nama_sekolah') }}</p>
		<p class="">{{ ConfigHelper::get('alamat_sekolah') }}</p>
	</div>

	<div class="w-full p-2 backdrop-brightness-50">
		<p class="text-sm max-w-screen-lg mx-auto text-center">
			Copyright &copy;2022
			<a href="https://www.smuhblig.sch.id" class="hover:underline">
				{{ ConfigHelper::get('nama_sekolah') }}.
			</a>
			All Rights Reserved.
		</p>
	</div>
</footer>