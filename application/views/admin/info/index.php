<div class="row">
					<div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="<?= base_url('admin/'.$this->uri->segment(2).'/form') ?>" class="btn btn-primary mb-3 me-1"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah Data</a>
						<div class="card">
							<div class="card-header">
								<h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Data Berita & Informasi</h4>
							</div>
							<div class="card-body">
								<div class="table-responsive table-card mb-2">
									<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0" id="table-data">
										<thead class="text-muted table-light">
											<tr class="">
												<th>ID</th>
												<th width="10%">KATEGORI</th>
												<th>KONTEN</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>
									<?php
									foreach ($table as $key => $value) {
									?>
												<tr>
													<td><?= $value['id'] ?></td>
													<td><span class="badge round bg-<?= $this->lib->status_info_bg($value['category']) ?>"><?= strtoupper($value['category']) ?></td>
													<td><?= substr(htmlentities($value['content']),0,50) ?><?= (strlen(htmlentities($value['content'])) > 51) ? '...' : '' ?></td>
													<td>
														<a href="<?= base_url('admin/'.$this->uri->segment(2).'/form/'.$value['id']) ?>" class="btn btn-sm btn-warning round me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ubah"><i class="fas fa-edit fs-6 me-2"></i>Ubah</a>
														<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="btn btn-sm btn-danger round me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus"><i class="fas fa-trash fs-6 me-2"></i>Hapus</a>
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
										<span class="btn btn-primary btn-sm round me-1">Total data: <?= $total_data ?></span>
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
											<button type="submit" class="btn w-100 btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
										</div>
									</div>
								</form><hr>
								<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</a>
						</div>
					</div>
				</div>
			</div>
<script type="text/javascript">
function confirm_hapus(id) {
	Swal.fire({
		title: 'Yakin ingin menghapus Data Informasi #' + id + '?',
		icon: 'warning',
		type: 'question',
		showCloseButton: true,
		confirmButtonText: 'Yakin',
		showCancelButton: true,
		cancelButtonText: 'Batal',
		customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-danger',
                },
        buttonsStyling: false,
        allowOutsideClick: false,
         allowEscapeKey: false
	}).then((result) => {
		if (result.value) window.location = "<?= base_url() ?>admin/info/delete/" + id
	})
}
</script>