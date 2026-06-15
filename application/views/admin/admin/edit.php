<div class="row">
	<div class="col-md-12">
				<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
            <div class="card-header">
				<h4 class="mb-0"><i class="fas fa-edit me-2"></i>Ubah Data</h4>
            </div>
            <div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-2">
						<label class="form-label">Nama Lengkap *</label>
						<input type="text" class="form-control" name="full_name" value="<?= $target->full_name ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Username *</label>
						<input type="text" class="form-control" name="username" value="<?= $target->username ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Password</label>
						<input type="password" class="form-control" name="password">
						<small>Kosongkan jika tidak diubah.</small>
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Hak Akses *</label>
						<select class="form-control" name="level">
							<option value="">Pilih..</option>
							<option value="owner" <?= ($target->level == 'owner') ? 'selected' : '' ?>>OWNER</option>
							<option value="admin" <?= ($target->level == 'admin') ? 'selected' : '' ?>>ADMIN</option>
						</select>
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