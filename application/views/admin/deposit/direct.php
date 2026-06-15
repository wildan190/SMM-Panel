<div class="row justify-content-center">
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="fas fa-fw fa-balance-scale"></i> Kirim Saldo Langsung</h5>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label>Pengguna *</label>
						<input type="text" class="form-control" name="user" value="<?= set_value('user') ?>">
					</div>
					<div class="form-group">
						<label>Metode Deposit *</label>
						<span class="form-control" style="padding: 4px;">
							<select class="form-control select2" name="deposit_method">
								<option value="">Pilih/ketik...</option>
					<?php
					foreach ($deposit_method as $key => $value) {
					?>
					<option value="<?= $value['id'] ?>" <?= (set_value('deposit_method') == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
					<?php
					}
					?>
							</select>
						</span>
					</div>
					<div class="form-group">
						<label>Jumlah *</label>
						<input type="number" class="form-control" name="amount" value="<?= set_value('amount') ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>