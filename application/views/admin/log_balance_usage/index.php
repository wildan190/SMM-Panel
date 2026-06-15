<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<div class="modal fade filter-target" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter me-2"></i> Filter Data</h5>
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
								<div class="form-group col-lg-6 mb-2">
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
								<div class="form-group col-lg-6 mb-2">
									<label class="form-label">Kata Kunci Cari</label>
									<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
								</div>
								<hr>

								<div class="form-group col-md-6 d-grid">
									<a href="<?= base_url() ?>admin/log_balance_usage" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
								</div>
								<div class="form-group col-md-6 d-grid">
									<button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card bg-success available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-success) !important;">
					<div class="card-body p-3">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="mb-0 text-white text-opacity-75">Kredit (CR)</p>
								<h4 class="mb-0 text-white">Rp <?= number_format($widget['plus'][0]['rupiah'], 0, ',', '.') ?> (<?= number_format($widget['plus'][0]['total'], 0, ',', '.') ?>)</h4>
							</div>
							<div class="avtar">
								<i class="fas fa-plus-square f-18"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card bg-danger available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-danger) !important;">
					<div class="card-body p-3">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="mb-0 text-white text-opacity-75">Debit (DB)</p>
								<h4 class="mb-0 text-white">Rp <?= number_format($widget['minus'][0]['rupiah'], 0, ',', '.') ?> (<?= number_format($widget['minus'][0]['total'], 0, ',', '.') ?>)</h4>
							</div>
							<div class="avtar">
								<i class="fas fa-minus-square f-18"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-history me-2"></i>Mutasi Saldo Penggguna</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive table-card mb-2">
					<table class="table table-nowrap table-hover table-bordered table-striped align-middle" id="table-data">
						<thead>
							<tr class="">
								<th>ID</th>
								<th>PENGGUNA</th>
								<th>KATEGORI</th>
								<th>JUMLAH</th>
								<th>DESKRIPSI</th>
								<th>Saldo Awal</th>
								<th>Saldo Akhir</th>
								<th>TANGGAL/WAKTU</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td><?= $value['id'] ?></td>
									<td><a href="javascript:;" onclick="modal_open('detail', 'lg', '<?= base_url('admin/user/detail/' . $value['user_id']) ?>')"><?= $value['username'] ?></a></td>
									<td><?= strtoupper($value['category']) ?></td>
									<td>
										<?= ($value['type'] == 'plus') ? '+ Rp ' . number_format($value['amount'], 0, ',', '.') . ' <span class="badge bg-light-success">CR</span>' : '- Rp ' . number_format($value['amount'], 0, ',', '.') . ' <span class="badge bg-light-danger">DB</span>' ?>
									</td>
									<td><?= $value['description'] ?></td>
									<td>Rp <?= number_format($value['before'], 0, ',', '.') ?></td>
									<td>Rp <?= number_format($value['after'], 0, ',', '.') ?></td>
									<td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
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
						<span class="btn btn-blue ">Total data: <?= currency($total_data) ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>