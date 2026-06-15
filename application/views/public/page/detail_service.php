<div class="form-group">
	<label class="form-label">ID Layanan</label>
	<span class="form-control" style="height: auto;" disabled="">
		<?= $target->id ?></span>
</div>
<div class="form-group">
	<label class="form-label">Kategori Layanan</label>
	<span class="form-control" style="height: auto;" disabled=""><?= $service_category->name ?></span>
</div>
<div class="form-group">
	<label class="form-label">Nama Layanan</label>
	<span class="form-control" style="height: auto;" disabled=""><?= $target->name ?></span>
</div>
<div class="form-group">
	<label class="form-label">Deskripsi Layanan</label>
	<span class="form-control" style="height: auto;" disabled=""><?= nl2br($target->description) ?></span>
</div>
<div class="row">
	<div class="form-group col-md-4">
		<label class="form-label"><?php
									if ($target->min == 1 && $target->max == 1) {
										echo 'Harga/1';
									} else {
										echo 'Harga/1K';
									}
									?></label>
		<div class="input-group">
			<div class="input-group-text">Rp</div>
			<span class="form-control" style="height: auto;" disabled=""><?= number_format($target->price, 0, ',', '.') ?></span>
		</div>
	</div>
	<div class="form-group col-md-4">
		<label class="form-label">Minimal / Maksimal</label>
		<span class="form-control" style="height: auto;" disabled=""><?= number_format($target->min, 0, ',', '.') ?> /
			<?= number_format($target->max, 0, ',', '.') ?></span>
	</div>
	<div class="form-group col-md-4">
		<label class="form-label">Waktu Rata-rata</label>
		<span class="form-control" style="height: auto;" disabled=""><?= get_service_average($target->id) ?></span>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-4">
		<label class="form-label">Refill Button</label>
		<span class="form-control text-<?= ($target->refill == '1') ? 'success' : 'danger' ?>" style="height: auto;" disabled=""><?= ($target->refill == '1') ? '<i class="fas fa-check-circle fs-6 me-2"></i>Aktif' : '<i class="fas fa-times-circle fs-6 me-2"></i>Nonaktif' ?></span>
	</div>
	<div class="form-group col-md-4">
		<label class="form-label">Cancel Pesanan</label>
		<span class="form-control text-<?= ($target->cancel == '1') ? 'success' : 'danger' ?>" style="height: auto;" disabled=""><?= ($target->cancel == '1') ? '<i class="fas fa-check-circle fs-6 me-2"></i>Aktif' : '<i class="fas fa-times-circle fs-6 me-2"></i>Nonaktif' ?></span>
	</div>
	<div class="form-group col-md-4">
		<label class="form-label">Status</label>
		<span class="form-control text-<?= ($target->status == '1') ? 'success' : 'danger' ?>" style="height: auto;" disabled=""><?= ($target->status == '1') ? '<i class="fas fa-check-circle fs-6 me-2"></i>Aktif' : '<i class="fas fa-times-circle fs-6 me-2"></i>Nonaktif' ?></span>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-6">
		<label class="form-label">Type</label>
		<span class="form-control" style="height: auto;" disabled=""><?= ucwords($target->type) ?></span>
	</div>
	<div class="form-group col-md-6">
		<label class="form-label">Pembaruan Terakhir</label>
		<span class="form-control" style="height: auto;" disabled=""><?= $this->lib->time_elapsed_string($target->updated_at) ?></span>
	</div>
</div>
<div class="row mb-0">
	<div class="col-md-12 text-end">
		<a href="<?= base_url() ?>order/single?id=<?php echo $target->id; ?>" class="btn btn-success"><i class="fas fa-cart-plus fs-6 me-2"></i>Pesan</a>
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
	</div>
</div>