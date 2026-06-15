<form method="post" action="<?= base_url('admin/'.$this->uri->segment(2).'/form/'.$target->id) ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="form-group">
		<label>Status</label>
		<select name="status" class="form-control">
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
	<div class="form-group">
		<label>ID Order API *</label>
		<input class="form-control" name="api_order_id" value="<?= $target->api_order_id?>" readonly>
	</div>
	<button type="reset" class="btn btn-danger">Reset</button>
	<button type="submit" class="btn btn-success">Submit</button>
</form>