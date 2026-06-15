<div class="row">
	<div class="col-md-12">
		<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data</h4>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-2">
						<label class="form-label">Judul *</label>
						<input type="text" class="form-control" id="heads" name="title" value="<?= set_value('title') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Konten *</label>
						<textarea class="tox-target" id="h3ruc0d3" name="content"></textarea>
					</div>
					<div class="hstack gap-1 justify-content-end">
						<button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>