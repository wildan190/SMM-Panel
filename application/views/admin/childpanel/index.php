<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0">Data Child Panel</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive table-card mb-1">
					<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="table-data">
						<thead class="text-muted table-light">
							<tr class="text-uppercase">
								<th>PENGGUNA</th>
								<th width="20%">DOMAIN</th>
								<th width="20%">STATUS</th>
								<th width="13%">AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['user_id']) ?>')"><?= $value['username'] ?></a></td>
									<td>
										<?= $value['domain'] ?>
									</td>
									<td align="center">
										<div class="btn-group">
											<button type="button" class="btn btn-<?= $this->lib->status_order_bg($value['status']) ?> btn-sm"> <?= $value['status'] ?></button>
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
										<?php if ($value['status'] == 'Pending') { ?>
											<a href="javascript:;" onclick="modal_open('edit', 'md', '<?= base_url('admin/' . $this->uri->segment(2) . '/confirm/' . $value['id']) ?>')" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Konfirmasi Deposit"><i class="fas fa-check fs-6 me-2"></i>Konfirmasi</a>
										<?php } ?>
									</td>
								</tr>
							<?php
							}
							?>
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
						<span class="text-muted">
							Menampilkan
							<?= currency($awal) ?> sampai
							<?= ($akhir >= $total_data) ? currency($total_data) : currency($akhir) ?> dari
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
						<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</h5>
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
									<button type="submit" class="btn w-100 btn-primary"><i class="fas fa-search fs-6 me-2"></i> Filter</button>
								</div>
							</div>
						</form>
						<hr>
						<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-cancel fs-6 me-2"></i> Tutup</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center"><i class="fa fa-check fa-fw"></i> Konfirmasi Deposit</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" id="modal-edit-body">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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

	function confirm_hapus(id) {
		Swal.fire({
			title: 'Konfirmasi',
			html: 'Yakin ingin menghapus Data Deposit #' + id + '?',
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
			if (result.value) window.location = "<?= base_url() ?>admin/deposit/delete/" + id
		})
	}
</script>