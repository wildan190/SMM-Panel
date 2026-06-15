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
						<label class="form-label">Email *</label>
						<input type="email" class="form-control" name="email" value="<?= $target->email ?>">
					</div>
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
							<option value="Member" <?= ($target->level == 'Member') ? 'selected' : '' ?>>Member</option>
							<option value="Agen" <?= ($target->level == 'Agen') ? 'selected' : '' ?>>Agen</option>
							<option value="Reseller" <?= ($target->level == 'Reseller') ? 'selected' : '' ?>>Reseller</option>
							<option value="Owner" <?= ($target->level == 'Owner') ? 'selected' : '' ?>>Owner</option>
						</select>
					</div>
						<div class="form-group mb-2">
							<label class="form-label">Saldo</label>
							<div class="input-group">
                                <div class="input-group-text">Rp.</div>
                                <input type="number" class="form-control" name="balance" value="<?= $target->balance ?>">
                            </div>
						</div>
					<div class="form-group mb-2">
						<label class="form-label">API Key *</label>
						<div class="input-group mb-2">
							<input type="text" class="form-control" name="api_key" value="<?= $target->api_key ?>" id="api_key">
								<button class="btn btn-primary" type="button" onclick="generate_api_key(50)"><i class="fas fa-edit"></i></button>
						</div>
					</div>
					<div class="hstack gap-1 w-100 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function generate_api_key() {
	$.ajax({
		type: "GET",
		url: "<?= base_url('admin/user/generate_api_key') ?>",
		success: function(data) {
			$('#api_key').val(data);
		}
	});
}
</script>