<div class="table-responsive">
<table class="table table-bordered table-striped mb-0">
	<tr>
		<th width="50%">ID</th>
		<td><?= $target->id ?></td>
	</tr>
	<tr>
		<th>Pengguna</th>
		<td><?= $user->username ?></td>
	</tr>
	<tr>
		<th>Layanan</th>
		<td><?= $target->service ?></td>
	</tr>
	<tr>
		<th>Target</th>
		<td>
			<?= $target->target ?>
		</td>
	</tr>
	<tr>
		<th>Status</th>
		<td><?= $target->status ?></td>
	</tr>
	<tr>
		<th>API</th>
		<td><?= $api->name ?></td>
	</tr>
	<tr>
		<th>ID Pesanan</th>
		<td><?= $target->order_id ?></td>
	</tr>
	<tr>
		<th>API ID Refill</th>
		<td><?= $target->api_refill_id ?></td>
	</tr>
	<tr>
		<th>API Log Refill</th>
		<td>
			<textarea class="form-control"><?= $target->api_log_refill ?></textarea>
		</td>
	</tr>
	<tr>
		<th>API Log Status Refill</th>
		<td>
			<textarea class="form-control"><?= $target->api_log_status_refill ?></textarea>
		</td>
	</tr>
	<tr>
		<th>Waktu Proses</th>
		<td><?= $this->lib->timeProcess($target->created_at, $target->updated_at) ?></td>
	</tr>
	<tr>
		<th>Tgl. Dibuat</th>
		<td><?= $this->lib->tanggal_indonesia($target->created_at) ?></td>
	</tr>
	<tr>
		<th>Tgl. Pembaruan</th>
		<td><?= $this->lib->tanggal_indonesia($target->updated_at) ?></td>
	</tr>
</table>
</div>