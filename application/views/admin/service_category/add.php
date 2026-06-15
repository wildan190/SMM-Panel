<div class="card-body">
	<form method="post" action="<?= base_url('admin/service_category/form') ?>">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
		<div class="form-group mb-2">
			<label class="form-label">Nama Kategori</label>
			<input type="text" class="form-control" name="name" value="<?= set_value('name') ?>">
		</div>
		<hr>
		<div class="hstack gap-1 justify-content-end">
			<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
			<button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
		</div>
	</form>
</div>