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
	<div class="row">
		@include('admin.components.bigsearch', [
			'input' => ['name' => 'search', 'label' => 'Cari nama/username user...']
		])

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<a href="/admin/users/create" class="text-primary">
						<i class="fa fa-plus"></i> Tambah User
					</a>
				</div>
				<div class="card-body">
					@include('admin.components.table', [
						'data' => $users,
						'th' => ['Nama', 'Username', 'Level', 'Action'],
						'td' => [
							fn($row) => $row->name,
							fn($row) => $row->username,
							fn($row) => StringHelper::toTitle($row->level->name),
							fn($row) => htmlAction($row),
						],
					])
				</div>
			</div>
		</div>

		<div class="col-12">
			{!! $users->links() !!}
		</div>
	</div>
@endsection