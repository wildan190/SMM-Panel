<div class="card-body">
	<form method="post" action="<?= base_url('admin/service/form') ?>">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">API Provider</label>
					<select class="form-control select2-data" name="api_id">
						<option value="">Pilih/ketik...</option>
						<?php
						foreach ($api as $key => $value) {
						?>
							<option value="<?= $value['id'] ?>" <?= (set_value('api_id') == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label class="form-label">API ID Layanan</label>
					<input type="text" class="form-control" name="api_service_id" value="<?= set_value('api_service_id') ?>">
				</div>
				<div class="form-group">
					<label class="form-label">Kategori Layanan</label>
					<select class="form-control select2-data" name="service_category_id">
						<option value="">Pilih/ketik...</option>
						<?php
						foreach ($service_category as $key => $value) {
						?>
							<option value="<?= $value['id'] ?>" <?= (set_value('service_category_id') == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label class="form-label">Nama Layanan</label>
					<input type="text" class="form-control" name="name" value="<?= set_value('name') ?>">
				</div>
				<div class="form-group">
					<label class="form-label">Deskripsi Layanan</label>
					<textarea class="form-control" name="description" rows="4"><?= set_value('description') ?></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-label">Harga/K</label>
					<div class="input-group">
						<div class="input-group-text">Rp</div>
						<input type="number" class="form-control" name="price" value="<?= set_value('price') ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Keuntungan/K</label>
					<div class="input-group">
						<div class="input-group-text">Rp</div>
						<input type="number" class="form-control" name="profit" value="<?= set_value('profit') ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Minimal Pesan</label>
					<input type="number" class="form-control" name="min" value="<?= set_value('min') ?>">
				</div>
				<div class="form-group">
					<label class="form-label">Maksimal Pesan</label>
					<input type="number" class="form-control" name="max" value="<?= set_value('max') ?>">
				</div>
				<div class="form-group">
					<div class="form-check">
						<input type="checkbox" class="form-check-input input-primary" id="check1" name="api" value="1" checked>
						<label class="form-check-label text-muted" for="check1">Pesan via API</label>
					</div>
				</div>
				<div class="form-group">
					<div class="form-check">
						<input type="checkbox" class="form-check-input input-primary" id="check_refill" name="refill" value="1">
						<label class="form-check-label text-muted" for="check_refill">Perbolehkan Refill</label>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Tipe</label>
					<div class="form-check">
						<input type="radio" class="form-check-input input-primary" id="radio1" value="primary" name="type" checked>
						<label class="form-check-label text-muted" for="radio1">Utama</label>
					</div>
					<div class="form-check">
						<input type="radio" class="form-check-input input-primary" id="radio2" value="custom_comments" name="type">
						<label class="form-check-label text-muted" for="radio2">Kustom Komentar</label>
					</div>
					<div class="form-check">
						<input type="radio" class="form-check-input input-primary" id="radio3" value="custom_link" name="type">
						<label class="form-check-label text-muted" for="radio3">Kustom Link</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="hstack gap-1 justify-content-end">
			<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
			<button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
		</div>
	</form>
</div>