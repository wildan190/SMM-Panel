<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Deposit Baru</h4>
			</div>
			<div class="card-body pb-3">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
						<select class="select2 form-control" name="type" id="type">
							<option value="">— Pilih Salah Satu —</option>
							<option value="qris">QRIS</bank>
							<option value="bank">BANK</bank>
							<option value="pulsa">PULSA</bank>
							<option value="ewallet">E-WALLET</bank>
							<option value="virtual_account">VIRTUAL ACCOUNT</bank>
							<option value="mini_market">MINI MARKET</bank>
						</select>
					</div>
					<?php
					$getMethod = $this->deposit_method_model->get_rows(['group_by' => 'category', 'status' => 1]);
					foreach ($getMethod as $key => $dataMethod) {
					?>
						<div class="form-group progress d-none" id="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
						</div>
						<div class="payment-group form-group d-none" id="payment-group-<?= $dataMethod['category'] ?>">
							<div class="row gy-2 gx-2">
								<?php
								$detailMethod = $this->deposit_method_model->get_rows(['where' => [['category' => $dataMethod['category'], 'status' => 1]]]);
								foreach ($detailMethod as $key => $data) {
								?>
									<div class="col-12 col-md-6 col-lg-4">
										<div class="payment-menu h-100">
											<input id="<?= $data['id'] ?>" name="method" type="radio" class="form-check-input" value="<?= $data['id'] ?>">
											<label class="payment-item h-100" for="<?= $data['id'] ?>">
												<div class="info-top">
													<div>
														<img src="<?= base_url() ?>uploads/<?= $data['thumbnail_payment'] ?>" alt="" height="25px">
													</div>
												</div>
												<div class="info-bottom text-sm-left">
													<span class="fw-bolder"><?= $data['name'] ?></span>
													<div class=""><?= $data['description'] ?></div>
												</div>
											</label>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php }  ?>
					<div class="form-group mb-2 d-none" id="input_phone">
						<label class="form-label">Nomor Telepon Pengirim <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="phone_number">
						<small>Contoh: 6281311020XXX</small>
					</div>
					<div class="form-group">
						<label class="form-label">Minimal Deposit</label>
						<div class="input-group">
							<div class="input-group-text">Rp.</div>
							<input type="text" class="form-control" id="min_deposit" value="0" disabled>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label class="form-label">Jumlah Deposit <span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-text">Rp.</div>
								<input type="number" class="form-control" name="amount" id="amount" placeholder="50000">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label class="form-label">Saldo Diterima</label>
							<div class="input-group">
								<div class="input-group-text">Rp.</div>
								<input type="text" class="form-control" id="get_balance" value="0" disabled>
							</div>
						</div>
					</div>
					<hr>
					<div class="hstack gap-1 justify-content-end">
						<button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-credit-card fs-6 me-2"></i>Deposit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header py-3">
				<h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h4>
			</div>
			<div class="card-body">
				<p><?= nl2br(website_config('deposit_info')) ?></p>
			</div>
		</div>
	</div>
</div>
</div>


<script type="text/javascript">
	$(document).keypress(function(event) {
		if (event.which == '13' && !$(event.target).is('textarea')) {
			event.preventDefault();
		}
	});
	$(function() {
		$('select[id=type]').change(function() {
			HoldOn.open({
				theme: "sk-rect",
				message: "Please wait...",
				textColor: "white"
			});
			$('#get_balance').val('');
			$('#input_phone').addClass('d-none');
			$('.payment-group').addClass('d-none');
			$('input[name=method]').prop('checked', false);
			$('#progress').removeClass('d-none');
			setTimeout(() => {
				HoldOn.close();
				$('#progress').addClass('d-none');
				$('#payment-group-' + $('select[id=type]').val()).removeClass('d-none');
				if ($('select[id=type]').val() == 'pulsa') {
					$('#input_phone').removeClass('d-none');
				} else {
					$('#input_phone').addClass('d-none');
				}
			}, 100);
		});
		$('input[type=radio][name=method]').change(function() {
			var method = $(this).val();
			$.ajax({
				type: "GET",
				url: "<?= base_url('ajax/deposit_method_detail/') ?>" + method + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
				dataType: "json",
				success: function(data) {
					HoldOn.close();
					$('#min_deposit').val(data.msg.min_deposit);
				},
				error: function() {
					HoldOn.close();
					$('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
				},
				beforeSend: function() {
					HoldOn.open({
						theme: "sk-rect",
						message: "Please wait...",
						textColor: "white"
					});
					$('#form-bonus').addClass('d-none');
					$('#data-bonus').html('');
				}
			});
		});
		$('#amount').on('keyup', function() {
			var method = $('input[type=radio][name=method]:checked').val();
			var amount = $('#amount').val();
			$.ajax({
				type: "GET",
				url: "<?= base_url('ajax/deposit_get_balance/') ?>" + method + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&amount=" + amount,
				dataType: "json",
				success: function(data) {
					HoldOn.close();
					$('#get_balance').val(data.msg);
				},
				error: function(error) {
					HoldOn.close();
					$('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
				},
				beforeSend: function() {
					HoldOn.open({
						theme: "sk-rect",
						message: "Please wait...",
						textColor: "white"
					});
				}
			});
		});
	});
</script>