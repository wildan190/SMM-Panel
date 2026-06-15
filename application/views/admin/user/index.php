<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/form') ?>" class="btn btn-primary mb-3 me-1"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah Data</a>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-user-secret me-2"></i>Data User</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive table-card mb-2">
					<table class="table table-bordered mb-0" id="table-data">
						<thead>
							<tr class="text-uppercase">
								<th>ID</th>
								<th>USERNAME</th>
								<th>FULLNAME</th>
								<th>PHONE</th>
								<th>EMAIL</th>
								<th>SALDO</th>
								<th>LEVEL</th>
								<th>STATUS</th>
								<th>TGL. DIBUAT</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td><?= htmlentities($value['id']) ?></td>
									<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['id']) ?>')"><?= $value['username'] ?></a></td>
									<td><?= htmlentities($value['full_name']) ?></td>
									<td><?= htmlentities($value['whatsapp']) ?></td>
									<td><?= htmlentities($value['email']) ?></td>
									<td>Rp <?= number_format($value['balance'], 0, ',', '.') ?></td>
									<td><?= htmlentities($value['level']) ?></td>
									<td align="center">
										<div class="btn-group">
											<button type="button" class="btn btn-<?= ($value['status'] == '1') ? 'success' : 'danger' ?> btn-sm"><i class="fas fa-<?= ($value['status'] == '1') ? 'check' : 'times' ?>-circle fs-6 me-2"></i><?= ($value['status'] == '1') ? 'Aktif' : 'Non Aktif' ?></button>
											<button class="btn btn-<?= ($value['status'] == '1') ? 'success' : 'danger' ?> btn-sm dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
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
									<td><?= $this->lib->format_date($value['created_at']) ?></td>
									<td align="center">
										<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/form/' . $value['id']) ?>" class="btn btn-sm round btn-warning" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ubah"><i class="fas fa-edit fs-6 me-2"></i>Ubah</a>
										<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-sm round btn-danger" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
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
						<span class="form-label">Total data: <?= $total_data ?></span>
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
								<div class="form-group col-lg-6 mb-2">
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
								<div class="form-group col-lg-6 mb-2">
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
								<hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
								<div class="mb-0">
									<button type="submit" class="btn btn-primary float-end"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
									<a href="<?= base_url() ?>admin/user" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function confirm_hapus(id) {
		Swal.fire({
			title: 'Yakin ingin menghapus Data Pengguna #' + id + '?',
			type: 'question',
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
			if (result.value) window.location = "<?= base_url() ?>admin/user/delete/" + id
		})
	}
</script>