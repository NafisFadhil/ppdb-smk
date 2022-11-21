<?php $paths = $page['paths'] ?? request()->segments(); $xpaths = ''; ?>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 mt-2 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
	<div class="w-100 p-1 px-3 d-flex flex-row align-items-center flex-nowrap gap-3">

		<div class="collapse navbar-collapse m-0" id="navbar" style="max-width: max-content">
			<ul class="navbar-nav justify-content-end">
				<li class="nav-item d-xl-none d-flex align-items-center">
					<a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
						<div class="sidenav-toggler-inner">
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
						</div>
					</a>
				</li>
			</ul>
		</div>
		
		<nav aria-label="breadcrumb" class="d-flex flex-row flex-wrap w-100 justify-content-between">
			<h6 class="font-weight-bolder mb-0">{{ $page['subtitle'] ?? $page['title'] ?? $title ?? null }}</h6>
			<ol class="breadcrumb bg-transparent mb-0 p-0 me-0">
				@foreach ($paths as $path)
					<?php $xpath = StringHelper::toTitle($path); $xpaths .= "/$path" ?>

					@if($loop->first)
						<li class="breadcrumb-item text-sm">
							<a class="opacity-5 text-dark" href="{{ $xpaths }}"><i class="fas fa-home"></i></a>
						</li>
					@elseif($loop->last)
						<li class="breadcrumb-item text-sm text-dark active" aria-current="page">
							{{ $xpath }}
						</li>
					@else
						<li class="breadcrumb-item text-sm">
							<a class="opacity-5 text-dark" href="{{ $xpaths }}">{{ $xpath }}</a>
						</li>
					@endif
				@endforeach
			</ol>
		</nav>
	</div>
</nav>