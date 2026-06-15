<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-side-web bg-white">
			<b>Perhatian:</b> Layanan dibawah ini adalah layanan yang Success dikerjakan oleh server dengan rentang waktu yang cepat. Sehingga layanan dibawah ini sangat direkomendasikan untuk di pesan.
		</div>	    
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-database mr-2"></i>Monitoring Pesanan</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover m-0" id="table-data">
							<thead>
								<tr class="">
								<th>TANGGAL/WAKTU</th>
								<th>LAYANAN</th>
								<th>JUMLAH</th>
								<th>WAKTU PROSES</th>
							</tr>
						</thead>
						<tbody>
					<?php
					foreach ($table as $key => $value) {

					$tgl_sekarang = new DateTime($value['updated_at']);  
					$tgl_lalu = new DateTime($value['created_at']);  
					?>
							<tr>
								<td><?= $this->lib->format_datetime($value['created_at']) ?></td>
								<td><?= $value['service_name'] ?></td>
								<td><?= number_format($value['quantity'],0,',','.') ?></td>
								<td><?= $tgl_lalu->diff($tgl_sekarang)->format('%a HARI %h JAM %i MENIT %s DETIK') ?></td>
							</tr>
					<?php
					}
					?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
