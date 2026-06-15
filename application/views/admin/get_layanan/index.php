<div class="row">
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="uil uil-list-ul mr-2"></i>Get Layanan Satuan</h4>
			</div>
			<div class="card-body">
				<form method="post" action="<?= base_url('admin/get_layanan/api') ?>">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label class="form-label">Nama Provider *</label>
						<select class="form-control select2-data" name="api" id="api">
							<option value="">Pilih...</option>
							<?php foreach ($api as $key => $value) { ?>
								<option value="<?= $value['id'] ?>">
									<?= $value['name'] ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label class="form-label">Kategori *</label>
						<select class="form-control select2-data" name="category" id="category">
							<option value="">Pilih provider dahulu...</option>
						</select>
					</div>
					<hr>
					<button type="submit" class="btn btn-primary" id="btn-get">
						<i class="fas fa-plane fs-6 me-2"></i>Kirim
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header">
				<h4 class="mb-0"><i class="uil uil-code mr-2"></i>Result Box</h4>
			</div>
			<div class="card-body">
				<div class="row" id="show-fetch-service"></div>
				<script type="text/javascript">
					$(function() {

						$('#api').on('change', function() {
							var api = $('#api').val();
							$.ajax({
								type: "GET",
								url: "<?= base_url('admin/get_layanan/list_category/') ?>" + api + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
								dataType: "json",
								beforeSend: function() {
									$("#category").attr("readonly", true);
									$("#btn-get").attr("disabled", true);
									$("#category").html('<option value="">Tunggu sebentar...</option>');
								},
								success: function(data) {
									$('#category').html(data.msg);
									$("#category").attr("readonly", false);
									$("#btn-get").attr("disabled", false);
								},
								error: function() {
									alert('Terjadi kesalahan, silakan refresh halaman ini.');
								}
							});
						});


						$("form").submit(function() {
							$.ajax({
								url: $(this).attr("action"),
								data: $(this).serialize(),
								type: $(this).attr("method"),
								dataType: 'html',
								beforeSend: function() {
									$("#btn-get").attr("disabled", true);
								},
								complete: function() {
									$("#btn-get").attr("disabled", false);
								},
								success: function(result) {
									$("#show-fetch-service").html(result);
								},
								error: function() {
									$("#show-fetch-service").html("gagal");
								}
							});
							return false;
						});

						$('form').submit(function() {
							$(this).children('button[type=submit]').prop('disabled', true);
						});
					});
				</script>
			</div>
		</div>
	</div>
</div>