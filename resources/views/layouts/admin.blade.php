<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $page['title'] ?? $title ?? '' }}</title>
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.min.css">
	@stack('styles')
	<link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
	<style>
		#xtable {font-size: 12px}
		#filterForm .form-group { margin: .25rem }
		#filterForm input { text-align: center }
		#filterForm input::placeholder { text-align: center }
		.btn-group {margin-bottom: .2rem}
		.btn.btn-warning {color:white !important}
		.btn-group.btn-group-sm .btn {
			font-size: .75rem;
			line-height: .8rem;
			padding: .25rem .4rem;
			/* padding: .2rem .5rem !important */
		}
		#formFilter .form-group { margin: .25rem }
	</style>
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		@include('admin.components.navbar')
		@include('admin.components.sidebar')
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-12">
							<h1 class="d-inline-block">
								{{ $page['header'] ?? $header ?? $page['title'] ?? $title ?? '' }}
							</h1>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
	
			<section class="content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</section>
		</div>
		@include('admin.components.footer')
	</div>

	@stack('modals')
	
	<script src="/plugins/jquery/jquery.min.js"></script>
	<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	@include('admin.components.alerts')
	
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="/plugins/select2/js/select2.full.min.js"></script>
	<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/adminlte/js/adminlte.min.js"></script>
	<script src="/dist/js/admin.js"></script>
	
	@stack('scripts')
</body>
</html>