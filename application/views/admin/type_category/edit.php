<div class="row justify-content-center">
	<div class="col-lg-8">
		<div class="text-left mb-3">
			<a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-secondary"><i class="fa fa-reply fa-fw"></i> Kembali</a>
		</div>
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="fas fa-fw fa-tag"></i> Ubah Kategori</h5>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label>Nama *</label>
						<input type="text" class="form-control" name="name" value="<?= $target->name ?>">
					</div>
					<div class="form-group">
						<label>Tipe *</label>
						<span class="form-control" style="padding: 4px;">
							<select class="form-control select2" name="type" required>
								<option value="">-- Pilih Salah Satu --</option>
								<option value="SosialMedia">Sosial Media</option>
								<option value="Pulsa">Pulsa</option>
								<option value="PaketInternet">Paket Internet</option>
								<option value="PaketSMS">Paket SMS</option>
								<option value="VoucherGame">Voucher Game</option>
								<option value="Games">Games</option>
								<option value="Emoney">Emoney</option>
								<option value="TokenListrik">TokenListrik</option>
							</select>
						</span>
					</div>
					<div class="text-right">
						<button type="reset" class="btn btn-secondary">Reset</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>