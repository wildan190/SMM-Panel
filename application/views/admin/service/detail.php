<div class="table-responsive">
	<table class="table table-bordered mb-0">
		<tr>
			<td style="background-color: rgba(var(--bs-primary-rgb), 0.2);" align="center" colspan="2"><b>ORDER</b></td>
		</tr>
		<tr>
			<th>Total Pesanan</th>
			<td><?= ($order[0]['rupiah'] == '' ? 'Tidak ada pesanan' : 'Rp ' . currency($order[0]['rupiah'])) ?> (<?= currency($order[0]['total']) ?> Pesanan)</td>
		</tr>
		<tr>
			<td style="background-color: rgba(var(--bs-primary-rgb), 0.2);" align="center" colspan="2"><b>API</b></td>
		</tr>
		<tr>
			<th>Provider</th>
			<td><?= $api->name ?></td>
		</tr>
		<tr>
			<th>ID Provider</th>
			<td><?= $target->api_service_id ?></td>
		</tr>
		<tr>
			<td style="background-color: rgba(var(--bs-primary-rgb), 0.2);" align="center" colspan="2"><b>LAYANAN</b></td>
		</tr>
		<tr>
			<th>ID</th>
			<td><?= $target->id ?></td>
		</tr>
		<tr>
			<th>Kategori</th>
			<td><?= $service_category->name ?></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td><?= $target->name ?></td>
		</tr>
		<tr>
			<th>Deskripsi</th>
			<td><?= nl2br($target->description) ?></td>
		</tr>
		<tr>
			<th>Harga/K</th>
			<td>Rp <?= number_format($target->price, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th>Keuntungan/K</th>
			<td>Rp <?= number_format($target->profit, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th>Min / Maks</th>
			<td><?= number_format($target->min, 0, ',', '.') ?> / <?= number_format($target->max, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th>Average Time</th>
			<td> <?= $target->average_time ?></td>
		</tr>
		<tr>
			<th>Status</th>
			<td><?= ($target->status == '1') ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' ?></td>
		</tr>
		<tr>
			<th>Pesan Via Api</th>
			<td><?= ($target->api == '1') ? 'YA' : 'TIDAK' ?></td>
		</tr>
		<tr>
			<th>Refill</th>
			<td><?= ($target->refill == '1') ? '<span class="badge bg-success">ON</span>' : '<span class="badge bg-danger">OFF</span>' ?></td>
		</tr>
		<tr>
			<th>Tipe</th>
			<td><?= strtoupper($target->type) ?></td>
		</tr>
	</table>
</div>