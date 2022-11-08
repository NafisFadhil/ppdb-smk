<?php $navbar_menu = [
	['href' => '/', 'label' => 'Beranda', 'active' => '/'],
	['href' => '/pendaftaran', 'label' => 'Pendaftaran'],
	['href' => '/hasil-penerimaan', 'label' => 'Hasil Penerimaan'],
	['href' => '/kontak', 'label' => 'Kontak'],
]; $navbar_menu_responsive = array_merge($navbar_menu);
?>

<nav id="navbar" class="w-full relative bg-dark text-white">
	<div class="max-w-screen-xl mx-auto px-2 sm:px-4 sm:py-1">
		<div class="flex justify-start md:justify-between gap-2 items-center">

			<button type="button" id="navbarToggler" class="cursor-pointer block md:hidden bg-transparent outline-none hover:opacity-80 transition-opacity p-2">
				<i class="fas fa-bars fa-lg"></i>
			</button>

			<a href="/" class="">
				<img src="/dist/img/logo-smk-putih.png"
					alt="Logo {{ ConfigHelper::get('nama_sekolah') }}"
					class="w-full h-auto max-w-[130px] md:max-w-[150px] py-2" />
					{{-- class="w-full h-auto max-w-[150px] md:max-w-[175px] p-2" /> --}}
			</a>

			<ul class="hidden md:flex justify-center items-center gap-5">
				@foreach ($navbar_menu as $menu)
					<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1) . '*') ?>

					<li class="">
						<a href="{{ $menu['href'] }}" class="hover:opacity-75 transition-opacity
							{{ $active ? 'text-primary' : '' }}">
							{{ $menu['label'] }}
						</a>
					</li>
				@endforeach
			</ul>

			<div id="navbarResponsiveMenu" class="absolute top-full left-0 right-0 bg-dark text-white hidden z-10">
				<div class="grid grid-auto-rows grid-cols-1 gap-0 text-left">
					@foreach ($navbar_menu_responsive as $menu)

						<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1) . '*') ?>
						<a href="{{ $menu['href'] }}" class="hover:opacity-75 transition-opacity p-3
							{{ $active ? 'text-primary' : '' }}">
							{{ $menu['label'] }}
						</a>

					@endforeach

				</div>
			</div>
			
		</div>
	</div>
</nav>