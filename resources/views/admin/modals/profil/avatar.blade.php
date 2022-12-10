@push('modals')
	@component('admin.components.modal', [
		'id' => 'modalAvatar',
		'title' => 'Ubah Avatar'
	])
		<form action="/admin/profil/avatar" method="post">
			<div class="form-group">
				{{-- @include('admin.components.input', [
					'input' => ['variant' => 'nolabel', 'type' => 'file', 'name' => 'name', 'value' => auth()->user()->avatar]
				]) --}}
			</div>
		</form>
	@endcomponent
@endpush