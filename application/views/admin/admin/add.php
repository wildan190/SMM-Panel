<div class="row justify-content-center">
	<div class="col-sm-8">
		<div class="text-left mb-2">
			<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-success"><i class="mdi mdi-arrow-left"></i> Kembali</a>
		</div>
		<div class="card shadow mb-4">
            <div class="card-header py-3">
				<h4 class="card-title mb-0 flex-grow-1"><i class="mdi mdi-plus"></i> Tambah Data</h4>
            </div>
            <div class="card-body">	
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-2">
						<label>Nama Lengkap *</label>
						<input type="text" class="form-control" name="full_name" value="<?= set_value('full_name') ?>">
					</div>
					<div class="form-group mb-2">
						<label>Username *</label>
						<input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
					</div>
					<div class="form-group mb-2">
						<label>Password *</label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="form-group mb-2">
						<label>Hak Akses *</label>
						<select class="form-control" name="level">
							<option value="">Pilih..</option>
							<option value="owner">OWNER</option>
							<option value="admin">ADMIN</option>
						</select>
					</div>
					<div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-dark"><i class="mdi mdi-cancel"></i> Reset</button>
                        <button type="submit" class="btn btn-blue"><i class="mdi mdi-send"></i> Submit</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>