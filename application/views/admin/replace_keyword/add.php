<div class="row">
    <div class="col-md-12">
			<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
            <div class="card-header">
				<h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data</h4>
            </div>
            <div class="card-body">	
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group mb-0">
						<label class="form-label">Kata Kunci *</label>
						<input type="text" class="form-control" name="name" value="<?= set_value('name') ?>">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Kata Ganti *</label>
						<input type="text" class="form-control" name="target" value="<?= set_value('target') ?>">
					</div><hr>		
					<div class="hstack gap-1 justify-content-end">
					<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#summernote-editor").summernote({
			height: 250,
			minHeight: null,
			maxHeight: null,
			}), $("#summernote-inline").summernote({
			airMode: !0
		})
	});
</script>