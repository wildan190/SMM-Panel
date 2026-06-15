<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="far fa-comments me-2"></i>Data Tiket</h4>
			</div>
			<div class="card-body pb-4">

				<form>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<div class="input-group">
									<button class="btn btn-primary" type="button">Baris</button>
									<select class="form-control" name="rows" id="rows">
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
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<div class="input-group">
									<button class="btn btn-primary" type="button">Status</button>
									<select class="form-control" name="status" id="statuss">
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
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<div class="input-group">
									<input type="text" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="Cari ID Tiket">
									<button class="btn btn-primary" type="submit">Cari</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
						<thead>
							<tr class="text-uppercase">
								<th>ID</th>
								<th class="text-nowrap">Tgl. Dibuat</th>
								<th class="text-nowrap">Tgl. Pembaruan</th>
								<th>Tipe</th>
								<th>Subjek</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php
							foreach ($table as $key => $value) {
							?>
								<tr>
									<td>
										<?= ($value['id']) ?>
									</td>
									<td>
										<?= $this->lib->Tanggal_indonesia($value['created_at']) ?>
									</td>
									<td>
										<?= $this->lib->Tanggal_indonesia($value['updated_at']) ?>
									</td>
									<td>
										<?= ($value['type'] === 'order') ? 'Pesanan' : (($value['type'] === 'deposit') ? 'Deposit' : (($value['type'] === 'service') ? 'Layanan' : 'Lainnya')) ?>

									</td>
									<td>
										<?= ($value['is_read_user'] == '0') ? '<i class="fas fa-bell text-warning"></i>' : '' ?>
										<?= $value['subject'] ?>
									</td>
									<td class="text-nowrap">
										<?= $this->lib->status_ticket($value['status']) ?>
									</td>
									<td class=" text-nowrap"><a href="<?= base_url('ticket/reply/' . $value['id'] . '/' . $this->security->get_csrf_hash() . '') ?>" class="btn btn-primary btn-sm round"><i class="fas fa-folder-open fs-6 me-2"></i>Buka Tiket</a></td>
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
							<?= $pagination_links ?>
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