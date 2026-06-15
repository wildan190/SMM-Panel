<div class="row">
					<div class="col-md-12">
       					 <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
						<div class="card">
							<div class="card-header">
								<h4 class="mb-0"><i class="fas fa-history me-2"></i>Data Login Admin</h4>
							</div>
							<div class="card-body">
								<div class="table-responsive table-card mb-2">
									<table class="table table-nowrap table-hover table-bordered table-striped align-middle" id="table-data">
										<thead class="text-muted table-light">
											<tr>
												<th>ID</th>
												<th>ADMIN</th>
												<th>ALAMAT IP</th>
												<th>TANGGAL/WAKTU</th>
											</tr>
										</thead>
										<tbody>
									<?php
									foreach ($table as $key => $value) {
									?>
												<tr>
													<td><?= $value['id'] ?></td>
													<td><?= $value['username'] ?></td>
													<td><?= $value['ip_address'] ?></td>
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
											<span class="text-muted">Total data: <?= $total_data ?></span>
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
									<h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter me-2"></i>Filter Data</h5>
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
								</form><hr>
								<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-cancel fs-6 me-2"></i>Tutup</a>
							</div>
						</div>
					</div>
				</div>
			</div>