<!DOCTYPE html>
<html lang="en">
<head>

	@stack('metadata')
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="SMK Muhammadiyah Bligo">
	<title>{{ $page['title'] ?? $title ?? '' }}</title>
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/plugins/bootstrap-5.0.2/dist/css/bootstrap.min.css">
	@stack('styles')
</head>
<body class="bg-light">

	<div class="wrapper min-vh-100 h-100 vh-100 d-flex flex-column">
		@include('landingpage.components.navbar')
		<main style="flex:1">
			@yield('main')
		</main>
		@include('landingpage.components.footer')
	</div>
	
	<script src="/plugins/bootstrap-5.0.2/dist/js/bootstrap.min.js"></script>
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