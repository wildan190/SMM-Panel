<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Akun</h4>
            </div>
            <div class="card-body pb-3">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="<?= base_url() ?>user/setting?act=foto" enctype="multipart/form-data">
                            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="form-label">Profil</label><br>
                                    <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" class="rounded-circle" style="width: 80px;" alt="Profil <?= user('full_name') ?>">
                                </div>
                                <div class="form-group col-md-9">
                                    <label class="form-label">Foto Profil Baru (.jpg, .jpeg, .png)</label>
                                    <input class="form-control mb-0 <?= (form_error('foto_profil') ? 'is-invalid' : '') ?>" type="file" name="foto_profil" id="foto_profil" accept="image/png, image/jpeg, image/jpg">
                                    <?php echo form_error('target', '<div class="invalid-feedback">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="mb-0">
                                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
                                <a href="<?= base_url() ?>user/setting?act=reset_foto" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" action="<?= base_url() ?>user/setting?act=profil">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Username</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= user('username') ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" value="<?= user('email') ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="full_name" value="<?= user('full_name') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">WhatsApp <small class="text-danger">*</small> <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Isi dengan awalan (628) bukan (08) contoh 6282265******"><i class="fas fa-exclamation-circle"></i></a></label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="whatsapp" value="<?= user('whatsapp') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Telegram <small class="text-danger">*</small> <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="isi username (tanpa @)"><i class="fas fa-exclamation-circle"></i></a></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="telegram" value="<?= user('telegram') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Gender</label>
                                <div class="col-md-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= (user('gender') == 'male') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="male"><i class="fas fa-male me-1"></i>Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= (user('gender') == 'female') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="female"><i class="fas fa-female me-1"></i>Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="mb-0">
                                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-cog fs-6 me-2"></i>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cog me-2"></i>Ubah Password</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST" action="<?= base_url() ?>user/setting?act=password">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_new_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-cog fs-6 me-2"></i>Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>