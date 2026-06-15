<style>
	.Pending {
		color: #e58a00;
		border: 0.25rem solid #e58a00;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}

	.Success {
		color: #4BA56E;
		border: 0.25rem solid #4BA56E;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}

	.Canceled {
		color: #F64D35;
		border: 0.15rem solid #F64D35;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}
</style>
<div class="row">
	<?php if ($deposit_method->is_gateway == '1' && $target->status == 'Pending') {
		$data = json_decode($target->result, true);
	?>
		<div class="col-md-12">
			<div class="alert alert-primary">
				<div class="alert-body">
					<i class="fas fa-exclamation-circle me-2"></i>Tagihan akan otomatis dibatalkan setelah melewati <em><b>
							<?php if ($deposit_method->type == 'tripay') {
								echo $this->lib->day($data['expired_time']) ?>
							<?php } else {
								echo $this->lib->tanggal_indonesia($data['expired']);
							} ?></b></em>.
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="col-md-6">
		<strong>ID Deposit</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $target->id ?>" disabled>
	</div>
	<div class="col-md-6">
		<strong>Metode Pembayaran</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $deposit_method->name ?>" disabled>
	</div>
	<div class="col-md-6">
		<strong>Jumlah Transfer</strong>
	</div>
	<div class="col-md-6 mb-2">
		<div class="input-group">
			<div class="input-group-text">Rp</div>
			<input type="text" class="form-control" value="<?= currency($target->amount) ?>" disabled>
		</div>
	</div>
	<div class="col-md-6">
		<strong>Saldo Diterima</strong>
	</div>
	<div class="col-md-6 mb-2">
		<div class="input-group">
			<div class="input-group-text">Rp</div>
			<input type="text" class="form-control" value="<?= currency($target->balance) ?>" disabled>
		</div>
	</div>

	<div class="col-md-6">
		<strong>Type Deposit</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= strtoupper($deposit_method->type) ?>" disabled>
	</div>
	<?php if ($deposit_method->type != 'manual') : ?>
		<div class="col-md-6">
			<strong>Kode Unik/Reference</strong>
		</div>
		<div class="col-md-6 mb-2">
			<input type="text" class="form-control" value="<?= $target->reference ?>" disabled>
		</div>
	<?php endif; ?>


	<?php if ($deposit_method->is_gateway == '1') { ?>
		<div class="col-md-6">
			<?php if (in_array($deposit_method->gateway_code, ['QRIS', 'QRISC', '11', '17'])) { ?>
				<strong>QR Code</strong>
			<?php } elseif (in_array($deposit_method->gateway_code, ['DANA', 'OVO', 'SHOPEEPAY', '12', '13', '14', '15', '16'])) { ?>
			<?php } else { ?>
				<strong>Kode Pembayaran</strong>
			<?php } ?>
		</div>
		<div class="col-md-6 mb-2">
			<?php if (in_array($deposit_method->gateway_code, ['QRIS', 'QRISC', '11', '17'])) { ?>
				<div class="text-md-left text-center mb-2">
					<img style="border-radius: 10px;" class="rounded img-fluid" src="<?= $target->additional_data ?>" alt="" width="220px" />
				</div>
				<div class="d-flex justify-content-center mb-2">
					<span class="<?= $target->status ?>">
						<?= $target->status ?>
					</span>
				</div>
			<?php } elseif (in_array($deposit_method->gateway_code, ['DANA', 'OVO', 'SHOPEEPAY', '12', '13', '14', '15', '16'])) { ?>
				<div class="d-flex justify-content-center mt-2 mb-2">
					<span class="<?= $target->status ?>">
						<?= $target->status ?>
					</span>
				</div>
			<?php } else { ?>

				<input type="text" class="form-control" value="<?= $target->additional_data ?>" disabled>

				<div class="d-flex justify-content-center mt-2">
					<span class="<?= $target->status ?>">
						<?= $target->status ?>
					</span>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<div class="col-md-6">
			<strong>Tujuan Transfer</strong>
		</div>
		<div class="col-md-6 mb-2">
			<?php {
				$method = $this->deposit_method_model->get_row(['id' => $target->deposit_method_id]);
			?>
				<input type="text" class="form-control" value="<?= $method->number_account ?> - <?= $method->name_account ?>" disabled>

				<div class="d-flex justify-content-center mt-2">
					<span class="<?= $target->status ?>">
						<?= $target->status ?>
					</span>
				</div>
			<?php }
			?>
		</div>
	<?php } ?>

	<?php if ($deposit_method->category == 'pulsa') { ?>
		<div class="col-md-6">
			<strong>Nomor Pengirim (Pulsa)</strong>
		</div>
		<div class="col-md-6 mb-2">
			<input type="text" class="form-control" value="<?= $target->phone_number ?>" disabled>
		</div>
	<?php } ?>
	<div class="col-md-6">
		<strong>Informasi</strong>
	</div>
	<?php if ($deposit_method->type == 'tripay') { ?>
		<div class="col-md-6 mb-2">
			<div class="row">
				<div class="col-md-12">
					<div class="payment-group accordion card mb-0" id="default-accordion-a">
						<?php
						$data = json_decode($target->result, true);
						for ($i = 0; $i < count($data['instructions']); $i++) {
							$gas = ['One', 'Two', 'Three', 'Four', 'Five'];
							$isFirst = ($i == 0) ? 'show' : ''; // Menandai elemen pertama sebagai yang terbuka
						?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading<?= $gas[$i] ?>">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $gas[$i] ?>" aria-expanded="<?= $isFirst ?>" aria-controls="collapse<?= $gas[$i] ?>">
										<?= $data['instructions'][$i]['title'] ?>
									</button>
								</h2>
								<div id="collapse<?= $gas[$i] ?>" class="accordion-collapse collapse <?= $isFirst ?>" aria-labelledby="heading<?= $gas[$i] ?>" data-bs-parent="#default-accordion-a">
									<div class="accordion-body pb-0">
										<ol style="">
											<?php
											$steps = $data['instructions'][$i]['steps'];
											for ($j = 0; $j < count($steps); $j++) {
											?>
												<li>
													<?= $steps[$j] ?>
												</li>
											<?php } ?>
										</ol>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php } elseif ($deposit_method->type == 'paydisini') { ?>
		<div class="col-md-6 mb-2">
			<div class="row">
				<div class="col-md-12">
					<?php if (!empty($instruksi['data'])) : ?>
						<div class="payment-group accordion card mb-0" id="default-accordion-a">
							<?php foreach ($instruksi['data'] as $i => $data) : ?>
								<?php
								$gas = ['One', 'Two', 'Three', 'Four', 'Five'];
								$isFirst = ($i == 0) ? 'show' : ''; // Menandai elemen pertama sebagai yang terbuka
								?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="heading<?= $gas[$i] ?>">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $gas[$i] ?>" aria-expanded="<?= $isFirst ?>" aria-controls="collapse<?= $gas[$i] ?>">
											<?= $data['title'] ?>
										</button>
									</h2>
									<div id="collapse<?= $gas[$i] ?>" class="accordion-collapse collapse <?= $isFirst ?>" aria-labelledby="heading<?= $gas[$i] ?>" data-bs-parent="#default-accordion-a">
										<div class="accordion-body pb-0">
											<ol style="">
                                    <?php foreach ($data['content'] as $step) : ?>
                                        <li><?= $step ?></li>
                                    <?php endforeach; ?>
                                    </ol>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<input type="text" class="form-control" value="Tidak ada instruksi pembayaran." disabled>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="col-md-6 mb-2">
			<div class="col-md-12">
				<div class="payment-group accordion card mb-0" id="default-accordion-a">
					<?php
					$instruction = $this->deposit_method_instruction_model->get_row(['deposit_method_id' => $deposit_method->id]);
					if ($instruction == true) {
						$title = json_decode($instruction->title, true);
						$instruction = json_decode($instruction->instruction, true);
						for ($i = 0; $i < count($title); $i++) {
							$gas = ['One', 'Two', 'Three', 'Four', 'Five'];
							$isFirst = ($i == 0) ? 'show' : ''; // Menandai elemen pertama sebagai yang terbuka
					?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading<?= $gas[$i] ?>">
									<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $gas[$i] ?>" aria-expanded="<?= $isFirst ?>" aria-controls="collapse<?= $gas[$i] ?>">
										<?= $title[$i] ?>
									</button>
								</h2>
								<div id="collapse<?= $gas[$i] ?>" class="accordion-collapse collapse <?= $isFirst ?>" aria-labelledby="heading<?= $gas[$i] ?>" data-bs-parent="#default-accordion-a">
									<div class="accordion-body pb-0">
										<?= $instruction[$i] ?>
									</div>
								</div>
							</div>
						<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
	<?php } ?>
	<div class="col-md-6">
		<strong>Tanggal Deposit</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $this->lib->tanggal_indonesia($target->created_at) ?>" disabled="">
	</div>
	<div class="col-md-6">
		<strong>Pembaruan Terakhir</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $this->lib->tanggal_indonesia($target->updated_at) ?>" disabled="">
	</div>

	<?php if ($deposit_method->type != 'manual') : ?>
		<div class="col-md-6">
			<strong>Result Gateway</strong>
		</div>
		<div class="col-md-6 mb-2">
			<?php
			// Decode JSON
			$result_array = json_decode($target->result, true);

			// Periksa apakah dekoding berhasil
			if ($result_array !== null) {
				// Ganti echo dengan textarea
				echo '<textarea class="form-control" rows="8" disabled>';

				// Tampilkan data hasil dekoding dalam textarea
				foreach ($result_array as $key => $value) {
					echo "• $key: $value\n";
				}

				echo '</textarea>';
			} else {
				// Jika dekoding gagal
				echo "Gagal mendekode JSON.";
			}
			?>
		</div>
	<?php endif; ?>

</div>