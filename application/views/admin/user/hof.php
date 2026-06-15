<div class="row">
	<div class="col-lg-12">
		<form method="get">
			<div class="form-row">
				<div class="form-group col-lg-4">
					<label>Tanggal Awal</label>
					<input type="date" class="form-control" name="start" value="<?= ($this->input->get('start')) ? $this->input->get('start') : date('Y-m-01') ?>">
				</div>
				<div class="form-group col-lg-4">
					<label>Tanggal Akhir</label>
					<input type="date" class="form-control" name="end" value="<?= ($this->input->get('end')) ? $this->input->get('end') : date('Y-m-t') ?>">
				</div>
				<div class="form-group col-lg-4">
					<label class="">Submit</label>
					<button type="submit" class="btn btn-block btn-dark">Filter</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 text-center" style="margin: 20px 0;">
		<h3 class="text-uppercase"><i class="fa fa-trophy fa-fw"></i> 10 Pengguna Teratas <?= $this->lib->format_date($start) ?> sampai <?= $this->lib->format_date($end) ?></h3>
	</div>
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 mb-3 header-title"><i class="fa fa-trophy fa-fw"></i> 10 Pesanan Terbanyak</h4>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>PERINGKAT</th>
								<th>USERNAME</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($order as $key => $value) {
							?>
								<tr class="<?= ($no == 1) ? 'table-warning' : '' ?>">
									<td><?= $no ?></td>
									<td><?= ($no == 1) ? '<span class="badge badge-warning" style="margin-right: 5px;"><i class="mdi mdi-crown"></i></span>' : '' ?><?= $value['username'] ?></td>
									<td>Rp <?= number_format($value['rupiah'], 0, ',', '.') ?> (<?= number_format($value['total'], 0, ',', '.') ?>)</td>
								</tr>
							<?php
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 mb-3 header-title"><i class="fa fa-trophy fa-fw"></i> 10 Deposit Terbanyak</h4>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>PERINGKAT</th>
								<th>USERNAME</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($deposit as $key => $value) {
							?>
								<tr class="<?= ($no == 1) ? 'table-warning' : '' ?>">
									<td><?= $no ?></td>
									<td><?= ($no == 1) ? '<span class="badge badge-warning" style="margin-right: 5px;"><i class="mdi mdi-crown"></i></span>' : '' ?><?= $value['username'] ?></td>
									<td>Rp <?= number_format($value['rupiah'], 0, ',', '.') ?> (<?= number_format($value['total'], 0, ',', '.') ?>)</td>
								</tr>
							<?php
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>