<nav id="navbar" class="w-full relative bg-primary">
	<div class="max-w-screen-xl mx-auto p-1">
		<div class="flex justify-between items-center">

			<a href="/" class="hover:brightness-90">
				<img src="/dist/img/logo-smk.png"
					alt="Logo {{ $config_helpers->get('nama_sekolah') }}"
					class="w-full h-auto max-w-[150px]" />
			</a>

			<ul class="flex items-center gap-4 text-white font-sans font-semibold">
				<?php $navbar_menus = [
					['href' => '/', 'label' => 'Beranda', 'active' => '/'],
					['href' => '/pendaftaran', 'label' => 'Pendaftaran'],
				] ?>

				@foreach ($navbar_menus as $menu)
				<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1) . '*') ?>

				<li class="">
					<a href="{{ $menu['href'] }}" class="hover:opacity-75 transition-opacity {{ $active ? 'text-secondary' : '' }}">
						{{ $menu['label'] }}
					</a>
				</li>
				@endforeach

			</ul>
		</div>
	</div>
</nav>