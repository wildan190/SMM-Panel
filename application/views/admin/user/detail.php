<div class="table-responsive">
<table class="table table-bordered table-striped mb-0">
	<tr>
		<td class="table-info" align="center" colspan="2"><b>INFORMASI UMUM</b></td>
	</tr>
	<tr>
		<th>Nama Lengkap</th>
		<td><?= $target->full_name ?></td>
	</tr>
		<th>Username</th>
		<td><?= $target->username ?></td>
	</tr>
	<tr>
		<th>Email</th>
		<td><?= $target->email ?></td>
	</tr>
	<tr>
		<th>Saldo</th>
		<td>Rp <?= number_format($target->balance,0,',','.') ?></td>
	</tr>
	<tr>
		<th>Whatsapp</th>
		<td><a href="https://wa.me/<?= $this->lib->hp($target->whatsapp) ?>"><?= $this->lib->hp($target->whatsapp) ?></a></td>
	</tr>
	<tr>
		<th>Level</th>
		<td><?= $target->level ?></td>
	</tr>
	<tr>
		<th>API ID</th>
		<td><?= $this->lib->encrypt_decrypt('encrypt',$target->id) ?></td></td>
	</tr>
	<tr>
		<th>API Key</th>
		<td><?= $target->api_key ?></td>
	</tr>
	<tr>
		<th>Status</th>
		<td><?= ($target->status == '1') ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>' ?></td>
	</tr>
	<tr>
		<th>Verifikasi</th>
		<td><?= ($target->is_verif == '1') ? '<span class="badge bg-success">Sudah</span>' : '<span class="badge bg-danger">Belum</span>' ?></td>
	</tr>
	<tr>
		<th>Tgl. Dibuat</th>
		<td><?= $this->lib->tanggal_indonesia($target->created_at) ?></td>
	</tr>
	<tr>
		<td class="table-info" align="center" colspan="2"><b>INFORMASI LAINNYA</b></td>
	</tr>
	<tr>
		<th>Total Pesanan</th>
		<td>Rp <?= number_format($total_order[0]['rupiah'],0,',','.') ?> (<?= number_format($total_order[0]['total'],0,',','.') ?>)</td>
	</tr>
	<tr>
		<th>Total Deposit</th>
		<td>Rp <?= number_format($total_deposit[0]['rupiah'],0,',','.') ?> (<?= number_format($total_deposit[0]['total'],0,',','.') ?>)</td>
	</tr>
</table>
</div>