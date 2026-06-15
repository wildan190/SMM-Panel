
<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target=".info-monitoring"><i class="fas fa-info-circle fs-6 me-2"></i>Informasi Monitoring</a>
        <div class="modal fade info-monitoring" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Informasi Monitoring</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-0">
                            <h5 class="alert-heading">Informasi Untuk Monitoring Layanan !</h5>
                            <div class="alert-body">
                                <ul class="mb-0">
                                    <li>Fitur ini dibuat untuk pengguna yang ingin melihat kecepatan <b>waktu proses</b> pesanan pada layanan.</li>
                                    <li><b>Monitoring Layanan</b> yang terdapat dibawah ini merupakan 100 pesanan terakhir yang di pesan oleh pengguna.</li>
                                    <li><b>Waktu proses</b> yang terdapat dibawah ini bukan <b>waktu rata-rata</b>, Anda bisa melihat pada halaman Daftar Layanan untuk melihat <b>waktu rata-rata</b> pada tiap layanan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-desktop me-2"></i>Monitoring Layanan</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-uppercase text-nowrap">
                                <th>ID Layanan</th>
                                <th>Nama Layanan</th>
                                <th>Jumlah <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Pemesanan"></i></th>
                                <th>Harga</th>
                                <th class="text-nowrap">Waktu Proses</th>
                                <th class="text-nowrap">TGl. Dibuat</th>
                                <th class="text-nowrap">TGL. Pembaruan</th>
                            </tr>
                        </thead>
                        <tbody>
					<?php
					foreach ($table as $key => $value) {

					$tgl_sekarang = new DateTime($value['updated_at']);  
					$tgl_lalu = new DateTime($value['created_at']);  
					?>
					<tr>
                        <td><a href="javascript:;" onclick="modal_open('detail_layanan', '<?= base_url('page/detail_service/'.$value['service_id']. '/'.$this->security->get_csrf_hash().'') ?>')"><b><?= $value['service_id'] ?></b></a></td>
						<td><?= $value['service_name'] ?></td>
						<td><?= number_format($value['quantity'],0,',','.') ?></td>
						<td>Rp <?= number_format($value['price'],0,',','.') ?></td>
						<td><?= $this->lib->timeProcess($value['created_at'], $value['updated_at']) ?></td>
						<td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
						<td><?= $this->lib->tanggal_indonesia($value['updated_at']) ?></td>
					</tr>
							<?php } ?>
						</tbody>
                    </table>
                </div>
                            </div>
        </div>
    </div>
</div>