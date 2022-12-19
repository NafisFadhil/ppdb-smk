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
	@stack('styles')
	<link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
	<style>
		@media print {
			body * {
				visibility: hidden;
			}
			#print-element, #print-element * {
				visibility: visible;
			}
			#cetak-pdf-button, #cetak-pdf-button *{
				visibility: hidden;
			}
			#print-element {
				position: absolute;
				left: 0;
				top: 0;
			}
		}
	</style>
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		@include('admin.components.navbar')
		@include('admin.components.sidebar')
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>{{ $page['header'] ?? $header ?? $page['title'] ?? $title ?? '' }}</h1>
						</div>
						{{-- <div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Layout</a></li>
								<li class="breadcrumb-item active">Fixed Navbar Layout</li>
							</ol>
						</div> --}}
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
	
	<script src="/plugins/select2/js/select2.full.min.js"></script>
	<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script>
		$(function () {
			let inputs = document.getElementsByClassName('input-uppercase');
			for (let input of inputs) {
				input.onkeyup = function () {
					input.value = input.value.toUpperCase();
				}
			}
			$('#xtable, table.datatable').DataTable({
				"paging": false,
				// "pageLength": 10,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": false,
				"autoWidth": true,
				"responsive": true,
				"fixedHeader": true,
			});
			$('.select2').select2()
		})
	</script>
	
	@stack('scripts')
	<script src="/adminlte/js/adminlte.min.js"></script>
</body>
</html>