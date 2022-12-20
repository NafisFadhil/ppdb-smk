<?php $navbar_menu = [
	['href' => '/', 'label' => 'Beranda', 'active' => '/'],
	['href' => '/formulir', 'label' => 'Pendaftaran', 'desc' => 'Formulir Pendaftaran', 'active' => 'formulir'],
	['href' => '/login', 'label' => 'Login', 'desc' => 'Login', 'dropdown' => [
		['href' => '/login', 'label' => 'Siswa', 'desc' => 'Halaman Login Untuk Siswa Peserta PPDB'],
		['href' => '/login/admin', 'label' => 'Admin', 'desc' => 'Halaman Login Untuk Admin PPDB']
	]],
	['href' => '/kontak', 'label' => 'Kontak'],
] ?>

<nav class="navbar p-0 navbar-expand-md navbar-dark bg-primary">
  <div class="container-fluid px-md-4 justify-content-start">

    <button class="navbar-toggler p-1 btn-sm" type="button"
    data-bs-toggle="collapse" data-bs-target="#navbarToggler"
    aria-controls="navbarToggler" aria-expanded="false"
    aria-label="Toggle navigation" style="border: none">
      <i class="fa fa-bars"></i>
    </button>

    <a class="navbar-brand p-1" href="/">
      <img src="/dist/img/logo-smk.png"
      alt="Logo {{ ConfigHelper::get('nama_sekolah') }}"
      width="160" height="auto"
      class=""/>
    </a>    
    <div class="collapse navbar-collapse" id="navbarToggler">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @foreach($navbar_menu as $item)
          <?php
            $active = request()->is($item['active'] ?? substr($item['href'], 1).'*');
            $isdropdown = isset($item['dropdown']);
          ?>

          @if($isdropdown)
            <li class="nav-item dropdown">
              <a href="#" class="nav-link py-2 dropdown-toggle bg-none
              {{ $active ? 'active text-secondary' : 'text-light' }}"
              type="button" id="dropdownMenu{{ $loop->iteration }}"
              data-bs-toggle="dropdown" aria-expanded="false">
                {{ $item['label'] }}
              </a>

              <ul class="dropdown-menu bg-primary p-0 border-none"
              aria-labelledby="dropdownMenu" style="border: none;min-width: 0">
                @foreach($item['dropdown'] as $dropdown)
                  <?php $active = request()->is($dropdown['active'] ?? substr($dropdown['href'], 1)) ?>

                  <li>
                    <a class="btn btn-sm text-start w-100 btn-primary
                    {{ $active ? 'active text-secondary' : 'text-light' }}"
                    href="{{ $dropdown['href'] }}">
                      {{ $dropdown['label'] }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
          
            <li class="nav-item">
              <a class="nav-link {{ $active ? 'active text-secondary' : 'text-light' }}"
              @if($active) aria-current="page" @endif
              href="{{ $item['href'] }}">
                {{ $item['label'] }}
              </a>
            </li>

          @endif
          
        @endforeach
      </ul>
    </div>
  </div>
</nav>