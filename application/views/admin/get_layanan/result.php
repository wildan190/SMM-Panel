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
						<a href="javascript: void(0);" onclick="service('<?= base_url('admin/' . $this->uri->segment(2) . '/service/' . $value[$api->service_id_key] . '/' . $data_api->rate . '/' . $api->api_id) ?>')" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="modal fade" id="modal-service" tabindex="-1" aria-hidden="true" style="overflow-y: scroll;">
	<div class="modal-dialog modal-lg">
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
</div>
<script type="text/javascript">
	(function($) {
		$.fn.hasScrollBar = function() {
			return this[0] ? this[0].scrollHeight > this.innerHeight() : false;
		};
	})(jQuery);

	if (!$('body').hasScrollBar()) {
		setTimeout(function() {
			var oldStyle = $('body.swal2-height-auto').attr('style');
			$('body.swal2-height-auto').attr('style', oldStyle + 'padding-right: 0 !important;');
		}, 1);
	}

	if (!$('body').hasScrollBar()) {
		setTimeout(function() {
			var oldStyle = $('body.modal-open').attr('style');
			$('body.modal-open').attr('style', oldStyle + 'padding-right: 0 !important;');
		}, 1);
	}

	$(".modal").on('hide.bs.modal', function() {
		setTimeout(function() {
			$('.select2-data').select2();
		}, 200);
	});

	$(".modal").on('shown.bs.modal', function() {
		setTimeout(function() {
			$(".select2-data").each((_i, e) => {
				var $e = $(e);
				$e.select2({
					dropdownParent: $e.parent()
				});
			})
		}, 300);
	});

	if (!($(".modal").data('bs.modal') || {})._isShown) {
		document.querySelector('body').style.overflow = 'auto';
		$('.select2-data').select2();
	}

	$(document).ready(function() {
		$('.select2-data').select2();
	});

	function service(url) {
		$.ajax({
			type: "GET",
			url: url,
			beforeSend: function() {
				$('#modal-service-body').html('<div class="progress"><div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>');
			},
			success: function(result) {
				$('#modal-service-body').html(result);
				// Inisialisasi Select2 setelah data diterima
				$('.select2-data').select2();
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
				// Inisialisasi Select2 setelah data diterima
				$('.select2-data').select2();
			},
			error: function() {
				$('#modal-service-result').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Terjadi kesalahan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}
		});
	}
</script>