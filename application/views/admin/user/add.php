<div class="row">
	<div class="col-md-12">
				<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data</h4>
            </div>
            <div class="card-body">	
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-2">
						<label class="form-label">Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control" name="email" value="<?= set_value('email') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="full_name" value="<?= set_value('full_name') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Username <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Password <span class="text-danger">*</span></label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Hak Akses <span class="text-danger">*</span></label>
						<select class="form-control" name="level">
							<option value="Member">Member</option>
							<option value="Agen">Agen</option>
							<option value="Reseller">Reseller</option>
							<option value="Owner">Owner</option>
						</select>
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