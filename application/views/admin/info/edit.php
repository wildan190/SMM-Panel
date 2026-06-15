<div class="row">
	<div class="col-md-12">
		<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-edit me-2"></i>Ubah Data</h4>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-3">
						<label class="form-label">Kategori *</label>
						<select class="form-control select2-data" name="category">
							<option value="">Pilih...</option>
							<option value="info" <?= ($target->category == 'info') ? 'selected' : '' ?>>INFO</option>
							<option value="service" <?= ($target->category == 'service') ? 'selected' : '' ?>>SERVICE</option>
							<option value="maintenance" <?= ($target->category == 'maintenance') ? 'selected' : '' ?>>MAINTENANCE</option>
							<option value="update" <?= ($target->category == 'update') ? 'selected' : '' ?>>UPDATE</option>
						</select>
					</div>
					<div class="form-group mb-3">
						<label class="form-label">Konten *</label>
						<textarea class="tox-target" id="h3ruc0d3" name="content"><?= $target->content ?></textarea>
					</div>
					<div class="form-group mb-3">
						<div class="form-check">
							<input type="checkbox" class="form-check-input input-primary" name="is_popup" value="1" id="checkbox" <?= ($target->is_popup == '1') ? 'checked' : '' ?>>
							<label for="checkbox">Pop Up</label>
						</div>
					</div>
					<div class="hstack gap-1 justify-content-end">
						<button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>