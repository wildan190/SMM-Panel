<div class="card-body">
	<form method="post" action="<?= base_url('admin/service_category/form/' . $target->id) ?>">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
		<div class="form-group mb-2">
			<label class="form-label">Nama Provider Kategori</label>
			<input type="text" class="form-control" value="<?= $target->name_provider ?>" disabled>
		</div>
		<div class="form-group mb-2">
			<label class="form-label">Nama Kategori</label>
			<input type="text" class="form-control" name="name" value="<?= $target->name ?>">
		</div>
		<div class="form-group mb-2">
			<label class="form-label">Tipe</label>
			<input type="text" class="form-control" name="type" value="<?= $target->type_category ?>">
		</div>
		<hr>
		<div class="hstack gap-1 w-100 justify-content-end">
			<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
			<button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
		</div>
	</form>
</div>