<style>
	.star-section {
		display: inline-flex;
		flex-direction: row-reverse;
	}

	.star i.star-btn {
		color: #ccc;
		transition: color 0.2s;
		cursor: pointer;
	}

	.star i.star-btn:hover,
	.star i.star-btn:hover~i.star-btn {
		color: var(--bs-warning) !important;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3 me-1" data-bs-toggle="modal" data-bs-target=".filter-data">
			<i class="fas fa-filter fs-6 me-2"></i>Filter Data
		</a>
		<a href="javascript:;" onclick="modal_open('add', 'lg', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/') ?>')" class="btn btn-primary mb-3 me-1">
			<i class="fas fa-plus-circle fs-6 me-2"></i>Tambah
		</a>
		<a href="javascript:;" onclick="confirm_empty()" class="btn btn-danger mb-3 me-1">
			<i class="fas fa-trash-alt fs-6 me-2"></i>Hapus Semua
		</a>

		<div class="modal fade modal-fade-in-scale-up filter-data" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body pb-0">
						<form class="row">
							<div class="form-group col-md-6">
								<label class="form-label">Kolom Sortir</label>
								<select class="select2-data form-control" name="sort_field">
									<option value="">Kolom...</option>
									<?php foreach ($field as $key => $value) { ?>
										<option value="<?= $key ?>" <?= ($key == $this->input->get('sort_field')) ? 'selected' : '' ?>>
											<?= $value ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="form-label">Tipe Sortir</label>
								<select class="select2-data form-control" name="sort_type">
									<option value="">Tipe...</option>
									<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC</option>
									<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>DESC</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="form-label">Kolom Cari</label>
								<select class="select2-data form-control" name="field">
									<option value="">Kolom...</option>
									<?php foreach ($field as $key => $value) { ?>
										<option value="<?= $key ?>" <?= ($key == $this->input->get('field')) ? 'selected' : '' ?>>
											<?= $value ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="form-label">Operator Cari</label>
								<select class="select2-data form-control" name="operator">
									<option value="">Operator...</option>
									<?php foreach ($operator as $key => $value) { ?>
										<option value="<?= $key ?>" <?= ($key == $this->input->get('operator')) ? 'selected' : '' ?>>
											<?= $value ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="form-label">Kata Kunci Cari</label>
								<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
							</div>
							<hr>
							<div class="form-group col-md-6 d-grid">
								<a href="<?= base_url() ?>admin/service" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
							</div>
							<div class="form-group col-md-6 d-grid">
								<button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<form method="post" action="<?= base_url('admin/' . $this->uri->segment(2) . '/filter') ?>">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group mb-4">
						<div class="input-group">
							<button class="btn btn-secondary" type="button">Filter Kategori</button>
							<span class="form-control" style="padding: 4px;">
								<select class="form-control select2-data" name="service_category">
									<option value="">Semua Kategori</option>
									<?php foreach ($service_category as $value) { ?>
										<option value="<?= $value['id'] ?>" <?= ($this->session->userdata('filter_service_service_category') == $value['id']) ? 'selected' : '' ?>>
											<?= $value['name'] ?>
										</option>
									<?php } ?>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group mb-4">
						<div class="input-group">
							<span class="form-control" style="padding: 4px;">
								<select class="form-control select2-data" name="api">
									<option value="">Semua Provider</option>
									<?php foreach ($api as $value) { ?>
										<option value="<?= $value['id'] ?>" <?= ($this->session->userdata('filter_service_api') == $value['id']) ? 'selected' : '' ?>>
											<?= $value['name'] ?>
										</option>
									<?php } ?>
								</select>
							</span>
							<button class="btn btn-primary" type="submit">Cari</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-tags me-2"></i>Data Layanan</h4>
			</div>
			<div class="card-body pb-4">
				<div class="table-responsive">
					<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0">
						<thead>
							<tr class="text-uppercase">
								<th>PROVIDER</th>
								<th>ID</th>
								<th>PID</th>
								<th>Nama Layanan</th>
								<th>Harga</th>
								<th>Untung</th>
								<th>STATUS</th>
								<th>Rating</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$current_category = '';
							foreach ($table as $value) {
								if ($value['category_name'] != $current_category) {
									echo '<tr><th colspan="9" style="background-color: rgba(var(--bs-primary-rgb), 0.15);">
                                            <h5 class="text-center mb-0"><b>' . $value['category_name'] . '</b></h5>
                                        </th></tr>';
									$current_category = $value['category_name'];
								}
								// Rating Calculation logic remains as per original code
								$count_review = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id']]]]);
								$calculateRating = 0;
								if ($count_review > 0) {
									$countFive = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '5']]]);
									$countFour = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '4']]]);
									$countThree = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '3']]]);
									$countTwo  = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '2']]]);
									$countOne = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '1']]]);
									$calculateRating = $this->lib->calculateRating($countFive, $countFour, $countThree, $countTwo, $countOne);
								}
							?>
								<tr>
									<td><?= $value['api_name'] ?></td>
									<td><?= $value['id'] ?></td>
									<td><?= $value['api_service_id'] ?></td>
									<td>
										<span data-bs-toggle="tooltip" title="<?= $value['name'] ?>">
											<?= (strlen($value['name']) > 40) ? substr($value['name'], 0, 40) . '...' : $value['name'] ?>
										</span>
									</td>
									<td>Rp <?= currency($value['price']) ?></td>
									<td>Rp <?= currency($value['profit']) ?></td>
									<td align="center"><?= switch_status($value['id'], $value['status']) ?></td>
									<td class="text-nowrap star">
										<?php
										if ($count_review > 0) {
											$stars = '';
											for ($i = 5; $i >= 1; $i--) {
												if ($i <= $calculateRating) $stars .= '<i class="fas fa-star text-warning"></i>';
												elseif ($i - 0.5 <= $calculateRating) $stars .= '<i class="fas fa-star-half-alt text-warning"></i>';
												else $stars .= '<i class="fas fa-star text-muted"></i>';
											}
											echo '<div class="star-section">' . $stars . '</div> (' . $calculateRating . '/5)';
										} else {
											echo '<small class="text-muted">No Rating</small>';
										}
										?>
									</td>
									<td align="center">
										<a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/service/detail/' . $value['id']) ?>')" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-search"></i></a>
										<a href="javascript:;" onclick="modal_open('edit', 'lg', '<?= base_url('admin/service/form/' . $value['id']) ?>');" class="btn btn-warning btn-sm" title="Ubah"><i class="fas fa-edit"></i></a>
										<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="align-items-center mt-3 row">
					<div class="col-sm text-center text-sm-start">
						<div class="text-muted"><?= $pagination_links ?></div>
					</div>
					<div class="col-sm-auto text-center">
						<span class="text-muted">
							Menampilkan <?= currency($awal) ?> - <?= ($akhir >= $total_data) ? currency($total_data) : currency($akhir) ?> dari <?= currency($total_data) ?> data.
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Fungsi Hapus Satu per Satu
	function confirm_hapus(id) {
		Swal.fire({
			title: 'Konfirmasi Hapus',
			html: 'Yakin ingin menghapus Layanan <b>#' + id + '</b>?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Batal',
			customClass: { confirmButton: 'btn btn-danger me-1', cancelButton: 'btn btn-secondary' },
			buttonsStyling: false
		}).then((result) => {
			if (result.value) window.location = "<?= base_url() ?>admin/service/delete/" + id
		})
	}

	// Fungsi Hapus Semua (Menjalankan public function empty di Service.php)
	function confirm_empty() {
		Swal.fire({
			title: 'PERINGATAN!',
			html: 'Tindakan ini akan menghapus <b>SELURUH</b> data layanan di database secara permanen!',
			icon: 'error',
			showCancelButton: true,
			confirmButtonText: 'YA, KOSONGKAN SEKARANG!',
			cancelButtonText: 'BATAL',
			customClass: { confirmButton: 'btn btn-danger me-1', cancelButton: 'btn btn-secondary' },
			buttonsStyling: false
		}).then((result) => {
			if (result.value) window.location = "<?= base_url() ?>admin/service/empty"
		})
	}

	// Switch Status Logic
	function switchStatus(elt, id, url) {
		$.ajax({
			url: url,
			type: 'GET',
			beforeSend: function() {
				Swal.fire({ title: 'Memproses...', didOpen: () => { Swal.showLoading() } });
			},
			success: function(data) {
				Swal.fire({
					title: 'Berhasil!',
					text: 'Status layanan berhasil diperbarui.',
					icon: 'success',
					confirmButtonText: 'OK'
				}).then(() => { location.reload(); });
			},
			error: function() {
				Swal.fire({ title: 'Gagal!', text: 'Terjadi kesalahan sistem.', icon: 'error' });
			}
		});
	}
</script>