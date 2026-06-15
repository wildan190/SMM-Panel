		<div class="row">
			<div class="col-md-5">
				<div class="card">
					<div class="card-header py-3">
						<h4 class="mb-0"><i class="fas fa-tags me-2"></i> Data Harga Khsusus</h4>
					</div>
					<div class="card-body">
						<form method="post" action="<?= base_url('admin/fetch_service/get_by_category') ?>">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
							<div class="form-group mb-2">
								<label>API *</label>
								<select class="form-control select2-data" name="api" id="api">
									<option value="">Pilih...</option>
									<?php foreach ($api as $key => $value) { ?>
										<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group mb-2">
								<label>Kategori API *</label>
								<select class="form-control select2-data" name="category_api" id="category">
									<option value="">Pilih API dahulu...</option>
								</select>
							</div>

							<div class="form-group mb-2">
								<label>Kategori Web *</label>
								<select class="form-control select2-data" name="category_web" id="category_web">
									<option value="">Pilih Kategori dahulu...</option>
									<?php foreach ($category as $key => $value) { ?>
										<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group mb-2">
								<label>Mata Uang *</label>
								<select class="form-control select2-data" name="currency" id="currency">
									<option value="">Pilih salah satu ...</option>
									<option value="idr">IDR</option>
									<option value="dollar_us">DOLLAR AMERIKA</option>
								</select>
							</div>
							<div class="form-group mb-2 d-none" id="form-kurs">
								<label>Kurs *</label>
								<input type="text" class="form-control" name="kurs" id="kurs">
							</div>
							<div class="form-group mb-2">
								<label>Tipe Keuntungan *</label>
								<select class="form-control select2-data" name="profit_type" id="profit_type">
									<option value="">Pilih salah satu ...</option>
									<option value="biasa">BIASA</option>
									<option value="persen">PERSEN</option>
								</select>
							</div>
							<div class="form-group mb-2">
								<label>Jumlah Keuntungan *</label>
								<input type="number" class="form-control" name="profit_member" id="profit_member">
								<p class="text-danger">Jika tipe keuntungan persen harap isi input tanpa operator % example : 12</p>
							</div>
							<div class="hstack gap-1 justify-content-end">
								<button type="reset" class="btn btn-dark"><i class="fas fa-cancel"></i> Reset</button>
								<button type="submit" class="btn btn-primary"><i class="fas fa-send"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="card">
					<div class="card-header py-3">
						<h4 class="card-title mb-0 flex-grow-1"><i class="fas fa-file me-2"></i> Result Box</h4>
					</div>
					<div class="card-body">
						<div id="show-fetch-service"></div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(function() {
				$('#api').on('change', function() {
					var api = $('#api').val();
					$.ajax({
						type: "GET",
						url: "<?= base_url('admin/service_api/list_category/') ?>" + api + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
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
				$('#currency').on('change', function() {
					var currency = $('#currency').val();
					console.log(currency);
					if (currency == 'dollar_us') {
						$('#form-kurs').removeClass('d-none');
					} else {
						$('#form-kurs').addClass('d-none');
					}
				});
				$("form").submit(function() {
					$.ajax({
						url: $(this).attr("action"),
						data: $(this).serialize(),
						type: $(this).attr("method"),
						dataType: 'html',
						beforeSend: function() {
							$("button").attr("disabled", true);
							$("#show-fetch-service").html('<div class="alert alert-primary">Tunggu ya</div>');
						},
						complete: function() {
							$("button").attr("disabled", false);
						},
						success: function(result) {
							$("#show-fetch-service").html(result);
						},
						error: function() {
							$("#show-fetch-service").html("gagal");
						}
					})
					return false;
				});
			});
			$('form').submit(function() {
				$(this).children('button[type=submit]').prop('disabled', true);
			});
		</script>