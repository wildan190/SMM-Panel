<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary bg-gradient mb-3" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="javascript:;" class="btn btn-warning bg-gradient mb-3" data-bs-toggle="modal" data-bs-target=".info-deposit"><i class="fas fa-info-circle fs-6 me-2"></i>Informasi Deposit</a>
		<div class="modal fade info-deposit" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Informasi Deposit</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div <div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary bg-gradient mb-3" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="javascript:;" class="btn btn-warning bg-gradient mb-3" data-bs-toggle="modal" data-bs-target=".info-deposit"><i class="fas fa-info-circle fs-6 me-2"></i>Informasi Deposit</a>
		<div class="modal fade info-deposit" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Informasi Deposit</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning mb-0">
							<h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Untuk Pembayaran
							</h5>
							<div class="alert-body">Jika Kode Pembayaran di Detail Deposit kosong/tidak ada, silahkan
								Klik <b><em>Payment Gateway</em></b>, disana tertera <b><em>Cara Pembayaran</em></b>
								untuk menyelesaikan Deposit.
							</div>
						</div>
					</div>
					<div class="modal-footer p-2">
						<button type="button" class="btn btn-danger bg-gradient" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Deposit</h4>
			</div>
			<div class="card-body pb-4">
				<div class="row">
					<div class="col-12">
						<a href="javascript:;" onclick="copy_id()" class="btn btn-primary bg-gradient mb-4"><i class="fas fa-copy fs-6 me-2"></i>Salin <b><em>ID Deposit</em></b></a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover m-0" id="table-data">
						<thead>
							<tr>
								<th><input class="form-check-input" type="checkbox" id="select-all"></th>
								<th>ID</th>
								<th>METODE DEPOSIT</th>
								<th>KETERANGAN</th>
								<th>STATUS</th>
								<th>PAYMENT</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
								$method = $this->deposit_method_model->get_row(['id' => $value['deposit_method_id']]);
							?>
								<tr>
									<td><input class="form-check-input checkbox" type="checkbox" class="checkbox" value="<?= $value['id'] ?>"></td>
									<td>
										<a href="<?= base_url() ?>/deposit/invoice/<?= $value['id'] ?>"><?= $value['id'] ?></a>
									</td>
									<td>
										<div class="row align-items-center">
											<div class="col-auto pe-0">
												<img src="<?= base_url() ?>uploads/<?= $method->thumbnail_payment ?>" alt="user-image" class="wid-75 hei-25">
											</div>
											<div class="col" style="margin-right: 1rem !important">
												<h6 class="mb-1"><span class="text-truncate w-100">
														<?= $method->name ?>
													</span></h6>
												<p class="text-muted f-12 mb-0"><span class="text-truncate w-100">
														<?= $this->lib->tanggal_indonesia($value['created_at']) ?>
													</span></p>
											</div>
										</div>
									</td>
									<td>
										<div class="row align-items-center">
											<div class="col">
												<p class="f-14 mb-0"><span class="text-truncate">• Jumlah Pembayaran <b>Rp
															<?= number_format($value['amount'], 0, ',', '.') ?>
														</b></span></p>
												<p class="f-14 mb-0"><span class="text-truncate">• Saldo diterima <b>Rp
															<?= number_format($value['balance'], 0, ',', '.') ?>
														</b></span></p>
											</div>
										</div>
									</td>
									<td>
										<?= $this->lib->status_deposit($value['status']) ?>
									</td>
									<td class="text-center">
									    <?php if ($value['status'] == "Pending") { ?>
										    <a href="<?= base_url("deposit/invoice/" . $value['id']) ?>" class="btn btn-sm btn-success bg-gradient" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Bayar">Klik Disini</a>
									    <?php } else { ?>
									        -
									    <?php } ?>
									</td>
									<td>
										<a href="javascript:;" onclick="modal_open('detail_deposit', '<?= base_url('deposit/detail/' . $value['id']) ?>')" class="btn btn-primary bg-gradient btn-sm round" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Detail"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>
										<?php if ($value['status'] == 'Pending') { ?>
											<a href="javascript:;" onclick="modal_open('cancel_deposit', '<?= base_url('deposit/cancel/' . $value['id']) ?>')" class="btn btn-danger bg-gradient btn-sm round" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Batalkan"><i class="fas fa-times-circle fs-6 me-2"></i>Batalkan</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="align-items-center mt-2 row text-center text-sm-start">
					<div class="col-sm mb-2">
						<div class="text-muted">
							<?= $this->pagination->create_links() ?>
						</div>
					</div>
					<div class="col-sm-auto">
						<span class="text-muted">Menampilkan
							<?= currency($awal) ?> sampai
							<?php
							if ($akhir >= $total_data) {
								$akhir_page = $total_data;
							} else {
								$akhir_page = $akhir;
							}
							?>
							<?= currency($akhir_page) ?> dari
							<?= currency($total_data) ?> data.
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade filter-target" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter me-2"></i>Filter Data
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="row">
								<div class="col-md-4 mb-3">
									<label class="form-label">Jumlah Baris</label>
									<select class="form-control select2" name="rows" id="rows">
										<?php
										foreach ($rows as $key => $value) {
										?>
											<option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>>
												<?= $value ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-4 mb-3">
									<label class="form-label">Pilih Status</label>
									<select class="form-control select2" name="status" id="statuss">
										<option value="">Semua</option>
										<?php
										foreach ($status as $key => $value) {
										?>
											<option value="<?= $key ?>" <?= ($this->input->get('status') == $key) ? 'selected' : '' ?>>
												<?= $value ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-4 mb-3">
									<label class="form-label">ID Deposit</label>
									<input type="number" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="Cari ID Deposit">
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<a href="<?= base_url('deposit/history') ?>" class="btn btn-danger bg-gradient"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
						<button type="submit" class="btn btn-primary bg-gradient"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('#rows').on('change', function() {
			var rows = $('#rows').val();
			var status = $('#statuss').val();
			var search = $('#search').val();
			window.location = "<?= base_url('deposit/history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
		});
		$('#statuss').on('change', function() {
			var rows = $('#rows').val();
			var status = $('#statuss').val();
			var search = $('#search').val();
			window.location = "<?= base_url('deposit/history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
		});
	});
</script>
<script>
	function copy(text, elem) {
		var input = document.createElement('textarea');
		input.innerHTML = text;
		document.body.appendChild(input);
		input.select();
		var result = document.execCommand('copy');
		document.body.removeChild(input);

		$(elem).removeClass("uil uil-copy-alt").addClass("uil-file-check-alt").attr("style", "color: <?= website_config('color_theme') ?>;");
		$(elem).attr("title", "Copied!").tooltip("_fixTitle").tooltip("show").attr("title", "Copy to clipboard").tooltip("_fixTitle");

		setTimeout(() => {
			$(elem).removeClass("uil-file-check-alt").addClass("uil uil-copy-alt").removeAttr("style");
		}, 3000);
		// return result;
	}

	$(document).ready(function() {
		CountDownDewek();
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script type="text/javascript">
	function copy_target(element) {
		var copyText = document.getElementById(element);
		copyText.select();
		document.execCommand("copy");
	}

	function copy_id() {
		var data = "";
		var i = 1;
		$("#table-data tbody input[type=checkbox]:checked").each(function() {
			var id = $(this).val();
			data += id;
			if ($("#table-data tbody input[type=checkbox]:checked").length > i) {
				data += ",";
			}
			i++;
		});
		var dummy = document.createElement("textarea");
		document.body.appendChild(dummy);
		dummy.setAttribute("id", "dummy_id");
		document.getElementById("dummy_id").value = data;
		dummy.select();
		document.execCommand("copy");
		document.body.removeChild(dummy);
		if (data.length > 0) {
			Swal.fire({
				title: 'Yeay!',
				icon: 'success',
				html: '<em><b>ID Deposit</b></em> berhasil disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary bg-gradient',
				},
				buttonsStyling: false,
			});
		} else {
			Swal.fire({
				title: 'Ups!',
				icon: 'error',
				html: 'Tidak ada <em><b>ID Deposit</b></em> untuk disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary bg-gradient',
				},
				buttonsStyling: false,
			});
		}
	}

	$('#select-all').on('click', function() {
		if (this.checked) {
			$('.checkbox').each(function() {
				this.checked = true;
			});
		} else {
			$('.checkbox').each(function() {
				this.checked = false;
			});
		}
	});
	$('.checkbox').on('click', function() {
		if ($('.checkbox:checked').length == $('.checkbox').length) {
			$('#select-all').prop('checked', true);
		} else {
			$('#select-all').prop('checked', false);
		}
	});
</script>="modal-body">
						<div class="alert alert-warning mb-0">
							<h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Untuk Pembayaran
							</h5>
							<div class="alert-body">Jika Kode Pembayaran di Detail Deposit kosong/tidak ada, silahkan
								Klik <b><em>Payment Gateway</em></b>, disana tertera <b><em>Cara Pembayaran</em></b>
								untuk menyelesaikan Deposit.
							</div>
						</div>
					</div>
					<div class="modal-footer p-2">
						<button type="button" class="btn btn-danger bg-gradient" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Deposit</h4>
			</div>
			<div class="card-body pb-4">
				<div class="row">
					<div class="col-12">
						<a href="javascript:;" onclick="copy_id()" class="btn btn-primary bg-gradient mb-4"><i class="fas fa-copy fs-6 me-2"></i>Salin <b><em>ID Deposit</em></b></a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover m-0" id="table-data">
						<thead>
							<tr>
								<th><input class="form-check-input" type="checkbox" id="select-all"></th>
								<th>ID</th>
								<th>METODE DEPOSIT</th>
								<th>KETERANGAN</th>
								<th>STATUS</th>
								<th>PAYMENT</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
								$method = $this->deposit_method_model->get_row(['id' => $value['deposit_method_id']]);
							?>
								<tr>
									<td><input class="form-check-input checkbox" type="checkbox" class="checkbox" value="<?= $value['id'] ?>"></td>
									<td>
										<a href="<?= base_url() ?>/deposit/invoice/<?= $value['id'] ?>"><?= $value['id'] ?></a>
									</td>
									<td>
										<div class="row align-items-center">
											<div class="col-auto pe-0">
												<img src="<?= base_url() ?>uploads/<?= $method->thumbnail_payment ?>" alt="user-image" class="wid-75 hei-25">
											</div>
											<div class="col" style="margin-right: 1rem !important">
												<h6 class="mb-1"><span class="text-truncate w-100">
														<?= $method->name ?>
													</span></h6>
												<p class="text-muted f-12 mb-0"><span class="text-truncate w-100">
														<?= $this->lib->tanggal_indonesia($value['created_at']) ?>
													</span></p>
											</div>
										</div>
									</td>
									<td>
										<div class="row align-items-center">
											<div class="col">
												<p class="f-14 mb-0"><span class="text-truncate">• Jumlah Pembayaran <b>Rp
															<?= number_format($value['amount'], 0, ',', '.') ?>
														</b></span></p>
												<p class="f-14 mb-0"><span class="text-truncate">• Saldo diterima <b>Rp
															<?= number_format($value['balance'], 0, ',', '.') ?>
														</b></span></p>
											</div>
										</div>
									</td>
									<td>
										<?= $this->lib->status_deposit($value['status']) ?>
									</td>
									<td class="text-center">
									    <?php if ($value['status'] == "Pending") { ?>
										    <a href="<?= base_url("deposit/invoice/" . $value['id']) ?>" class="btn btn-sm btn-success bg-gradient" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Bayar">Klik Disini</a>
									    <?php } else { ?>
									        -
									    <?php } ?>
									</td>
									<td>
										<a href="javascript:;" onclick="modal_open('detail_deposit', '<?= base_url('deposit/detail/' . $value['id']) ?>')" class="btn btn-primary bg-gradient btn-sm round" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Detail"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>
										<?php if ($value['status'] == 'Pending') { ?>
											<a href="javascript:;" onclick="modal_open('cancel_deposit', '<?= base_url('deposit/cancel/' . $value['id']) ?>')" class="btn btn-danger bg-gradient btn-sm round" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Batalkan"><i class="fas fa-times-circle fs-6 me-2"></i>Batalkan</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="align-items-center mt-2 row text-center text-sm-start">
					<div class="col-sm mb-2">
						<div class="text-muted">
							<?= $this->pagination->create_links() ?>
						</div>
					</div>
					<div class="col-sm-auto">
						<span class="text-muted">Menampilkan
							<?= currency($awal) ?> sampai
							<?php
							if ($akhir >= $total_data) {
								$akhir_page = $total_data;
							} else {
								$akhir_page = $akhir;
							}
							?>
							<?= currency($akhir_page) ?> dari
							<?= currency($total_data) ?> data.
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade filter-target" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter me-2"></i>Filter Data
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="row">
								<div class="col-md-4 mb-3">
									<label class="form-label">Jumlah Baris</label>
									<select class="form-control select2" name="rows" id="rows">
										<?php
										foreach ($rows as $key => $value) {
										?>
											<option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>>
												<?= $value ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-4 mb-3">
									<label class="form-label">Pilih Status</label>
									<select class="form-control select2" name="status" id="statuss">
										<option value="">Semua</option>
										<?php
										foreach ($status as $key => $value) {
										?>
											<option value="<?= $key ?>" <?= ($this->input->get('status') == $key) ? 'selected' : '' ?>>
												<?= $value ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-4 mb-3">
									<label class="form-label">ID Deposit</label>
									<input type="number" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="Cari ID Deposit">
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<a href="<?= base_url('deposit/history') ?>" class="btn btn-danger bg-gradient"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
						<button type="submit" class="btn btn-primary bg-gradient"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('#rows').on('change', function() {
			var rows = $('#rows').val();
			var status = $('#statuss').val();
			var search = $('#search').val();
			window.location = "<?= base_url('deposit/history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
		});
		$('#statuss').on('change', function() {
			var rows = $('#rows').val();
			var status = $('#statuss').val();
			var search = $('#search').val();
			window.location = "<?= base_url('deposit/history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
		});
	});
</script>
<script>
	function copy(text, elem) {
		var input = document.createElement('textarea');
		input.innerHTML = text;
		document.body.appendChild(input);
		input.select();
		var result = document.execCommand('copy');
		document.body.removeChild(input);

		$(elem).removeClass("uil uil-copy-alt").addClass("uil-file-check-alt").attr("style", "color: <?= website_config('color_theme') ?>;");
		$(elem).attr("title", "Copied!").tooltip("_fixTitle").tooltip("show").attr("title", "Copy to clipboard").tooltip("_fixTitle");

		setTimeout(() => {
			$(elem).removeClass("uil-file-check-alt").addClass("uil uil-copy-alt").removeAttr("style");
		}, 3000);
		// return result;
	}

	$(document).ready(function() {
		CountDownDewek();
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script type="text/javascript">
	function copy_target(element) {
		var copyText = document.getElementById(element);
		copyText.select();
		document.execCommand("copy");
	}

	function copy_id() {
		var data = "";
		var i = 1;
		$("#table-data tbody input[type=checkbox]:checked").each(function() {
			var id = $(this).val();
			data += id;
			if ($("#table-data tbody input[type=checkbox]:checked").length > i) {
				data += ",";
			}
			i++;
		});
		var dummy = document.createElement("textarea");
		document.body.appendChild(dummy);
		dummy.setAttribute("id", "dummy_id");
		document.getElementById("dummy_id").value = data;
		dummy.select();
		document.execCommand("copy");
		document.body.removeChild(dummy);
		if (data.length > 0) {
			Swal.fire({
				title: 'Yeay!',
				icon: 'success',
				html: '<em><b>ID Deposit</b></em> berhasil disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary bg-gradient',
				},
				buttonsStyling: false,
			});
		} else {
			Swal.fire({
				title: 'Ups!',
				icon: 'error',
				html: 'Tidak ada <em><b>ID Deposit</b></em> untuk disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary bg-gradient',
				},
				buttonsStyling: false,
			});
		}
	}

	$('#select-all').on('click', function() {
		if (this.checked) {
			$('.checkbox').each(function() {
				this.checked = true;
			});
		} else {
			$('.checkbox').each(function() {
				this.checked = false;
			});
		}
	});
	$('.checkbox').on('click', function() {
		if ($('.checkbox:checked').length == $('.checkbox').length) {
			$('#select-all').prop('checked', true);
		} else {
			$('#select-all').prop('checked', false);
		}
	});
</script>