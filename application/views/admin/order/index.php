<div class="row">
	<div class="col-md-12">
		<div class="card-body p-2" style="margin-bottom: -4px;">
			<div class="row gx-1">
				<div class="col-4 col-md-4 col-lg-2 col-xl-2 d-grid mb-1">
					<a href="<?= base_url() ?>admin/order" class="p-2 btn btn-outline-primary <?= (!$this->input->get('status')) ? 'active' : '' ?>">Semua</a>
				</div>
				<?php
				foreach ($status as $key => $value) {
					if ($value['name'] == 'Pending') {
						$color = 'warning';
					} elseif ($value['name'] == 'Processing') {
						$color = 'info';
					} elseif ($value['name'] == 'Success') {
						$color = 'success';
					} else {
						$color = 'danger';
					}
				?>
					<div class="col-4 col-md-4 col-lg-2 col-xl-2 d-grid mb-1">
						<a href="<?= base_url() ?>admin/order?status=<?= $value['name'] ?>" class="p-2 btn btn-outline-<?= $color ?> <?= ($this->input->get('status') == $value['name']) ? 'active' : '' ?>"><?= $value['name'] ?></a>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i> Data Pesanan</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<button type="button" class="btn btn-primary mb-4 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</button>
						<a href="javascript:;" onclick="copy_table('1')" class="btn btn-primary mb-4 me-1"><i class="fas fa-copy fs-6 me-2"></i>Salin 'ID Pesanan'</a>
						<a href="javascript:;" onclick="copy_table('4')" class="btn btn-primary mb-4 me-1"><i class="fas fa-copy fs-6 me-2"></i>Salin 'Target'</a>
						<a href="javascript:;" onclick="mass_status()" class="btn btn-primary mb-4 me-1"><i class="fas fa-pencil fs-6 me-2"></i>Ubah Massal</a>
					</div>
				</div>
				<form method="post" action="<?= base_url('admin/' . $this->uri->segment(2) . '/filter') ?>" class="mb-2">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="row mb-2">
						<div class="col-md-12">
							<div class="input-group">
								<span class="form-control" style="padding: 4px;">
									<select class="form-control select2-data" name="status">
										<option value="">Pilih Status</option>
										<?php
										foreach ($status as $key => $value) {
										?>
											<option value="<?= $value['name'] ?>" <?= ($this->session->userdata('filter_order_status') == $value['name']) ? 'selected' : '' ?>>
												<?= $value['name'] ?>
											</option>
										<?php
										}
										?>
									</select>
								</span>
								<span class="form-control" style="padding: 4px;">
									<select class="form-control select2-data" name="service">
										<option value="">Pilih Layanan</option>
										<?php
										foreach ($service as $key => $value) {
										?>
											<option value="<?= $value['id'] ?>" <?= ($this->session->userdata('filter_order_service') == $value['id']) ? 'selected' : '' ?>>
												<?= $value['name'] ?>
											</option>
										<?php
										}
										?>
									</select>
								</span>
								<span class="form-control" style="padding: 4px;">
									<select class="form-control select2-data" name="api">
										<option value="">Pilih API</option>
										<?php
										foreach ($api as $key => $value) {
										?>
											<option value="<?= $value['id'] ?>" <?= ($this->session->userdata('filter_order_api') == $value['id']) ? 'selected' : '' ?>>
												<?= $value['name'] ?>
											</option>
										<?php
										}
										?>
									</select>
								</span>
								<button class="btn btn-primary" type="submit"><i class="fas fa-filter me-2"></i>
									Filter</button>
							</div>
						</div>
					</div>
				</form>
				<div class="table-responsive table-card mb-1">
					<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="table-data">
						<thead class="text-muted table-light">
							<tr class="text-uppercase">
								<th><input class="form-check-input" type="checkbox" id="select-all"></th>
								<th>ID</th>
								<th>PENGGUNA</th>
								<th>LAYANAN</th>
								<th>TARGET PESANAN</th>
								<th>JUMLAH</th>
								<th>HARGA</th>
								<th>PROFIT</th>
								<th>SUMBER</th>
								<th>STATUS</th>
								<th>TGL. DIBUAT</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
								$tgl_sekarang = new DateTime(date('Y-m-d H:i:s'));
								$tgl_lalu = new DateTime($value['next_refill']);

								if ($tgl_lalu->diff($tgl_sekarang)->format('%a') == 0) {
									$average = $tgl_lalu->diff($tgl_sekarang)->format('%h jam, %i menit.');
								} elseif ($tgl_lalu->diff($tgl_sekarang)->format('%h') == 0) {
									$average = $tgl_lalu->diff($tgl_sekarang)->format('%i menit.');
								} else {
									$average = $tgl_lalu->diff($tgl_sekarang)->format('%a hari, %h jam, %i menit.');
								}
							?>
								<tr>
									<td><input type="checkbox" class="form-check-input checkbox" name="data_table[]" value="<?= $value['id'] ?>"></td>
									<td>
										<?= $value['id'] ?>
									</td>
									<td>
										<a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['user_id']) ?>');">
											<?= $value['username'] ?>
										</a>
									</td>
									<td>
										<span data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="<?= $value['service'] ?>">
											<?= (strlen($value['service']) > 35) ? substr($value['service'], 0, 35) . '...' : $value['service'] ?>
										</span>
									</td>
									<td>
										<div class="input-group">
											<input type="text" class="form-control form-control-sm" value="<?= $value['target'] ?>" disabled>
											<a href="javascript:;" class="btn btn-primary btn-sm" onclick="copy_text('Target', '<?= $value['target'] ?>');"><i class="fas fa-copy me-2"></i></a>
										</div>
									</td>
									<td>
										<?= number_format($value['quantity'], 0, ',', '.') ?>
									</td>
									<td>Rp
										<?= number_format($value['price'], 0, ',', '.') ?>
									</td>
									<td>Rp
										<?= number_format($value['profit'], 0, ',', '.') ?>
									</td>
									<td>
										<?= ($value['is_api'] == '1') ? 'API' : 'WEB' ?>
									</td>
									<td align="center">
										<div class="btn-group">
											<?= $this->lib->status_order_admin($value['status']) ?>
											<button class="btn btn-<?= $this->lib->status_order_bg($value['status']) ?> btn-sm dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
												<i class="fas fa-edit fs-6"></i>
											</button>
											<div class="dropdown-menu">
												<?php
												foreach ($status as $skey => $svalue) {
												?>
													<a class="dropdown-item" href="<?= base_url('admin/' . $this->uri->segment(2) . '/status/' . $value['id'] . '/' . $skey) ?>">
														<?= $svalue['name'] ?>
													</a></li>
												<?php } ?>
											</div>
										</div>
									</td>
									<td>
										<?= $this->lib->tanggal_indonesia($value['created_at']) ?>
									</td>
									<td>
										<a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/' . $this->uri->segment(2) . '/detail/' . $value['id']) ?>')" class="btn btn-sm btn-primary btn-sm round me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>
										<a href="javascript:;" onclick="modal_open('edit', 'md', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/' . $value['id']) ?>')" class="btn btn-sm btn-warning btn-sm round me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ubah"><i class="fas fa-edit fs-6 me-2"></i>Ubah</a>
										<a href="<?= (time() > strtotime($value['next_refill'])) ? '' . base_url('admin/' . $this->uri->segment(2) . '/refill/' . $value['id'] . '/' . $this->security->get_csrf_hash() . '') . '' : 'javascript:;' ?>" <?= (time() < strtotime($value['next_refill']) ? 'data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Refill akan tersedia dalam ' . $average . '"' : '') ?> class="btn btn-<?= (time() > strtotime($value['next_refill'])) ? 'success' : 'danger' ?> btn-sm round <?= ($value['is_refill'] == 1) ? '' : 'disabled' ?>"><i class="fas fa-recycle fs-6 me-2"></i>Refill</a>
										<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-sm btn-danger btn-sm round me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
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
						<span class="text-primary">Total data:
							<?= $total_data ?>
						</span>
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
				<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter fs-6 me-2"></i> Filter Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="row">
						<div class="form-group col-lg-6 mb-2">
							<label class="form-label">Kolom Sortir</label>
							<select class="form-control select2-data" name="sort_field">
								<option value="">Kolom...</option>
								<?php
								foreach ($field as $key => $value) {
								?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('sort_field')) ? 'selected' : '' ?>>
										<?= $value ?>
									</option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-6 mb-2">
							<label class="form-label">Tipe Sortir</label>
							<select class="form-control select2-data" name="sort_type">
								<option value="">Tipe...</option>
								<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC
								</option>
								<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>
									DESC</option>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kolom Cari</label>
							<select class="form-control select2-data" name="field">
								<option value="">Kolom...</option>
								<?php
								foreach ($field as $key => $value) {
								?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('field')) ? 'selected' : '' ?>>
										<?= $value ?>
									</option>
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
									<option value="<?= $key ?>" <?= ($key == $this->input->get('operator')) ? 'selected' : '' ?>>
										<?= $value ?>
									</option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kata Kunci Cari</label>
							<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
						</div>
						<hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
						<div class="mb-0">
							<button type="submit" class="btn btn-primary float-end"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
							<a href="<?= base_url() ?>admin/order" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<form id="mass-status-form" method="post" action="<?= base_url() ?>admin/order/mass_edit" class="d-none">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
	<input type="hidden" name="list_id" id="mass-status-data">
</form>
<script type="text/javascript">
	function copy_target(element) {
		var copyText = document.getElementById(element);
		copyText.select();
		document.execCommand("copy");
	}

	function confirm_hapus(id) {
		Swal.fire({
			title: 'Yakin ingin menghapus Data Pesanan #' + id + '?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yakin',
			cancelButtonText: 'Batal',
			customClass: {
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-danger',
			},
			buttonsStyling: false,
			allowOutsideClick: false,
			allowEscapeKey: false
		}).then((result) => {
			if (result.value) window.location = "<?= base_url() ?>admin/order/delete/" + id
		})
	}

	function copy_table(cell_num) {
		var data = "";
		var i = 1;

		$("#table-data tbody input[type=checkbox]:checked").each(function() {
			var row = $(this).closest("tr")[0];
			var cellValue = "";

			// Cek apakah sel berisi input
			var inputElement = row.cells[cell_num].querySelector('input');
			if (inputElement) {
				cellValue = inputElement.value;
			} else {
				cellValue = decodeURIComponent(row.cells[cell_num].innerText.trim());
			}

			if (cellValue !== "") {
				data += cellValue;
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
			Swal.fire({
				title: 'Yeay!',
				icon: 'success',
				html: 'Data berhasil disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary',
				},
				buttonsStyling: false,
			});
		} else {
			Swal.fire({
				title: 'Ups!',
				icon: 'error',
				html: 'Tidak ada data untuk disalin.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary',
				},
				buttonsStyling: false,
			});
		}
	}


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
				Swal.fire({
					title: 'Ups!',
					icon: 'error',
					html: 'Data yang dipilih (' + total + ') terlalu banyak, maksimal 50 data.',
					confirmButtonText: 'Okay',
					customClass: {
						confirmButton: 'btn btn-primary',
					},
					buttonsStyling: false,
				});
			} else {
				document.getElementById("mass-status-form").submit();
			}
		} else {
			Swal.fire({
				title: 'Ups!',
				icon: 'error',
				html: 'Tidak ada data untuk diproses.',
				confirmButtonText: 'Okay',
				customClass: {
					confirmButton: 'btn btn-primary',
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
<script type="text/javascript">
	function edit(url) {
		$.ajax({
			type: "GET",
			url: url,
			beforeSend: function() {
				$('#modal-edit-body').html('Sedang memuat...');
			},
			success: function(result) {
				$('#modal-edit-body').html(result);
			},
			error: function() {
				$('#modal-edit-body').html('Terjadi kesalahan.');
			}
		});
		$('#modal-edit').modal();
	}
</script>