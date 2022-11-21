<?php
$navbar_menu = [
	['href' => '/', 'label' => 'Beranda', 'active' => '/'],
	['href' => '/formulir', 'label' => 'Pendaftaran', 'desc' => 'Formulir Pendaftaran', 'active' => 'formulir'],
	['href' => '/login', 'label' => 'Login', 'desc' => 'Login', 'dropdown' => [
		['href' => '/login', 'label' => 'Siswa', 'desc' => 'Halaman Login Untuk Siswa Peserta PPDB'],
		['href' => '/login/admin', 'label' => 'Admin', 'desc' => 'Halaman Login Untuk Admin PPDB']
	]],
	['href' => '/kontak', 'label' => 'Kontak'],
]; $navbar_menu_responsive = array_merge($navbar_menu);
?>

<nav id="navbar" class="w-full relative bg-primary text-white">
	<div class="max-w-screen-xl mx-auto px-2 sm:px-4 sm:py-1">
		<div class="flex justify-start md:justify-between gap-2 items-center">

			<button type="button" id="navbarToggler" class="cursor-pointer block md:hidden bg-transparent outline-none hover:opacity-80 transition-opacity p-2">
				<i class="fas fa-bars fa-lg"></i>
			</button>

			<a href="/" class="">
				<img src="/dist/img/logo-smk-putih.png"
					alt="Logo {{ ConfigHelper::get('nama_sekolah') }}"
					class="w-full h-auto max-w-[130px] md:max-w-[150px] py-2" />
			</a>

			<ul class="hidden md:flex justify-center items-center">
				@foreach ($navbar_menu as $menu)
				<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1).'*') ?>

					@isset($menu['dropdown'])
						<li class="group relative w-full">
							<a href="{{ $menu['href'] }}" title="{{ $menu['desc'] ?? '' }}" class="hover:opacity-75 transition-opacity
								{{ $active ? 'text-secondary' : '' }} p-3 block">
								{{ $menu['label'] }}
							</a>
							<ul class="hidden group-hover:grid grid-cols-1 grid-rows-auto absolute top-full left-0 min-w-max bg-primary rounded-b">
								@foreach ($menu['dropdown'] as $dropdown)
									<?php $active = request()->is($dropdown['active'] ?? substr($dropdown['href'], 1)) ?>
									
									<a href="{{ $dropdown['href'] }}" title="{{ $dropdown['desc'] ?? '' }}" class="hover:opacity-75 transition-opacity
										{{ $active ? 'text-secondary' : '' }} px-3 py-1.5">
										{{ $dropdown['label'] }}
									</a>
								@endforeach
							</ul>
						</li>
					@else
						<li class="relative">
							<a href="{{ $menu['href'] }}" title="{{ $menu['desc'] ?? '' }}" class="hover:opacity-75 transition-opacity
								{{ $active ? 'text-secondary' : '' }} p-3 block">
								{{ $menu['label'] }}
							</a>
						</li>
					@endisset
				@endforeach
			</ul>

			<div id="navbarResponsiveMenu" class="absolute top-full left-0 right-0 bg-dark text-white hidden z-10">
				<div class="grid grid-auto-rows grid-cols-1 gap-0 text-left">
					@foreach ($navbar_menu_responsive as $menu)

						<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1) . '*') ?>
						<a href="{{ $menu['href'] }}" class="hover:opacity-75 transition-opacity p-3
							{{ $active ? 'text-secondary' : '' }}">
							{{ $menu['label'] }}
						</a>

					@endforeach

				</div>
			</div>
			
		</div>
	</div>
</nav>