	<div class="row">
		<div class="col-md-12">
			<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
			<div class="card">
				<div class="card-header">
					<h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data</h4>
				</div>
				<div class="card-body pb-4">
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
						<div class="form-group mb-2">
							<label class="form-label">Thumbnail <span class="text-danger">*</span></label>
							<input type="file" class="form-control" name="thumbnail" value="">
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Nama <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" value="<?= set_value('name') ?>">
						</div>
						<div class="form-group mb-2">
							<label class="form-label">No Rekening/HP <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="number_account" value="<?= set_value('number_account') ?>">
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Atas Nama <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name_account" value="<?= set_value('name_account') ?>">
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group mb-2">
									<label class="form-label">Tipe <span class="text-danger">*</span></label>
									<select class="form-control select2-data" name="type">
										<option value="tripay">Tripay</option>
										<option value="paydisini">Paydisini</option>
										<option value="midtrans">Midtrans</option>
										<option value="manual">Manual</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-2">
									<label class="form-label">Kategori <span class="text-danger">*</span></label>
									<select class="form-control select2-data" name="category">
										<option value="qris">QRIS</option>
										<option value="bank">BANK</option>
										<option value="pulsa">PULSA</option>
										<option value="virtual_account">VIRTUAL ACCOUNT</option>
										<option value="mini_market">MINI MARKET</option>
										<option value="ewallet">E-WALLET</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-2">
									<label class="form-label">Gateway? <span class="text-danger">*</span></label>
									<select class="form-control select2-data" name="gateway" id="gateway">
										<option value="1">ON</option>
										<option value="0">OFF</option>
									</select>
									<small class="text-danger">Isi OFF jika tidak menggunakan Gateway</small>
								</div>
							</div>
						</div>
						<div class="row" id="form-gateway">
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-label">Channel Code Gateway <span class="text-danger">*</span></label>
									<select class="form-control select2-data" name="gateway_code" id="gateway_code">
										<option value="MANUAL">MANUAL</option>
										<optgroup label="MIDTRANS">
											<option value="MIDTRANS">MIDTRANS SNAP</option>
										</optgroup>
										<optgroup label="PAYDISINI">
											<option value="1">Virtual Account Bank BCA</option>
											<option value="2">Virtual Account Bank BRI</option>
											<option value="3">Virtual Account Bank CIMB</option>
											<option value="4">Virtual Account Bank BNI</option>
											<option value="5">Virtual Account Bank MANDIRI</option>
											<option value="6">Virtual Account Bank Maybank</option>
											<option value="7">Virtual Account Bank Permata</option>
											<option value="8">Virtual Account BANK DANAMON</option>
											<option value="9">Virtual Account BANK BSI</option>
											<option value="10">Virtual Account BANK BNC (Neo Commerce)</option>
											<option value="11">QRIS Merchant PayDisini</option>
											<option value="12">OVO</option>
											<option value="13">DANA</option>
											<option value="14">LINKAJA</option>
											<option value="15">GOPAY</option>
											<option value="16">SHOPEEPAY</option>
											<option value="17">QRIS</option>
											<option value="18">ALFAMART</option>
											<option value="19">INDOMARET</option>
										</optgroup>
										<optgroup label="TRIPAY - Virtual Account">
											<option value="MYBVA">Maybank Virtual Account</option>
											<option value="PERMATAVA">Permata Virtual Account</option>
											<option value="BNIVA">BNI Virtual Account</option>
											<option value="BRIVA">BRI Virtual Account</option>
											<option value="MANDIRIVA">Mandiri Virtual Account</option>
											<option value="BCAVA">BCA Virtual Account</option>
											<option value="CIMBVA">CIMB Niaga Virtual Account</option>
											<option value="BSIVA">BSI Virtual Account</option>
										</optgroup>
										<optgroup label="TRIPAY - Convenience Store">
											<option value="ALFAMART">Alfamart</option>
											<option value="INDOMARET">Indomaret</option>
											<option value="ALFAMIDI">Alfamidi</option>
										</optgroup>
										<optgroup label="TRIPAY - E-Wallet">
											<option value="OVO">OVO</option>
											<option value="QRIS">QRIS by ShopeePay</option>
											<option value="QRISC">QRIS (Customizable)</option>
											<option value="QRIS2">QRIS</option>
											<option value="DANA">DANA</option>
											<option value="SHOPEEPAY">ShopeePay</option>
										</optgroup>
									</select>
									<small class="text-danger">Pilih MANUAL jika tidak menggunakan Gateway</small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-label">Intruksi Gateway? <span class="text-danger">*</span></label>
									<select class="form-control select2-data" name="gateway_instruction">
										<option value="1">ON</option>
										<option value="0">OFF</option>
									</select>
									<small class="text-danger">Isi ON jika menggunakan instruksi dari Gateway</small>
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="order_request_body" class="form-label">Instruksi Deposit <span class="text-danger">*</span><small class="text-danger"> Opsional</small></label>
							<div class="table-responsive">
								<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="tbl-order-request">
									<thead>
										<tr class="">
											<th>Judul</th>
											<th>Intruksi</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="text" name="title[]" class="form-control title-key"></td>
											<td><textarea type="text" name="instruction[]" class="form-control classic-editor"></textarea></td>
											<td>
												<button type="button" class="btn btn-danger btn-sm order-key-remove">
													<i class="fas fa-times-circle mt-1"></i>
												</button>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">
												<button type="button" class="btn btn-primary btn-sm order-key-add">
													<i class="fas fa-plus-circle mt-1"></i>
												</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Deskripsi <span class="text-danger">*</span></label>
							<textarea class="form-control" name="description"></textarea>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-label">Minimal Deposit <span class="text-danger">*</span></label>
									<input type="number" class="form-control" name="min_deposit" value="<?= set_value('min_deposit') ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-label">Rate <span class="text-danger">*</span></label>
									<input type="number" class="form-control" name="rate" value="<?= (set_value('rate')) ? set_value('rate') : '1' ?>">
								</div>
							</div>
						</div>
						<hr>
						<div class="hstack gap-1 justify-content-end">
							<button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
							<button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
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
				tr.find('input').html('');

				$(tr).appendTo('#tbl-order-request > tbody');
			});
		});
	</script>