<?php $sidebar = array_merge(
	[
		['href' => '/siswa', 'label' => 'Beranda', 'icon' => 'fas fa-home'],
		['href' => '/siswa/profil', 'label' => 'Edit Profil', 'icon' => 'fas fa-user-cog'],
		['href' => '/logout', 'label' => 'Keluar', 'icon' => 'fas fa-power-off'],
	]
) ?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
		<a class="navbar-brand m-0" href="/siswa">
			<img src="/dist/img/logo-smk-kotak.png" class="navbar-brand-img h-100"
				alt="Logo {{ ConfigHelper::get('nama_sekolah') }}">
			<span class="ms-1 font-weight-bold">PPDB {{ ConfigHelper::get('tahun_ppdb') }}</span>
		</a>
	</div>
	<hr class="horizontal dark mt-0">
	<div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
		<ul class="navbar-nav">
			@foreach ($sidebar as $item)
				<?php $active = request()->is($item['active'] ?? substr($item['href'],1)) ?>

				<li class="nav-item">
					<a class="nav-link {{ $active ? 'active' : '' }}" href="{{ $item['href'] }}">
						<div class="icon shadow border-radius-md bg-white text-center me-2 p-2 d-flex align-items-center justify-content-center">
							<i class="{{ $item['icon'] }} fa-md" style="color: {{ $active ? 'white' : 'black' }}"></i>
						</div>
						<span class="nav-link-text ms-1">{{ $item['label'] }}</span>
					</a>
				</li>
			@endforeach
		</ul>
	</div>
</aside>