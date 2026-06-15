<div class="table-responsive">

	<table class="table table-bordered table-striped table-hover m-0">
		<thead>
			<tr class="">
				<th>ID</th>
				<th>NAMA</th>
				<th>HARGA</th>
				<th>PROFIT</th>
				<th>TOTAL HARGA</th>
				<th>AKSI</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($result as $key => $value) { ?>
				<tr>
					<td>
						<?= $value[$api->service_id_key] ?>
					</td>
					<td>
						<?= $value[$api->service_name_key] ?>
					</td>
					<td>Rp
						<?= currency($value[$api->price_key]) ?>
					</td>
					<td>Rp
						<?= currency($value['profit']) ?>
					</td>
					<td>Rp
						<?= currency($value['total_price']) ?>
					</td>
					<td>
						<a href="javascript: void(0);" onclick="service('<?= base_url('admin/' . $this->uri->segment(2) . '/service/' . $value[$api->service_id_key] . '/' . $kurs . '/' . $api->api_id) ?>')" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="modal fade" id="modal-service" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Layanan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pb-3" id="modal-service-body">
				<a href="javascript:void(0);" class="btn btn-danger fw-medium w-100" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function service(url) {
			$.ajax({
				type: "GET",
				url: url,
				beforeSend: function() {
					$('#modal-service-body').html('<div class="progress"><div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>');
				},
				success: function(result) {
					$('#modal-service-body').html(result);
				},
				error: function() {
					$('#modal-service-body').html('Terjadi kesalahan.');
				}
			});
			$('#modal-service').modal('show');
		}

		function add_service(form, url) {
			$.ajax({
				type: 'POST',
				url: url,
				dataType: 'html',
				data: $(form).serialize(),
				beforeSend: function() {
					$('#modal-service-result').html('<div class="progress"><div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>');
				},
				success: function(result) {
					$('#modal-service-body').html(result);
				},
				error: function() {
					$('#modal-service-result').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Terjadi kesalahan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				}
			});
		}
	</script>