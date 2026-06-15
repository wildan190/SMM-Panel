<div class="table-responsive">
	<table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0">
		<tr>
			<th class="table-info" width="50%">ID</th>
			<td><?= $target->id ?></td>
		</tr>
		<tr>
			<th class="table-info">Pengguna</th>
			<td><?= $user->username ?></td>
		</tr>
		<tr>
			<th class="table-info">Layanan</th>
			<td><?= $target->service ?></td>
		</tr>
		<tr>
			<th class="table-info">Target</th>
			<td>
				<?= auto_link($target->target) ?>
			</td>
		</tr>
		<tr>
			<th class="table-info">Jumlah</th>
			<td><?= number_format($target->quantity, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th class="table-info">Jumlah Awal</th>
			<td><?= number_format($target->start_count, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th class="table-info">Jumlah Kurang</th>
			<td><?= number_format($target->remains, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th class="table-info">Harga</th>
			<td>Rp <?= number_format($target->price, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th class="table-info">Profit</th>
			<td>Rp <?= number_format($target->profit, 0, ',', '.') ?></td>
		</tr>
		<tr>
			<th class="table-info">Status</th>
			<td><?= $this->lib->status_order($target->status) ?></td>
		</tr>
		<tr>
			<th class="table-info">Sumber</th>
			<td><?= ($target->is_api == '1') ? 'API' : 'WEB' ?></td>
		</tr>
		<tr>
			<th class="table-info">Refund</th>
			<td><?= ($target->is_refund == '1') ? 'YA' : 'TIDAK' ?></td>
		</tr>
		<tr>
			<th class="table-info">IP Addres</th>
			<td><?= $target->ip_address ?></td>
		</tr>
		<?php if ($target->custom_comments <> '' or $target->custom_link <> '') { ?>

			<tr>
				<th class="table-info">Kustom Komentar</th>
				<td>
					<textarea class="form-control"><?= $target->custom_comments ?></textarea>
				</td>
			</tr>
			<tr>
				<th class="table-info">Kustom Target</th>
				<td>
					<textarea class="form-control"><?= $target->custom_link ?></textarea>
				</td>
			</tr>
		<?php } ?>
		<tr>
			<th class="table-info">API</th>
			<td><?= $api->name ?></td>
		</tr>
		<tr>
			<th class="table-info">API ID Pesanan</th>
			<td><?= $target->api_order_id ?></td>
		</tr>
		<tr>
			<th class="table-info">Log Pesan API</th>
			<td>
				<textarea class="form-control"><?= $target->api_log_order ?></textarea>
			</td>
		</tr>
		<tr>
			<th class="table-info">Log Status API</th>
			<td>
				<textarea class="form-control"><?= $target->api_log_status ?></textarea>
			</td>
		</tr>
		<tr>
			<th class="table-info">Waktu Proses</th>
			<td><?= $this->lib->timeProcess($target->created_at, $target->updated_at) ?></td>
		</tr>
		<tr>
			<th class="table-info">Tgl. Dibuat</th>
			<td><?= $this->lib->tanggal_indonesia($target->created_at) ?></td>
		</tr>
		<tr>
			<th class="table-info">Tgl. Pembaruan</th>
			<td><?= $this->lib->tanggal_indonesia($target->updated_at) ?></td>
		</tr>
	</table>
</div>