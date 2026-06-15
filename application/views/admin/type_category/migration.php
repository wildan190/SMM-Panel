<div class="row justify-content-center">
	<div class="col-lg-8">
		<div class="text-left mb-3">
			<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-secondary"><i class="fa fa-reply fa-fw"></i> Kembali</a>
		</div>
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="fas fa-fw fa-tag"></i> Migrasi Kategori</h5>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label>Kategori Awal *</label>
						<select class="form-control select2" name="category_awal">
							<option value="">-- Pilih Salah Satu --</option>
                            <?php foreach ($category as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                            <?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Kategori Tujuan *</label>
						<select class="form-control select2" name="category_tujuan">
							<option value="">-- Pilih Salah Satu --</option>
                            <?php foreach ($category as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                            <?php } ?>
						</select>
					</div>
					<div class="text-right">
						<button type="reset" class="btn btn-secondary">Reset</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>