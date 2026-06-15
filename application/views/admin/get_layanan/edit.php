<div class="row">
	<div class="col-sm-12">
		<a href="<?= base_url('admin/' . $this->uri->segment(2)) ?>" class="btn btn-warning" style="margin-bottom: 20px;"><i class="fa fa-arrow-left fa-fw"></i> Kembali</a>
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 mb-3 header-title"><i class="fa fa-edit fa-fw"></i> Ubah Data</h4>
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label>Kategori *</label>
						<select class="form-control select2" name="service_category_id">
							<option value="">Pilih/ketik...</option>
							<?php
							foreach ($service_category as $key => $value) {
							?>
								<option value="<?= $value['id'] ?>" <?= ($target->service_category_id == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
							<?php
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>API *</label>
						<select class="form-control select2" name="api_id">
							<option value="">Pilih/ketik...</option>
							<?php
							foreach ($api as $key => $value) {
							?>
								<option value="<?= $value['id'] ?>" <?= ($target->api_id == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
							<?php
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>API ID Layanan *</label>
						<input type="text" class="form-control" name="api_service_id" value="<?= $target->api_service_id ?>">
					</div>
					<div class="form-group">
						<label>Nama *</label>
						<input type="text" class="form-control" name="name" value="<?= $target->name ?>">
					</div>
					<div class="form-group">
						<label>Deskripsi *</label>
						<textarea class="form-control" name="description"><?= $target->description ?></textarea>
					</div>
					<div class="form-group">
						<label>Harga/K *</label>
						<input type="number" class="form-control" name="price" value="<?= $target->price ?>">
					</div>
					<div class="form-group">
						<label>Keuntungan/K *</label>
						<input type="number" class="form-control" name="profit" value="<?= $target->profit ?>">
					</div>
					<div class="form-group">
						<label>Minimal Pesan *</label>
						<input type="number" class="form-control" name="min" value="<?= $target->min ?>">
					</div>
					<div class="form-group">
						<label>Maksimal Pesan *</label>
						<input type="number" class="form-control" name="max" value="<?= $target->max ?>">
					</div>
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="check1" name="api" value="1" <?= ($target->api == '1') ? 'checked' : '' ?>>
							<label class="custom-control-label" for="check1">Pesan via API</label>
						</div>
					</div>
					<div class="form-group">
						<label>Tipe *</label>
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="radio1" value="primary" name="type" <?= ($target->type == 'primary') ? 'checked' : '' ?>>
							<label class="custom-control-label" for="radio1">PRIMARY</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="radio2" value="custom_comments" name="type" <?= ($target->type == 'custom_comments') ? 'checked' : '' ?>>
							<label class="custom-control-label" for="radio2">CUSTOM_COMMENTS</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="radio3" value="custom_link" name="type" <?= ($target->type == 'custom_link') ? 'checked' : '' ?>>
							<label class="custom-control-label" for="radio3">CUSTOM_LINK</label>
						</div>
					</div>
					<button type="reset" class="btn btn-danger">Reset</button>
					<button type="submit" class="btn btn-success">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>