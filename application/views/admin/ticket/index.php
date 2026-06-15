<div class="row">
	<div class="col-sm-12">
		<div class="hstack gap-1 justify-content-end mb-2">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</button>
		</div>
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-headset me-2"></i>Data Tiket</h4>
			</div>
			<div class="card-body pb-4">
				<div class="table-responsive">
					<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="table-data">
						<thead class="text-muted table-light">
							<tr class="">
								<th>ID</th>
								<th>PENGGUNA</th>
								<th>TGL. DIBUAT</th>
								<th>TGL. PEMBARUAN</th>
								<th>TIPE</th>
								<th>SUBJEK</th>
								<th>STATUS</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td>
										<?= $value['id'] ?>
									</td>
									<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['user_id']) ?>')">
											<?= $value['username'] ?>
										</a></td>
									<td>
										<?= $this->lib->tanggal_indonesia($value['created_at']) ?>
									</td>
									<td>
										<?= $this->lib->tanggal_indonesia($value['updated_at']) ?>
									</td>
									<td>
										<?= ($value['type'] === 'order') ? 'Pesanan' : (($value['type'] === 'deposit') ? 'Deposit' : (($value['type'] === 'service') ? 'Layanan' : 'Lainnya')) ?>
									</td>
									<td>
										<?= ($value['is_read_admin'] == '0') ? '<i class="fas fa-bell text-warning"></i>' : '' ?>
										<?= $value['subject'] ?>
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-<?= $this->lib->status_ticket_admin($value['status']) ?> btn-sm">
												<?= $value['status'] ?>
											</button>
											<button class="btn btn-<?= $this->lib->status_ticket_admin($value['status']) ?> btn-sm dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
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
										<a href="<?= base_url('admin/' . $this->uri->segment(2) . '/reply/' . $value['id']) ?>" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Buka Tiket"><i class="fas fa-headset fs-6 me-2"></i>Buka Tiket</a>
										<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
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
							<select class="form-control" name="sort_field">
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
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Tipe Sortir</label>
							<select class="form-control" name="sort_type">
								<option value="">Tipe...</option>
								<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC
								</option>
								<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>
									DESC</option>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kolom Cari</label>
							<select class="form-control" name="field">
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
							<select class="form-control" name="operator">
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
<script type="text/javascript">
	function confirm_hapus(id) {
		Swal.fire({
			title: 'Yakin ingin menghapus Data Tiket #' + id + '?',
			icon: 'warning',
			showCloseButton: true,
			confirmButtonText: 'Yakin',
			confirmButtonColor: '<?= website_config('color_theme') ?>',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			cancelButtonColor: '#e74a3b',
			reverseButtons: true
		}).then((result) => {
			if (result.value) window.location = "<?= base_url() ?>admin/ticket/delete/" + id
		})
	}
</script>