<?php
$adm = str_replace('admin-', '', auth()->user()->level->name ?? '');
$menu = array_merge([
	['href' => '/admin', 'label' => 'Beranda', 'icon' => 'fas fa-tachometer-alt'],
	['href' => '/admin/peserta', 'label' => 'Semua Peserta', 'icon' => 'fas fa-users'],
],
$adm === 'super-admin' ? [[
	'variant' => 'dropdown', 'href' => '/admin/verifikasi', 'label' => 'Verifikasi', 'icon' => 'fas fa-check', 'dropdown' => [
		['href' => '/admin/verifikasi-pendaftaran', 'label' => 'Pendaftaran'],
		['href' => '/admin/verifikasi-daftar-ulang', 'label' => 'Daftar Ulang'],
		['href' => '/admin/verifikasi-seragam', 'label' => 'Seragam'],
	]
]] : [
	['href' => '/admin/verifikasi-'.$adm, 'label' => 'Verifikasi '.StringHelper::toTitle($adm), 'icon' => 'fas fa-check']
],
[
	['href' => '/admin/sponsorship', 'label' => 'Sponsorship', 'icon' => 'fas fa-user'],
	['href' => '/logout', 'label' => 'Logout', 'icon' => 'fas fa-power-off'],
],
);?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="/admin" class="brand-link elevation-4">
		<img src="/adminlte/img/AdminLTELogo.png"
			alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
			style="opacity: .8">
		<span class="brand-text font-weight-light">PPDB {{ ConfigHelper::get('tahun_ppdb') }}</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">
					{{ auth()->user()->name ?? auth()->user()->username ?? '...' }}
				</a>
			</div>
		</div>

		<!-- SidebarSearch Form -->
		<div class="form-inline">
			<div class="input-group" data-widget="sidebar-search">
				<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-sidebar">
						<i class="fas fa-search fa-fw"></i>
					</button>
				</div>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					@foreach ($menu as $nav)
						<?php
							$variant = $nav['variant'] ?? 'default';
							$dropdown = $variant === 'dropdown';
							$header = $variant === 'header';
							if (!$header) {
								$active = request()->is($nav['active'] ?? substr($nav['href'], 1) . ($dropdown ? '*' : ''));
							}
						?>

						@if($header)
							<li class="nav-header">{{ $nav['label'] }}</li>
						@else
							<li class="nav-item {{ $active ? 'menu-open' : '' }}">
								<a href="{{ $dropdown ? '#' : $nav['href'] }}" class="nav-link {{ $active ? 'active' : '' }}">
									<i class="nav-icon {{ $nav['icon'] }}"></i>
									<p>
										{{ $nav['label'] }}
										@if($dropdown)
											<i class="right fas fa-angle-left"></i>
										@endif
									</p>
								</a>
								@if($dropdown)
									<ul class="nav nav-treeview">
										@foreach ($nav['dropdown'] as $item)
											<?php $active = request()->is($item['active'] ?? substr($item['href'], 1)); ?>
										
											<li class="nav-item">
												<a href="{{ $item['href'] }}" class="nav-link {{ $active ? 'active' : '' }}">
													<i class="far fa-circle nav-icon"></i>
													<p> {{ $item['label'] }} </p>
												</a>
											</li>
										@endforeach
									</ul>
								@endif
							</li>
						@endif

					@endforeach
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>