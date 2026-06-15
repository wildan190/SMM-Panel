<div id="modal-service-result"></div>
<form method="post" id="add-service">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
		value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="form-group">
		<label>Kategori *</label>
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
	<div class="form-group">
		<label>API *</label>
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
	<div class="form-group">
		<label>API ID Layanan *</label>
		<input type="text" class="form-control" name="api_service_id" value="<?= $result[$api->service_id_key] ?>">
	</div>
	<div class="form-group">
		<label>Nama *</label>
		<input type="text" class="form-control" name="name" value="<?= $result[$api->service_name_key] ?>">
	</div>
	<div class="form-group">
		<label>Deskripsi *</label>
		<textarea class="form-control"
			name="description"><?= ($api->description_key <> '-') ? $result[$api->description_key] : '' ?></textarea>
	</div>
	<div class="form-group">
		<label>Harga Modal *</label>
		<input type="text" class="form-control" id="price" name="price" value="<?= $result[$api->price_key] ?>">
	</div>
	<div class="form-group">
		<label>Keuntungan (%) *</label>
		<input type="number" class="form-control" id="profit" name="profit" value="50">
	</div>
	<div class="form-group">
		<label>Minimal Pesan *</label>
		<input type="number" class="form-control" name="min" value="<?= $result[$api->min_key] ?>">
	</div>
	<div class="form-group">
		<label>Maksimal Pesan *</label>
		<input type="number" class="form-control" name="max" value="<?= $result[$api->max_key] ?>">
	</div>
	<div class="form-group">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="check1" name="api" value="1" checked>
			<label class="custom-control-label" for="check1">Pesan via API</label>
		</div>
	</div>
	<div class="form-group">
		<label>Tipe *</label>
		<div class="custom-control custom-radio">
			<input type="radio" class="custom-control-input" id="radio1" value="primary" name="type" checked>
			<label class="custom-control-label" for="radio1">PRIMARY</label>
		</div>
		<div class="custom-control custom-radio">
			<input type="radio" class="custom-control-input" id="radio2" value="custom_comments" name="type">
			<label class="custom-control-label" for="radio2">CUSTOM_COMMENTS</label>
		</div>
		<div class="custom-control custom-radio">
			<input type="radio" class="custom-control-input" id="radio3" value="custom_link" name="type">
			<label class="custom-control-label" for="radio3">CUSTOM_LINK</label>
		</div>
	</div>
	<div class="text-right">
		<button type="reset" class="btn btn-danger">Reset</button>
		<button type="button" class="btn btn-success"
			onclick="add_service('#add-service', '<?= base_url('admin/' . $this->uri->segment(2) . '/add') ?>')"><i
				class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
	</div>
</form>