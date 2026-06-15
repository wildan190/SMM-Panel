<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="javascript:;" onclick="modal_open('add', 'md', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/') ?>')" class="btn btn-primary mb-3 me-1"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-cogs me-2"></i>Data API Provider</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped mb-3">
						<thead>
							<tr class="text-uppercase">
								<th>ID</th>
								<th>Provider</th>
								<th>Keterangan</th>
								<th class="text-nowrap">Cronjobs</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td><?= $value['id'] ?></td>
									<td><?= $value['name'] ?></td>
									<td>
										<ul class="ps-3 mb-0">
										    <li><strong>SALDO</strong> => Rp <?= currency($value['balance']) ?></li>
											<li><strong>PROFIT</strong> => <?= ($value['profit_type'] == 'biasa' ? 'FLAT' : 'PERSEN') ?> (<?= ($value['profit_type'] == 'biasa' ? 'Rp ' . currency($value['profit']) . '' : '' . $value['profit'] . '%') ?>)</li>
											<li><strong>MATA UANG</strong> => <?= ($value['kurs'] == 'IDR' ? 'IDR' : 'USD - Rp ' . currency($value['rate'])) ?></li>
										</ul>
									</td>
									<td class="text-nowrap">
										<ul class="ps-3 mb-0">
											<li>Auto Update => <span class="text-danger"><?= ($value['auto_update'] == '1') ? '<span class="text-primary">On</span>' : '<span class="text-danger">Off</span>' ?></span></li>
											<li>Auto Status => <span class="text-danger"><?= ($value['auto_status'] == '1') ? '<span class="text-primary">On</span>' : '<span class="text-danger">Off</span>' ?></span></li>
											<li>Auto Update Nama => <span class="text-danger"><?= ($value['auto_name_service'] == '1') ? '<span class="text-primary">On</span>' : '<span class="text-danger">Off</span>' ?></span></li>
										</ul>
									</td>
									<td class="text-nowrap">
										<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/quick_update/' . $value['id']) ?>" onclick="$.blockUI({ message: '', css: { backgroundColor: 'transparent', border: '0' }, overlayCSS: { backgroundColor: '#fff', opacity: 0.8 } });" class="btn btn-info btn-sm me-1"><i class="fas fa-sync fs-6 me-2"></i>Sync</a>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown"><i class="fas fa-random fs-6 me-2"></i>Parameter</button>
										<div class="dropdown-menu dropdown-menu-end" style="max-height: 200px; overflow: auto;">
											<?php
											$target_balance = $this->api_balance_model->get_row(['api_id' => $value['id']]);
											$target_service = $this->api_service_model->get_row(['api_id' => $value['id']]);
											$target_order = $this->api_order_model->get_row(['api_id' => $value['id']]);
											$target_status = $this->api_status_model->get_row(['api_id' => $value['id']]);
											$target_refill = $this->api_refill_model->get_row(['api_id' => $value['id']]);
											$target_refill_status = $this->api_refill_status_model->get_row(['api_id' => $value['id']]);
											?>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_profile', 'xl', '<?= base_url('admin/api_balance/form/' . ($target_balance == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Profile</a>
											<div role="separator" class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_service', 'xl', '<?= base_url('admin/api_service/form/' . ($target_service == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Service</a>
											<div role="separator" class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_order', 'xl', '<?= base_url('admin/api_order/form/' . ($target_order == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Order</a>
											<div role="separator" class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_status', 'xl', '<?= base_url('admin/api_status/form/' . ($target_status == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Status Order</a>
											<div role="separator" class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_refill', 'xl', '<?= base_url('admin/api_refill/form/' . ($target_refill == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Refill</a>
											<div role="separator" class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:;" onclick="modal_open('api_status_refill', 'xl', '<?= base_url('admin/api_refill_status/form/' . ($target_refill_status == false ? '' : $value['id'])) ?>', '<?= $value['name'] ?>');">Status Refill</a>
										</div>
										<a href="javascript:;" onclick="modal_open('edit', 'md', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/' . $value['id']) ?>');" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit fs-6 me-2"></i>Ubah</a>
										<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>');" class="btn btn-danger btn-sm"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-6 mt-2">
						<?= $this->pagination->create_links() ?>
					</div>
					<div class="col-md-6 hstack justify-content-end">
						<span class="btn btn-primary btn-sm">Total data: <?= $total_data ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade filter-target" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-filter"></i> Filter Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="row">
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kolom Sortir</label>
							<select class="form-control select2-data" name="sort_field">
								<option value="">Kolom...</option>
								<?php
								foreach ($field as $key => $value) {
								?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('sort_field')) ? 'selected' : '' ?>><?= $value ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Tipe Sortir</label>
							<select class="form-control select2-data" name="sort_type">
								<option value="">Tipe...</option>
								<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC</option>
								<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>DESC</option>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kolom Cari</label>
							<select class="form-control select2-data" name="field">
								<option value="">Kolom...</option>
								<?php
								foreach ($field as $key => $value) {
								?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('field')) ? 'selected' : '' ?>><?= $value ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Operator Cari</label>
							<select class="form-control select2-data" name="operator">
								<option value="">Operator...</option>
								<?php
								foreach ($operator as $key => $value) {
								?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('operator')) ? 'selected' : '' ?>><?= $value ?></option>
								<?php
								}
								?>
							</select>
						</div>

						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kata Kunci Cari</label>
							<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Submit</label>
							<button type="submit" class="btn w-100 btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
						</div>
					</div>
				</form>
				<hr>
				<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</a>
			</div>
		</div>
	</div>
</div>
<form id="mass-status-form" method="post" action="<?= base_url() ?>admin/api/setting_service" class="d-none">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
	<input type="hidden" name="list_id" id="mass-status-data">
</form>
<script type="text/javascript">
	function confirm_hapus(id) {
		Swal.fire({
			title: 'Konfirmasi',
			html: 'Yakin ingin menghapus API Provider <b>' + id + '</b> ?',
			icon: 'question',
			showCloseButton: true,
			confirmButtonText: 'Yakin',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			customClass: {
				confirmButton: 'btn btn-primary me-1',
				cancelButton: 'btn btn-danger',
			},
			buttonsStyling: false,
			allowOutsideClick: false,
			allowEscapeKey: false
		}).then((result) => {
			if (result.value) window.location = "<?= base_url() ?>admin/api/delete/" + id
		})
	}

	function copy_table(cell_num) {
		var data = "";
		var i = 1;
		$("#table-data tbody input[type=checkbox]:checked").each(function() {
			var row = $(this).closest("tr")[0];
			if (row.cells[cell_num].innerHTML !== "") {
				data += row.cells[cell_num].innerHTML;
				if ($("#table-data tbody input[type=checkbox]:checked").length > i) {
					data += ",";
				}
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
			Swal.fire('Yeay!', 'Data berhasil disalin.', 'success');
		} else {
			Swal.fire('Ups!', 'Tidak ada data untuk disalin.', 'error');
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

	function mass_status() {
		var data = "";
		var i = 1;
		$("#table-data tbody input[type=checkbox]:checked").each(function() {
			var row = $(this).closest("tr")[0];
			if (row.cells[1].innerHTML !== "") {
				data += row.cells[1].innerHTML;
				if ($("#table-data tbody input[type=checkbox]:checked").length > i) {
					data += ",";
				}
			}
			i++;
		});
		var total = i - 1;
		$('#mass-status-data').val(data);
		if (total > 0) {
			if (total > 50) {
				Swal.fire('Ups!', 'Data yang dipilih (' + total + ') terlalu banyak, maksimal 50 data.', 'error');
			} else {
				document.getElementById("mass-status-form").submit();
			}
		} else {
			Swal.fire('Ups!', 'Tidak ada data untuk diproses.', 'error');
		}
	}
</script>