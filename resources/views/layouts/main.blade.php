<!DOCTYPE html>
<html lang="en">
<head>

	@stack('metadata')
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="SMK Muhammadiyah Bligo">
	
	<title>{{ $page['title'] ?? $title ?? '' }}</title>

	{{-- Css --}}
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/dist/css/tailwind.css">
	<link rel="stylesheet" href="/dist/fonts/poppins.ttf">
	@stack('styles')

	{{-- Jquery --}}
	<script src="/plugins/jquery/jquery.min.js"></script>

</head>
<body>

	@yield('body')
	@stack('scripts')

</body>
</html>