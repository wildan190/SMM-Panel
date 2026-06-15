<div class="table-responsive">
<table class="table table-nowrap table-bordered align-middle table-hover m-0">
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);" width="50%">ID</th>
		<td><?= $target->id ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Layanan</th>
		<td><?= $target->service ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Target</th>
		<td><?= auto_link($target->target) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Jumlah</th>
		<td><?= currency($target->quantity) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Jumlah Awal</th>
		<td><?= currency($target->start_count) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Jumlah Kurang</th>
		<td><?= currency($target->remains) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Harga</th>
		<td>Rp <?= currency($target->price) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Status</th>
		<td><?= $this->lib->status_order($target->status) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Pesan Lewat</th>
		<td><?= ($target->is_api == '1') ? 'API' : 'WEB' ; ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Pengembalian Dana</th>
		<td><?= ($target->is_refund == '1') ? 'Ya' : 'Tidak' ; ?></td>
	</tr>
			<?php if ($target->custom_comments <> '' or $target->custom_link <> '') { ?>
				
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Kustom Komentar</th>
		<td>
			<textarea class="form-control"><?= $target->custom_comments ?></textarea>
		</td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Kustom Target</th>
		<td>
			<textarea class="form-control"><?= $target->custom_link ?></textarea>
		</td>
	</tr>
			<?php } ?>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Waktu Proses</th>
		<td><?= $this->lib->timeProcess($target->created_at, $target->updated_at) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Tgl. Dibuat</th>
		<td><?= $this->lib->Tanggal_indonesia($target->created_at) ?></td>
	</tr>
	<tr>
		<th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Tgl. Pembaruan</th>
		<td><?= $this->lib->Tanggal_indonesia($target->updated_at) ?></td>
	</tr>
</table>
</div>