<div class="row">
	<div class="col-lg-12">
		<div class="text-right mb-3">
			<a href="<?= base_url('admin/'.$this->uri->segment(2).'/form') ?>" class="btn btn-blue"><i class="fa fa-plus fa-fw"></i> Tambah Data</a>
		</div>
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="fas fa-fw fa-tag"></i> Data Kategori</h5>
			</div>
			<div class="card-body">
				<form style="margin: 20px 0;">
					<div class="form-row">
						<div class="form-group col-sm-2">
							<label>Kolom Sortir</label>
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
						<div class="form-group col-sm-2">
							<label>Tipe Sortir</label>
							<select class="form-control" name="sort_type">
								<option value="">Tipe...</option>
								<option value="asc" <?= ($this->input->get('sort_type') == 'asc') ? 'selected' : '' ?>>ASC</option>
								<option value="desc" <?= ($this->input->get('sort_type') == 'desc') ? 'selected' : '' ?>>DESC</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<label>Kolom Cari</label>
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
						<div class="form-group col-sm-2">
							<label>Operator Cari</label>
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
						<div class="form-group col-sm-2">
							<label>Kata Kunci Cari</label>
							<input type="text" class="form-control" name="value" placeholder="Value" value="<?= $this->input->get('value') ?>">
						</div>
						<div class="form-group col-sm-2">
							<label>Submit</label>
							<button type="submit" class="btn btn-block btn-blue">Filter</button>
						</div>
					</div>
				</form>
				<div class="table-responsive">
					<table class="table table-colored-bordered table-bordered-dark table-hover m-0">
						<thead>
							<tr class="bg-blue">
							<th>ID</th>
							<th>NAMA</th>
							<th>TIPE</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>
				<?php
				foreach ($table as $key => $value) {
				?>
							<tr>
								<td><?= $value['id'] ?></td>
								<td><?= $value['name'] ?></td>
								<td><?= $value['type'] ?></td>
								<td align="center">
									<a href="<?= base_url('admin/'.$this->uri->segment(2).'/form/'.$value['id']) ?>" class="badge badge-warning"><i class="uil-file-edit-alt"></i> Ubah</a> 
									<a href="javascript:;" onclick="confirm_hapus('<?= $value['id'] ?>')" class="badge badge-danger"><i class="uil-trash-alt"></i> Hapus</a>
								</td>
							</tr>
				<?php
				}
				?>
						</tbody>
					</table>
					<div>
						<?= $this->pagination->create_links() ?><br />
						<span class="btn btn-blue">Total data: <?= $total_data ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function confirm_hapus(id) {
	Swal.fire({
		title: 'Yakin ingin menghapus Data Kategori #' + id + '?',
		icon: 'warning',
		showCloseButton: true,
		confirmButtonText: 'Yakin',
		confirmButtonColor: '<?= website_config('color_theme') ?>',
		showCancelButton: true,
		cancelButtonText: 'Batal',
		cancelButtonColor: '#e74a3b',
		reverseButtons: true
	}).then((result) => {
		if (result.value) window.location = "<?= base_url() ?>admin/service_category/delete/" + id
	})
}
</script>