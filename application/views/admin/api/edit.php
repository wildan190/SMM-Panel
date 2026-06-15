<form method="post" action="<?= base_url('admin/api/form/' . $target->id) ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="form-group">
		<label class="form-label">Nama Provider <span class="text-danger">*</span></label>
		<input type="text" class="form-control" name="name" value="<?= $target->name ?>">
	</div>
	<div class="form-group">
		<label class="form-label">Mata Uang / Kurs <span class="text-danger">*</span></label>
		<select class="form-control select2-data" name="kurs" id="kurs">
			<option value="IDR" <?= $target->kurs == 'IDR' ? 'selected' : '' ?>>IDR (Indonesian Rupiah)</option>
			<option value="USD" <?= $target->kurs == 'USD' ? 'selected' : '' ?>>USD (US Dollar)</option>
		</select>
	</div>
	<div class="form-group d-none" id="form-kurs">
		<label class="form-label">Rate per USD <span class="text-danger">*</span></label>
		<div class="input-group">
			<div class="input-group-text">Rp</div>
			<input type="text" class="form-control" name="rate" id="rate" value="<?= $target->rate ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="form-label">Tipe Keuntungan <span class="text-danger">*</span></label>
		<select class="form-control select2-data" name="profit_type">
			<option value="persen" <?= $target->profit_type == 'persen' ? 'selected' : '' ?>>Persen</option>
			<option value="biasa" <?= $target->profit_type == 'biasa' ? 'selected' : '' ?>>Flat</option>
		</select>
	</div>
	<div class="form-group">
		<label class="form-label">Jumlah Keuntungan <span class="text-danger">*</span></label>
		<input type="number" class="form-control" name="profit" value="<?= $target->profit ?>">
		<small class="text-danger">Jika tipe keuntungan persen harap isi input tanpa operator % example : 12</small>
	</div>
	<div class="form-group">
		<label class="form-label">API ID</label>
		<input type="text" class="form-control" name="api_id" value="<?= $target->api_id ?>">
	</div>
	<div class="form-group">
		<label class="form-label">API Key</label>
		<input type="text" class="form-control" name="api_key" value="<?= $target->api_key ?>">
	</div>
	<div class="form-group">
		<label class="form-label">Secret Key</label>
		<input type="text" class="form-control" name="secret_key" value="<?= $target->secret_key ?>">
	</div>

	<div class="form-group">
		<label class="form-label d-block">Provider Manual</label>
		<div class="form-check form-switch form-check-inline">
			<input type="checkbox" class="form-check-input input-primary" name="is_manual" id="is_manual" <?= ($target->is_manual == '1') ? 'checked' : '' ?>>
			<label class="form-check-label is_manual" for="is_manual"><?= ($target->is_manual == '1') ? '<b class="text-primary">On</b>' : '<b class="text-danger">Off</b>' ?></label>
		</div>
	</div>
	<div class="form-group">
		<label class="form-label d-block">Cronjob Auto Update</label>
		<div class="form-check form-switch form-check-inline">
			<input type="checkbox" class="form-check-input input-primary" name="auto_update" id="auto_update" <?= ($target->auto_update == '1') ? 'checked' : '' ?>>
			<label class="form-check-label auto_update" for="auto_update"><?= ($target->auto_update == '1') ? '<b class="text-primary">On</b>' : '<b class="text-danger">Off</b>' ?></label>
		</div>
	</div>
	<div class="form-group">
		<label class="form-label d-block">Cronjob Auto Status</label>
		<div class="form-check form-switch form-check-inline">
			<input type="checkbox" class="form-check-input input-primary" name="auto_status" id="auto_status" <?= ($target->auto_status == '1') ? 'checked' : '' ?>>
			<label class="form-check-label auto_status" for="auto_status"><?= ($target->auto_status == '1') ? '<b class="text-primary">On</b>' : '<b class="text-danger">Off</b>' ?></label>
		</div>
	</div>
	<div class="form-group">
		<label class="form-label d-block">Cronjob Auto Update Nama Layanan</label>
		<div class="form-check form-switch form-check-inline">
			<input type="checkbox" class="form-check-input input-primary" name="auto_name_service" id="auto_name_service" <?= ($target->auto_name_service == '1') ? 'checked' : '' ?>>
			<label class="form-check-label auto_name_service" for="auto_name_service"><?= ($target->auto_name_service == '1') ? '<b class="text-primary">On</b>' : '<b class="text-danger">Off</b>' ?></label>
		</div>
	</div>
	<hr>
	<div class="hstack gap-1 w-100 justify-content-end">
		<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
		<button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
	</div>
</form>
<script type="text/javascript">
	$(function() {
		$('#kurs').on('change', function() {
			var currency = $('#kurs').val();
			console.log(currency);
			if (currency == 'USD') {
				$('#form-kurs').removeClass('d-none');
			} else {
				$('#form-kurs').addClass('d-none');
			}
		});
	});
</script>

<script type="text/javascript">
	$("#is_manual").on('change', function() {
		if ($(this).is(':checked')) {
			$(".is_manual").html('<b class="text-primary">On</b>');
			$(this).val(1); // Mengubah nilai checkbox menjadi 1 jika dicentang
		} else {
			$(".is_manual").html('<b class="text-danger">Off</b>');
			$(this).val(0); // Mengubah nilai checkbox menjadi 0 jika tidak dicentang
		}
	});
	$("#auto_add").on('change', function() {
		if ($(this).is(':checked')) {
			$(".auto_add").html('<b class="text-primary">On</b>');
			$(this).val(1); // Mengubah nilai checkbox menjadi 1 jika dicentang
		} else {
			$(".auto_add").html('<b class="text-danger">Off</b>');
			$(this).val(0); // Mengubah nilai checkbox menjadi 0 jika tidak dicentang
		}
	});
	$("#auto_update").on('change', function() {
		if ($(this).is(':checked')) {
			$(".auto_update").html('<b class="text-primary">On</b>');
			$(this).val(1); // Mengubah nilai checkbox menjadi 1 jika dicentang
		} else {
			$(".auto_update").html('<b class="text-danger">Off</b>');
			$(this).val(0); // Mengubah nilai checkbox menjadi 0 jika tidak dicentang
		}
	});
	$("#auto_status").on('change', function() {
		if ($(this).is(':checked')) {
			$(".auto_status").html('<b class="text-primary">On</b>');
			$(this).val(1); // Mengubah nilai checkbox menjadi 1 jika dicentang
		} else {
			$(".auto_status").html('<b class="text-danger">Off</b>');
			$(this).val(0); // Mengubah nilai checkbox menjadi 0 jika tidak dicentang
		}
	});
	$("#auto_name_service").on('change', function() {
		if ($(this).is(':checked')) {
			$(".auto_name_service").html('<b class="text-primary">On</b>');
			$(this).val(1); // Mengubah nilai checkbox menjadi 1 jika dicentang
		} else {
			$(".auto_name_service").html('<b class="text-danger">Off</b>');
			$(this).val(0); // Mengubah nilai checkbox menjadi 0 jika tidak dicentang
		}
	});
	// Inisialisasi Select2 pada elemen dengan kelas .select2-data
	$('.select2-data').select2({
		dropdownParent: $('#modal-id') // Ganti 'modal-id' dengan ID modal Anda
	});
</script>