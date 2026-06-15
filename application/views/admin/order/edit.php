<form method="post" action="<?= base_url('admin/'.$this->uri->segment(2).'/form/'.$target->id) ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="mb-3">
		<label class="form-label">Status</label>
		<select name="status" class="form-control select2-data">
            <option value="" required>Pilih Status..</option>
                <?php
                foreach ($status as $key => $value) {
                ?>
                <option value="<?= $key ?>"><?= $value['name'] ?></option>
                <?php
                }
                ?>
        </select>
	</div>
	<div class="mb-3">
		<label class="form-label">Jumlah Awal *</label>
		<input class="form-control" name="start_count" value="<?= $target->start_count?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Jumlah Kurang *</label>
		<input class="form-control" name="remains" value="<?= $target->remains?>">
	</div>
	<div class="mb-3">
		<label class="form-label">API ID Pesanan *</label>
		<input class="form-control" name="api_order_id" value="<?= $target->api_order_id?>" readonly>
	</div>
	<div class="modal-footer">
	<button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
	<button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
    </div>
</form>