		<div class="row">
			<div class="col-md-12">
				<div class="btn-group flex-wrap mb-4" role="group">
					<a href="<?= base_url() ?>admin/refill" class="btn btn-primary">Semua</a>
					<?php
					foreach ($status as $key => $value) {
					?>
						<a class="btn btn-primary <?= ($this->input->get('status') == $value['name']) ? 'active' : '' ?>" href="<?= base_url() ?>admin/refill?status=<?= $value['name'] ?>"><?= $value['name'] ?></a>
					<?php
					}
					?>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0"><i class="fas fa-recycle"></i> Data Refill Pesanan</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<button type="button" class="btn btn-primary mb-4 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</button>
								<a href="javascript:;" onclick="copy_table('1')" class="btn btn-primary mb-4 me-1"><i class="fas fa-copy fs-6 me-2"></i>Salin 'ID Refill'</a>
								<a href="javascript:;" onclick="copy_table('4')" class="btn btn-primary mb-4 me-1"><i class="fas fa-copy fs-6 me-2"></i>Salin 'Target'</a>
							</div>
						</div>
						<form method="post" action="<?= base_url('admin/' . $this->uri->segment(2) . '/filter') ?>" class="mb-2">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
							<div class="row mb-2">
								<div class="col-md-12">
									<div class="input-group mb-3">
										<span class="form-control" style="padding: 4px;">
											<select class="form-control select2-data" name="status">
												<option value="">Pilih Status</option>
												<?php
												foreach ($status as $key => $value) {
												?>
													<option value="<?= $value['name'] ?>" <?= ($this->session->userdata('filter_order_status') == $value['name']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
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
													<option value="<?= $value['name'] ?>" <?= ($this->session->userdata('filter_order_service') == $value['name']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
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
													<option value="<?= $value['id'] ?>" <?= ($this->session->userdata('filter_order_api') == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
												<?php
												}
												?>
											</select>
										</span>
										<button class="btn btn-primary" type="submit"><i class="fas fa-filter me-2"></i></button>
									</div>
								</div>
							</div>
						</form>
						<div class="table-responsive table-card mb-1">
							<table class="table table-nowrap table-bordered table-striped align-middle" id="table-data">
								<thead class="text-muted table-light">
									<tr class="text-uppercase">
										<th><input class="form-check-input" type="checkbox" id="select-all"></th>
										<th>ID</th>
										<th>ID ORDER</th>
										<th>PENGGUNA</th>
										<th>TARGET</th>
										<th>PROVIDER</th>
										<th>STATUS</th>
										<th>AKSI</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($table as $key => $value) {
									?>
										<tr>
											<td><input type="checkbox" class="form-check-input checkbox" name="data_table[]" value="<?= $value['id'] ?>"></td>
											<td><?= $value['id'] ?></td>
											<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/order/detail/' . $value['order_id']) ?>')" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"><?= $value['order_id'] ?></a></td>
											<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['user_id']) ?>')"><?= $value['user_name'] ?></a></td>
											<td><?= (strlen($value['target']) > 50) ? '' . substr($value['target'], 0, 50) . '...'  : $value['target'] ?></td>
											<td><?= $value['api_name'] ?></td>
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
															<a class="dropdown-item" href="<?= base_url('admin/' . $this->uri->segment(2) . '/status/' . $value['id'] . '/' . $skey) ?>"><?= $svalue['name'] ?></a></li>
														<?php } ?>
													</div>
												</div>
											</td>
											<td>
												<a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/' . $this->uri->segment(2) . '/detail/' . $value['id']) ?>')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"><i class="fas fa-search fs-6 me-2"></i>Detail Data</a>
												<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
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
								<span class="btn btn-blue ">Total data: <?= $total_data ?></span>
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
								<div class="form-group col-lg-4 mb-2">
									<label class="form-label">Kolom Sortir</label>
									<select class="form-control" name="sort_field">
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
									<select class="form-control" name="sort_type">
										<option value="">Tipe...</option>
										<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC</option>
										<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>DESC</option>
									</select>
								</div>
								<div class="form-group col-lg-4 mb-2">
									<label class="form-label">Kolom Cari</label>
									<select class="form-control" name="field">
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
									<select class="form-control" name="operator">
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
									<button type="submit" class="btn w-100 btn-primary"><I class="fas fa-filter fs-6 me-2"></i>Filter</button>
								</div>
							</div>
						</form>
						<hr>
						<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-cancel fs-6 me-2"></i>Tutup</a>
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
			function confirm_hapus(id) {
				Swal.fire({
					title: 'Yakin ingin menghapus Data Pesanan #' + id + '?',
					icon: 'warning',
					showCloseButton: true,
					confirmButtonText: 'Yakin',
					confirmButtonColor: '<?= website_config('color_theme') ?>',
					showCancelButton: true,
					cancelButtonText: 'Batal',
					cancelButtonColor: '#e74a3b',
					reverseButtons: true
				}).then((result) => {
					if (result.value) window.location = "<?= base_url() ?>admin/order/delete/" + id
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
						Swal.fire('Ups!', 'Data yang dipilih (' + total + ') terlalu banyak, maksimal 50 data.', 'error');
					} else {
						document.getElementById("mass-status-form").submit();
					}
				} else {
					Swal.fire('Ups!', 'Tidak ada data untuk diproses.', 'error');
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