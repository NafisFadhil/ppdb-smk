@extends('layouts.admin')

<?php function htmlAction ($row) { ?>
	<div class="btn-group btn-group-sm">
		{{-- Edit --}}
		<button type="button" title="Edit" class="btn btn-warning"
		onclick="location = '/admin/users/'+{{ $row->id }}+'/edit'">
			<i class="fa fa-pen text-white"></i>
		</button>

		{{-- Hapus --}}
		<button type="button" title="Hapus" class="btn btn-danger"
		onclick="confirm('Konfirmasi penghapusan user...') ? location = '/admin/users/'+{{ $row->id }}+'/hapus' : null">
			<i class="fa fa-trash text-white"></i>
		</button>
	</div>
<?php } ?>

@section('content')
		@include('admin.components.bigsearch', [
			'input' => ['name' => 'search', 'label' => 'Cari nama/username user...']
		])
	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<a href="/admin/users/create" class="text-primary">
						<i class="fa fa-plus"></i> Tambah User
					</a>
				</div>
				<div class="card-body">
					<?php
						$isadmin = $bigtype === 'admin';
						$ths = ['Nama', 'Username', 'Level', 'Action'];
						$tds = [
							fn($row) => $row->name,
							fn($row) => $row->username,
							fn($row) => StringHelper::toTitle($row->level->name),
							fn($row) => htmlAction($row),
						];

						if (!$isadmin) {
							$ths[2] = 'Tanggal Lahir';
							$tds[2] = fn($row) => ModelHelper::formatTanggal($row->identitas->tanggal_lahir);
						}
					?>
					@include('admin.components.table', [
						'data' => $users,
						'th' => $ths,
						'td' => $tds,
					])
				</div>
			</div>
		</div>

		<div class="col-12">
			{!! $users->links('pagination::bootstrap-4') !!}
		</div>
	</div>
@endsection