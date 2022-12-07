<?php $navbar_menu = [
	['href' => '/', 'label' => 'Beranda', 'active' => '/'],
	['href' => '/formulir', 'label' => 'Pendaftaran', 'desc' => 'Formulir Pendaftaran', 'active' => 'formulir'],
	['href' => '/login', 'label' => 'Login', 'desc' => 'Login', 'dropdown' => [
		['href' => '/login', 'label' => 'Siswa', 'desc' => 'Halaman Login Untuk Siswa Peserta PPDB'],
		['href' => '/login/admin', 'label' => 'Admin', 'desc' => 'Halaman Login Untuk Admin PPDB']
	]],
	['href' => '/kontak', 'label' => 'Kontak'],
] ?>

<nav id="navbar" class="w-full relative bg-primary text-white">
	<div class="max-w-screen-xl mx-auto px-2 sm:px-4 sm:py-1">
		<div class="flex justify-start md:justify-between gap-2 items-center">

			<button type="button" id="navbarToggler" class="cursor-pointer block md:hidden bg-transparent outline-none hover:opacity-80 transition-opacity p-2">
				<i class="fa fa-bars fa-lg"></i>
			</button>

			<a href="/" class="">
				<img src="/dist/img/logo-smk-putih.png"
					alt="Logo {{ ConfigHelper::get('nama_sekolah') }}"
					class="w-full h-auto max-w-[130px] md:max-w-[150px] py-2" />
			</a>

			<div id="navbarMenu" class="hidden md:block absolute md:relative top-full left-0 right-0 z-20">
				<ul class="flex flex-col md:flex-row w-full bg-primary justify-center items-center">
					@foreach ($navbar_menu as $menu)
					<?php $active = request()->is($menu['active'] ?? substr($menu['href'], 1).'*') ?>
	
							<li class="group relative w-full">
								<a href="{{ isset($menu['dropdown']) ? 'javascript:void()' : $menu['href'] }}"
								title="{{ $menu['desc'] ?? '' }}" class="hover:opacity-75 transition-opacity flex flex-nowrap items-center gap-2
									{{ $active ? 'text-secondary' : '' }} p-3 block {{ isset($menu['dropdown']) ? 'navbar-dropdown-toggler' : '' }}">
									{{ $menu['label'] }} @isset($menu['dropdown']) <i class="fa fa-angle-down"></i> @endisset
								</a>
	
								@isset($menu['dropdown'])
									<ul class="hidden md:absolute top-full left-0 min-w-max bg-primary rounded-b">
										@foreach ($menu['dropdown'] as $dropdown)
											<?php $active = request()->is($dropdown['active'] ?? substr($dropdown['href'], 1)) ?>
											
											<a href="{{ $dropdown['href'] }}" title="{{ $dropdown['desc'] ?? '' }}" class="hover:opacity-75 transition-opacity
												{{ $active ? 'text-secondary' : '' }} px-3 py-1.5 block w-full md:text-center">
												{{ $dropdown['label'] }}
											</a>
										@endforeach
									</ul>
								@endisset
							</li>
					@endforeach
				</ul>
			</div>

		</div>
	</div>
</nav>