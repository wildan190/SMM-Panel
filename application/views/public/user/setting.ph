<div class="row">
	<div class="col-md12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Akun</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= user('email') ?>" readonly />
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= user('username') ?>" readonly />
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">Nama Lengkap <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="full_name" value="<?= user('full_name') ?>" id="full_name" />
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">WhatsApp <small class="text-danger">*</small></label>
                            <input type="number" class="form-control" name="whatsapp" value="<?= user('whatsapp') ?>" id="whatsapp" />
                            <small class="text-danger">Isi dengan awalan (628) bukan (08) contoh 6282265******</small>
                        </div>
                        <div class="form-group mb-2 col-md-12">
                            <label class="form-label">Ubah Tampilan <small class="text-danger">*</small></label>
									<select class="form-control select2" name="layout">
										<option value="<?= user('layout') ?>"><?= user('layout') ?> (Selected)</option>
										<option value="preset-1">Preset 1</option>
										<option value="preset-2">Preset 2</option>
										<option value="preset-3">Preset 3</option>
										<option value="preset-4">Preset 4</option>
										<option value="preset-5">Preset 5</option>
										<option value="preset-6">Preset 6</option>
										<option value="preset-7">Preset 7</option>
										<option value="preset-8">Preset 8</option>
										<option value="preset-9">Preset 9</option>
										<option value="preset-10">Preset 10</option>
									</select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-2 col-md-12">
                            <label class="form-label">Password <small class="text-danger">*</small></label>
                            <input type="password" class="form-control <?= (form_error('password') ? 'is-invalid' : '') ?>" name="password" id="password" />
                            <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                    </div>
                  <div class="accordion card" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                          Ubah Password
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          
                    <div class="row">
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" />
                            <small class="text-danger">Kosongkan jika tidak ingin membuat Password baru.</small>
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" />
                            <small class="text-danger">Kosongkan jika tidak ingin membuat password baru.</small>
                        </div>
                    </div>
                        </div>
                      </div>
                    </div>
                  </div><hr>
                    <div class="hstack gap-1 justify-content-end">
						<button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane fs-6 me-2"></i>Ubah</button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
               
<script type="text/javascript">
    function copy_text() {
        document.getElementById("reff").select();
        document.execCommand("copy");
        swal('Berhasil','Berhasil mendapatkan data','success');
    }
</script>