<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Akun</h4>
            </div>
            <div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-2">
						<label class="form-label">Username</label>
						<input type="text" class="form-control" value="<?= admin('username') ?>" readonly>
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Nama Lengkap <small class="text-danger">*</small></label>
						<input type="text" class="form-control" name="full_name" value="<?= admin('full_name') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Password Baru <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Kosongkan jika tidak ingin membuat Password"><i class="fas fa-exclamation-circle"></i></a></label>
						<input type="password" class="form-control" name="new_password">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Konfirmasi Password Baru <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Kosongkan jika tidak ingin membuat Password"><i class="fas fa-exclamation-circle"></i></a></label>
						<input type="password" class="form-control" name="confirm_new_password">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Password <small class="text-danger">*</small></label>
						<input type="password" class="form-control" name="password">
					</div><hr>
                    <div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
                        <button type="submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane fs-6 me-2"></i>Ubah</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>