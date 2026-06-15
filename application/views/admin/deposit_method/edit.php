<?php
/**
 * @var object $target
 * @var CI_Controller $this
 */
?>
<div class="row">
	<div class="col-md-12">
		<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-edit me-2"></i>Ubah Data</h4>
			</div>
			<div class="card-body pb-4">
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label class="form-label d-block">Gambar Metode</label>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td class="table-primary align-middle text-center">
											<img src="<?= base_url() ?>uploads/<?= $target->thumbnail_payment ?>" class="mb-0" width="60%" alt="Gambar Metode">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<input class="form-control mb-0 <?= (form_error('thumbnail') ? 'is-invalid' : '') ?>" type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpeg, image/jpg">
						<?php echo form_error('target', '<div class="invalid-feedback">', '</div>'); ?>
						<small class="text-danger">*Kosongkan jika tidak diubah.</small>
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Nama <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" value="<?= $target->name ?>">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-2">
								<label class="form-label">No Rekening/HP <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="number_account" value="<?= $target->number_account ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-2">
								<label class="form-label">Atas Nama <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="name_account" value="<?= $target->name_account ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Tipe <span class="text-danger">*</span></label>
								<select class="form-control select2-data" name="type">
									<option value="tripay" <?= ($target->type == 'tripay' ? 'selected' : '') ?>>Tripay</option>
									<option value="paydisini" <?= ($target->type == 'paydisini' ? 'selected' : '') ?>>Paydisini</option>
									<option value="midtrans" <?= ($target->type == 'midtrans' ? 'selected' : '') ?>>Midtrans</option>
									<option value="manual" <?= ($target->type == 'manual' ? 'selected' : '') ?>>Manual</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-control select2-data" name="category">
									<option value="qris" <?= ($target->category == 'qris' ? 'selected' : '') ?>>QRIS</option>
									<option value="bank" <?= ($target->category == 'bank' ? 'selected' : '') ?>>BANK</option>
									<option value="pulsa" <?= ($target->category == 'pulsa' ? 'selected' : '') ?>>PULSA</option>
									<option value="virtual_account" <?= ($target->category == 'virtual_account' ? 'selected' : '') ?>>VIRTUAL ACCOUNT</option>
									<option value="mini_market" <?= ($target->category == 'mini_market' ? 'selected' : '') ?>>MINI MARKET</option>
									<option value="ewallet" <?= ($target->category == 'ewallet' ? 'selected' : '') ?>>E-WALLET</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Gateway? <span class="text-danger">*</span></label>
								<select class="form-control select2-data" name="gateway" id="gateway">
									<option value="1" <?= ($target->is_gateway == '1' ? 'selected' : '') ?>>ON</option>
									<option value="0" <?= ($target->is_gateway == '0' ? 'selected' : '') ?>>OFF</option>
								</select>
								<small class="text-danger">Isi OFF jika tidak menggunakan Gateway</small>
							</div>
						</div>
					</div>
					<div class="row" id="form-tripay">
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Channel Code Gateway</label>
								<select class="form-control select2-data" name="gateway_code" id="gateway_code">
									<option value="MANUAL" <?= ($target->gateway_code == 'MANUAL' ? 'selected' : '') ?>>MANUAL</option>
									<optgroup label="MIDTRANS">
										<option value="MIDTRANS" <?= ($target->gateway_code == 'MIDTRANS' ? 'selected' : '') ?>>MIDTRANS SNAP</option>
									</optgroup>
									<optgroup label="PAYDISINI">
										<option value="1" <?= ($target->gateway_code == '1' ? 'selected' : '') ?>>Virtual Account Bank BCA</option>
										<option value="2" <?= ($target->gateway_code == '2' ? 'selected' : '') ?>>Virtual Account Bank BRI</option>
										<option value="3" <?= ($target->gateway_code == '3' ? 'selected' : '') ?>>Virtual Account Bank CIMB</option>
										<option value="4" <?= ($target->gateway_code == '4' ? 'selected' : '') ?>>Virtual Account Bank BNI</option>
										<option value="5" <?= ($target->gateway_code == '5' ? 'selected' : '') ?>>Virtual Account Bank MANDIRI</option>
										<option value="6" <?= ($target->gateway_code == '6' ? 'selected' : '') ?>>Virtual Account Bank Maybank</option>
										<option value="7" <?= ($target->gateway_code == '7' ? 'selected' : '') ?>>Virtual Account Bank Permata</option>
										<option value="8" <?= ($target->gateway_code == '8' ? 'selected' : '') ?>>Virtual Account BANK DANAMON</option>
										<option value="9" <?= ($target->gateway_code == '9' ? 'selected' : '') ?>>Virtual Account BANK BSI</option>
										<option value="10" <?= ($target->gateway_code == '10' ? 'selected' : '') ?>>Virtual Account BANK BNC (Neo Commerce)</option>
										<option value="11" <?= ($target->gateway_code == '11' ? 'selected' : '') ?>>QRIS Merchant PayDisini</option>
										<option value="12" <?= ($target->gateway_code == '12' ? 'selected' : '') ?>>OVO</option>
										<option value="13" <?= ($target->gateway_code == '13' ? 'selected' : '') ?>>DANA</option>
										<option value="14" <?= ($target->gateway_code == '14' ? 'selected' : '') ?>>LINKAJA</option>
										<option value="15" <?= ($target->gateway_code == '15' ? 'selected' : '') ?>>GOPAY</option>
										<option value="16" <?= ($target->gateway_code == '16' ? 'selected' : '') ?>>SHOPEEPAY</option>
										<option value="17" <?= ($target->gateway_code == '17' ? 'selected' : '') ?>>QRIS</option>
										<option value="18" <?= ($target->gateway_code == '18' ? 'selected' : '') ?>>ALFAMART</option>
										<option value="19" <?= ($target->gateway_code == '19' ? 'selected' : '') ?>>INDOMARET</option>
									</optgroup>
									<optgroup label="TRIPAY - Virtual Account">
										<option value="MYBVA" <?= ($target->gateway_code == 'MYBVA' ? 'selected' : '') ?>>Maybank Virtual Account</option>
										<option value="PERMATAVA" <?= ($target->gateway_code == 'PERMATAVA' ? 'selected' : '') ?>>Permata Virtual Account</option>
										<option value="BNIVA" <?= ($target->gateway_code == 'BNIVA' ? 'selected' : '') ?>>BNI Virtual Account</option>
										<option value="BRIVA" <?= ($target->gateway_code == 'BRIVA' ? 'selected' : '') ?>>BRI Virtual Account</option>
										<option value="MANDIRIVA" <?= ($target->gateway_code == 'MANDIRIVA' ? 'selected' : '') ?>>Mandiri Virtual Account</option>
										<option value="BCAVA" <?= ($target->gateway_code == 'BCAVA' ? 'selected' : '') ?>>BCA Virtual Account</option>
										<option value="CIMBVA" <?= ($target->gateway_code == 'CIMBVA' ? 'selected' : '') ?>>CIMB Niaga Virtual Account</option>
										<option value="BSIVA" <?= ($target->gateway_code == 'BSIVA' ? 'selected' : '') ?>>BSI Virtual Account</option>
									</optgroup>
									<optgroup label="TRIPAY - Convenience Store">
										<option value="ALFAMART" <?= ($target->gateway_code == 'ALFAMART' ? 'selected' : '') ?>>Alfamart</option>
										<option value="INDOMARET" <?= ($target->gateway_code == 'INDOMARET' ? 'selected' : '') ?>>Indomaret</option>
										<option value="ALFAMIDI" <?= ($target->gateway_code == 'ALFAMIDI' ? 'selected' : '') ?>>Alfamidi</option>
									</optgroup>
									<optgroup label="TRIPAY - E-Wallet">
										<option value="OVO" <?= ($target->gateway_code == 'OVO' ? 'selected' : '') ?>>OVO</option>
										<option value="QRIS" <?= ($target->gateway_code == 'QRIS' ? 'selected' : '') ?>>QRIS by ShopeePay</option>
										<option value="QRISC" <?= ($target->gateway_code == 'QRISC' ? 'selected' : '') ?>>QRIS (Customizable)</option>
										<option value="QRIS2" <?= ($target->gateway_code == 'QRIS2' ? 'selected' : '') ?>>QRIS</option>
										<option value="DANA" <?= ($target->gateway_code == 'DANA' ? 'selected' : '') ?>>DANA</option>
										<option value="SHOPEEPAY" <?= ($target->gateway_code == 'SHOPEEPAY' ? 'selected' : '') ?>>ShopeePay</option>
									</optgroup>
								</select>
								<small class="text-danger">Pilih MANUAL jika tidak menggunakan Gateway</small>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Intruksi Gateway? <span class="text-danger">*</span></label>
								<select class="form-control select2-data" name="gateway_instruction" id="gateway_instruction">
									<option value="1" <?= ($target->gateway_instruction == '1' ? 'selected' : '') ?>>ON</option>
									<option value="0" <?= ($target->gateway_instruction == '0' ? 'selected' : '') ?>>OFF</option>
								</select>
								<small class="text-danger">Isi ON jika menggunakan instruksi dari Gateway</small>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-2">
								<label class="form-label">Rate <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="rate" value="<?= $target->rate ?>">
							</div>
						</div>
					</div>
					<div class="form-group mb-2" id="manual_instruction">
						<label for="order_request_body" class="form-label">Instruksi Deposit <span class="text-danger">*</span><small class="text-danger"> Opsional</small></label>
						<div class="table-responsive">
							<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="tbl-order-request">
								<thead>
									<tr class="">
										<th>Judul</th>
										<th>Intruksi</th>
										<th>AKSI</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$instruction = $this->deposit_method_instruction_model->get_row(['deposit_method_id' => $target->id]);
									if ($instruction) {

										$title = json_decode($instruction->title, true);
										$instruction_depo = json_decode($instruction->instruction, true);
										for ($i = 0; $i < count($title); $i++) {

									?>

											<tr>
												<td><input type="text" name="title[]" value="<?= $title[$i] ?>" style="width:auto" class="form-control title-key"></td>
												<td><textarea type="text" name="instruction[]" class="form-control classic-editor"><?= $instruction_depo[$i] ?></textarea></td>
												<td>
													<button type="button" class="btn btn-danger btn-sm order-key-remove">
														<i class="fas fa-times-circle mt-1"></i>
													</button>
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td><input type="text" name="title[]" value="" style="width:auto" class="form-control title-key"></td>
											<td><textarea type="text" name="instruction[]" class="form-control classic-editor"></textarea></td>
											<td>
												<button type="button" class="btn btn-danger btn-sm order-key-remove">
													<i class="fas fa-times-circle mt-1"></i>
												</button>
											</td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<button type="button" class="btn btn-primary btn-sm round order-key-add"><i class="fas fa-plus-circle mt-1"></i></button>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Deskripsi <span class="text-danger">*</span></label>
						<textarea class="form-control" name="description"><?= $target->description ?></textarea>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-2">
								<label class="form-label">Minimal Deposit <span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="min_deposit" value="<?= $target->min_deposit ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-2">
								<label class="form-label">Status <span class="text-danger">*</span></label>
								<select class="form-control select2-data" name="status">
									<option value="1" <?= ($target->status == '1' ? 'selected' : '') ?>>ON</option>
									<option value="0" <?= ($target->status == '0' ? 'selected' : '') ?>>OFF</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="hstack gap-1 justify-content-end">
						<button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.order-key-remove').on('click', function() {
			if ($('#tbl-order-request > tbody tr').length > 1) {
				$(this).parents('tr').remove();
			}
		});

		$('.order-key-add').on('click', function() {
			var tr = $('#tbl-order-request tbody tr:last').clone(true, true);
			tr.find('input').val('');

			$(tr).appendTo('#tbl-order-request > tbody');
		});
	});
</script>