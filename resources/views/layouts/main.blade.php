<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="author" content="SMK Muhammadiyah Bligo" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="copyright" content="SMK Muhammadiyah Bligo" />
	<meta name="rating" content="general" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="googlebot" content="index, follow" />
	<meta name="msnbot" content="index, follow" />
	<meta name="yahoobot" content="index, follow" />
	<meta name="bingbot" content="index, follow" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="apple-mobile-web-app-title" content="ppdb-smublig" />
	<meta name="charset" content="utf-8" />
	<meta name="msapplication-tilecolor" content="#FFFFFF" />
	<meta name="msapplication-tileimage" content="/dist/img/logo-smk-kotak.png" />
	<meta name="theme-color" content="#FFF" />
	
	<title>{{ $page['title'] ?? $title ?? '' }}</title>
	<meta name="keywords" content="ppdb, ppdb 2023, ppdb smk, smk, smkmuhbligo,
	smuhblig, muhammadiyah, bligo, pendaftaran, smk muhammadiyah bligo" />
	<meta name="description" content="Website Pendaftaran PPDB Online Tahun Ajaran 2023/2024 SMK Muhammadiyah Bligo." />
	
	@isset($page['deskripsi']) <meta name="description" content="{{ $page['deskripsi'] }}" /> @endisset
	@isset($page['keywords']) <meta name="keywords" content="{{ $page['keywords'] }}" /> @endisset
	@stack('metadata')
	
	{{-- Alternate --}}
	<link rel="alternate" href="/rss.xml" type="application/rss+xml" title="RSS" />

	{{-- Css --}}
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css" />
	<link rel="stylesheet" href="/dist/css/tailwind.css" />
	<link rel="shortcut icon" href="/dist/img/logo-smk-kotak.png" type="image/png" />
	
	<style>
		:root {
			font-family: sans-serif;
			font-size: 15px;
		}
		.big-marker { padding-left: 1.5rem }
		.big-marker > li::marker { font-size: 1.5rem }

		.small-marker { padding-left: 1.1rem }
		.small-marker > li::marker { font-size: 1.1rem }

		.dash-marker > li::marker {
			content: ' - ';
			display: inline-block;
			font-size: 1.4rem;
			line-height: 1rem;
			/* font-weight: 600; */
		}
	</style>
	@stack('styles')

	{{-- Jquery --}}
	<script src="/plugins/jquery/jquery.min.js"></script>

</head>
<body>

	@yield('body')

	@include('components.alert')
	
	<script src="/dist/js/script.js"></script>
	<script>
		let inputs = document.getElementsByClassName('input-uppercase');
		for (let input of inputs) {
			input.onkeyup = function () {
				input.value = input.value.toUpperCase();
			}
		}
	</script>
	@stack('scripts')

</body>
</html>