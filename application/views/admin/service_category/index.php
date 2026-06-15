<div class="row">
	<div class="col-md-12">
		<a href="javascript:;" class="btn btn-primary mb-3 me-1" data-bs-toggle="modal" data-bs-target=".filter-target"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
		<a href="javascript:;" onclick="modal_open('add', 'lg', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/') ?>')" class="btn btn-primary mb-3 me-1"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</a>
		
		<a href="javascript:;" onclick="confirm_all()" class="btn btn-danger mb-3 me-1">
			<i class="fas fa-trash-alt fs-6 me-2"></i>Hapus Semua Kategori
		</a>

		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="fas fa-tags me-2"></i>Data Kategori</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive table-card mb-2">
					<table class="table table-bordered" id="table-data">
						<thead class="text-muted table-light">
							<tr class="">
								<th>ID</th>
								<th>NAMA</th>
								<th>PLATFORM</th>
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
									<td>
										<?= $value['name'] ?>
									</td>
									<td>
										<span class="badge bg-soft-primary text-primary"><?= $value['type_category'] ?></span>
									</td>
									<td class="text-center">
										<div class="hstack gap-1 justify-content-center">
											<a href="javascript:;" onclick="modal_open('edit', 'lg', '<?= base_url('admin/' . $this->uri->segment(2) . '/form/' . $value['id']) ?>')" class="btn btn-soft-warning btn-sm" data-bs-toggle="tooltip" title="Ubah"><i class="fas fa-edit fs-6"></i></a>
											<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>', '<?= base_url('admin/' . $this->uri->segment(2) . '/delete/' . $value['id']) ?>')" class="btn btn-soft-danger btn-sm" data-bs-toggle="tooltip" title="Hapus"><i class="fas fa-trash-alt fs-6"></i></a>
										</div>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div>
					<?= $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade filter-target" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header border-bottom">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-filter me-2"></i>Filter Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="get">
					<div class="row">
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kolom Cari</label>
							<select class="form-control" name="sort_field">
								<option value="">Pilih Salah Satu</option>
								<?php foreach ($field as $key => $value) { ?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('sort_field')) ? 'selected' : '' ?>><?= $value ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Tipe Cari</label>
							<select class="form-control" name="operator">
								<option value="">Pilih Salah Satu</option>
								<?php foreach ($operator as $key => $value) { ?>
									<option value="<?= $key ?>" <?= ($key == $this->input->get('operator')) ? 'selected' : '' ?>><?= $value ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-4 mb-2">
							<label class="form-label">Kata Kunci Cari</label>
							<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
						</div>
						<hr>
						<div class="form-group col-md-6 d-grid gap-1">
							<a href="<?= base_url() ?>admin/service_category" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
						</div>
						<div class="form-group col-md-6 d-grid gap-1">
							<button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Fungsi hapus per data
	function confirm_hapus(id, url) {
		Swal.fire({
			title: 'Yakin ingin menghapus Data Kategori #' + id + '?',
			text: "Layanan di dalam kategori ini juga akan ikut terhapus!",
			icon: 'warning',
			showCloseButton: true,
			confirmButtonText: 'Ya, Hapus!',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = url;
			}
		});
	}

	// Fungsi hapus SEMUA KATEGORI
	function confirm_all() {
		Swal.fire({
			title: 'Hapus SEMUA Kategori?',
			text: "Tindakan ini akan mengosongkan seluruh tabel kategori. Data layanan tidak akan dihapus massal, namun layanan akan kehilangan kategorinya.",
			icon: 'error',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, Hapus Semua!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "<?= base_url('admin/service_category/delete_all') ?>";
			}
		});
	}
</script>