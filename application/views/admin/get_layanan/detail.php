<div class="table-responsive">
<table class="table table-bordered">
	<tr>
		<td align="center" colspan="2"><b>API</b></td>
	</tr>
	<tr>
		<th width="50%">API</th>
		<td><?= $api->name ?></td>
	</tr>
	<tr>
		<th>API ID LAYANAN</th>
		<td><?= $target->api_service_id ?></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><b>LAYANAN</b></td>
	</tr>
	<tr>
		<th>ID</th>
		<td><?= $target->id ?></td>
	</tr>
	<tr>
		<th>KATEGORI</th>
		<td><?= $service_category->name ?></td>
	</tr>
	<tr>
		<th>NAMA</th>
		<td><?= $target->name ?></td>
	</tr>
	<tr>
		<th>DESKRIPSI</th>
		<td><?= $target->description ?></td>
	</tr>
	<tr>
		<th>HARGA/K</th>
		<td>Rp <?= number_format($target->price,0,',','.') ?></td>
	</tr>
	<tr>
		<th>KEUNTUNGAN/K</th>
		<td>Rp <?= number_format($target->profit,0,',','.') ?></td>
	</tr>
	<tr>
		<th>MINIMAL PESAN</th>
		<td><?= number_format($target->min,0,',','.') ?></td>
	</tr>
	<tr>
		<th>MAKSIMAL PESAN</th>
		<td><?= number_format($target->max,0,',','.') ?></td>
	</tr>
	<tr>
		<th>STATUS</th>
		<td><?= ($target->status == '1') ? 'AKTIF' : 'NON AKTIF' ?></td>
	</tr>
	<tr>
		<th>PESAN VIA API</th>
		<td><?= ($target->api == '1') ? 'YA' : 'TIDAK' ?></td>
	</tr>
	<tr>
		<th>TIPE</th>
		<td><?= strtoupper($target->type) ?></td>
	</tr>
</table>
</div>