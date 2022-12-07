<!--
=========================================================
* Soft UI Dashboard - v1.0.6
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="/dist/img/logo-smk-kotak.png">
  <title> {{ $page['title'] ?? $title ?? '' }} </title>
  <link href="/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
  @stack('styles')
  <link id="pagestyle" href="/softui/css/soft-ui-dashboard.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  @include('siswa.components.alerts')
	@include('siswa.components.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		@include('siswa.components.navbar')
    <div class="container-fluid py-4">
			@yield('main')
			@include('siswa.components.footer')
    </div>
  </main>
	@include('siswa.components.rightbar')

  <script src="/softui/js/core/popper.min.js"></script>
  <script src="/softui/js/core/bootstrap.min.js"></script>
  <script src="/softui/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/softui/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  @stack('scripts')
  <script src="/softui/js/soft-ui-dashboard.min.js"></script>
</body>

</html>