<div id="modal-service-result"></div>
<style>
	.form-check .form-check-input {
		cursor: pointer;
	}
</style>
<form method="post" id="add-service">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="form-label">Kategori <span class="text-danger">*</span></label>
				<select class="form-control select2-data" name="service_category_id">
					<option value="">Pilih/ketik...</option>
					<?php
					foreach ($service_category as $key => $value) {
					?>
						<option value="<?= $value['id'] ?>">
							<?= $value['name'] ?>
						</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="form-label">Nama Provider <span class="text-danger">*</span></label>
					<select class="form-control select2-data" name="api_id">
						<option value="">Pilih/ketik...</option>
						<?php
						foreach ($api_provider as $key => $value) {
						?>
							<option value="<?= $value['id'] ?>" <?= ($api->api_id == $value['id']) ? 'selected' : '' ?>>
								<?= $value['name'] ?>
							</option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label class="form-label">API ID Layanan <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="api_service_id" value="<?= $result[$api->service_id_key] ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="form-label">Nama <span class="text-danger">*</span></label>
				<input type="text" class="form-control" name="name" value="<?= $result[$api->service_name_key] ?>">
			</div>
			<div class="form-group">
				<label class="form-label">Deskripsi <span class="text-danger">*</span></label>
				<textarea class="form-control" name="description"><?= ($api->description_key <> '-') ? $result[$api->description_key] : '-' ?></textarea>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="form-label">Harga <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-text">Rp</div>
						<input type="text" class="form-control" id="price" name="price" value="<?= round($result[$api->price_key] + ($result[$api->price_key] * convert_percent($data_api->profit))) ?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label class="form-label">Keuntungan <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-text">Rp</div><input type="number" class="form-control" id="profit" name="profit" value="<?= round($result[$api->price_key] * convert_percent($data_api->profit)) ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="form-label">Minimal <span class="text-danger">*</span></label>
					<input type="number" class="form-control" name="min" value="<?= $result[$api->min_key] ?>">
				</div>
				<div class="form-group col-md-6">
					<label class="form-label">Maksimal <span class="text-danger">*</span></label>
					<input type="number" class="form-control" name="max" value="<?= $result[$api->max_key] ?>">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label class="form-label">Pesan Via API <span class="text-danger">*</span></label>
					<select class="form-control select2-data" name="api">
						<option value="1" selected>Ya</option>
						<option value="0">Tidak</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label class="form-label">Refill Button <span class="text-danger">*</span></label>
					<select class="form-control select2-data" name="refill">
						<option value="1" <?= ($result[$api->refill_key] == 'true' or $result[$api->refill_key] == '1') ? 'selected' : '' ?>>Ya</option>
						<option value="0" <?= ($result[$api->refill_key] == 'false' or $result[$api->refill_key] == '0') ? 'selected' : '' ?>>Tidak</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label class="form-label">Tipe <span class="text-danger">*</span></label>
					<select class="form-control select2-data" name="type">
						<option value="primary" selected>PRIMARY</option>
						<option value="custom_comments">CUSTOM_COMMENTS</option>
						<option value="custom_link">CUSTOM_LINK</option>
					</select>
				</div>
			</div>
			<hr class="mt-1">
		</div>
	</div>
	<div class="hstack gap-1 w-100 justify-content-end">
		<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
		<button type="button" class="btn btn-primary float-end" onclick="add_service('#add-service', '<?= base_url('admin/' . $this->uri->segment(2) . '/add') ?>')"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
	</div>
</form>