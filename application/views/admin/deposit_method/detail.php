<div class="table-responsive">
	<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0">
		<tr>
			<th>ID</th>
			<td><?= $target->id ?></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td><?= $target->name ?></td>
		</tr>
		<tr>
			<th>No Rekening/HP</th>
			<td><?= $target->number_account ?></td>
		</tr>
		<tr>
			<th>Atas Nama</th>
			<td><?= $target->name_account ?></td>
		</tr>
		<tr>
			<th>Tipe</th>
			<td><?= strtoupper($target->type) ?></td>
		</tr>
		<tr>
			<th>Ketegori</th>
			<td><?= strtoupper($target->category) ?></td>
		</tr>
		<tr>
			<th>Kode</th>
			<td><?= strtoupper($target->gateway_code) ?></td>
		</tr>
		<tr>
			<th>Deskripsi</th>
			<td><?= $target->description ?></td>
		</tr>
		<tr>
			<th>Minimal Deposit</th>
			<td>Rp <?= number_format($target->min_deposit, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th>Rate</th>
			<td><?= $target->rate ?></td>
		</tr>
		<tr>
			<th>Status</th>
			<td><?= ($target->status == '1') ? 'AKTIF' : 'NON AKTIF' ?></td>
		</tr>
	</table>
</div>