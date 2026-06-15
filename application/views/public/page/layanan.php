
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Daftar Layanan</h4>
            </div>
            	<div class="card-body pb-2">
														<select class="form-control select2" id="category" name="categories">
															<option value="">Pilih Kategori</option>
												<?php
												foreach ($this->service_category_model->get_rows(['order_by' => 'name ASC']) as $key => $value) {
												?>
												<option value="<?= $value['id'] ?>" <?= ($value['id'] == $this->uri->segment(3)) ? 'selected' : '' ?>><?= $value['name'] ?></option>
												<?php
												}
												?>
														</select>
												</div>
            <div class="card-body pb-2">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="table-data">
											<?php if ($this->uri->segment(3)) { ?>
											<?php foreach ($service_category as $key => $value) { ?>
												<thead>
                            <tr class="text-uppercase">
													<th>ID</th>
													<th width="20%; !important">Layanan <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Layanan dengan tanda ♻️ artinya layanan tersebut dapat di <em>Refill</em>."><i class="fas fa-exclamation-circle"></i></a></th>
													<th>Min</th>
													<th>Maks</th>
													<th>Harga</th>
													<th class="text-nowrap">Waktu Rata-Rata <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Waktu rata-rata</em> didasarkan pada 10 pesanan terakhir dengan status pesanan <em>Success</em>."><i class="fas fa-exclamation-circle"></i></a></th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
										
<tr>
<th colspan="9" style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
<h5 class="d-none d-md-block d-lg-block text-center mb-0">
<b><?= $value['name'] ?></b>
</h5>
<h5 class="d-block d-md-none d-lg-none mb-0" style="margin-top: 0;"><b><?= $value['name'] ?></b></h5>
</th>
</tr>
									
											<?php foreach ($service[$key] as $data) 
												{
											$order_check = $this->order_model->get_row(['service_id' => $data['id'], 'status' => 'Success']);
			    $average = 'Belum ada data';
			if ($order_check == false) { 
			    $average = 'Belum ada data';
			} else {
    			$tgl_sekarang = new DateTime($order_check->updated_at);  
    			$tgl_lalu = new DateTime($order_check->created_at);  
    			//$average = $tgl_lalu->diff($tgl_sekarang)->format('%a HARI %h JAM %i MENIT %s DETIK');
				$average = $this->lib->timeProcess($order_check->created_at, $order_check->updated_at);
			}
												?>
												<tr>
													<td><?= $data['id'] ?></td>
													<td><?= $data['name'] ?> <?php if ($data['refill'] == 1) { ?>♻️<?php } ?></td>
													<td><?= currency($data['min']) ?></td>
													<td><?= currency($data['max']) ?></td>
													<td>Rp <?= currency($data['price']) ?></td>
													<td><?= $average ?></td>
													<td class="col-1 text-nowrap">
                                            <a href="javascript:;" onclick="modal_open('detail_layanan', '<?= base_url('page/detail_service/'.$data['id']. '/'.$this->security->get_csrf_hash().'') ?>')" class="btn btn-primary btn-sm round"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>
                                        </td>
												</tr>
												<?php } ?>	
											</tbody>
											<?php } ?>
											<?php } else { ?>
											<td  class="table-primary" colspan="12" align="center">
												<div class="py-4 text-center">
													<h5>Silahkan Pilih Kategori</h5>
												</div>
											</td>
											<?php } ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<div class="modal fade" id="detail_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail_modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3" id="detail_modal_body">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#category').on('change', function() {
			window.location = "<?= base_url('page/layanan/') ?>" + $('#category').val();
		});
	});
</script>
<script type="text/javascript">
function detail_service(id) {
        $('#detail_modal_title').html('<i class="fas fa-search me-2"></i>Detail Layanan #' + id);
        $('#detail_modal').modal('show');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>page/detail_service",
            data: "id=" + id,
            dataType: "html",
            success: function(data) {
                $('#detail_modal_body').html(data);
            },
            error: function() {
                $('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                $('#detail_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>