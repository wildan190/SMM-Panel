<div class="auth-wrapper v1">
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url() ?>" class="fs-3 hero-text-gradient fw-bolder">
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="60"><br>
                        <?= website_config('title') ?>
                    </a>
                </div>
                <div class="saprator my-3">
                    <span>Reset Password</span>
                </div>
                <h5 class="text-center f-w-500 mb-3">Silahkan isi dengan kata sandi baru</h5>
                <form method="post" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <?php $this->load->view('result') ?>
                    <div class="mb-3">
                        <label for="password" class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= $user->username ?>" disabled>
                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="text" class="form-control <?= (form_error('password') ? 'is-invalid' : '') ?>" name="password" id="password" placeholder="Password">
                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="text" class="form-control <?= (form_error('confirm_password') ? 'is-invalid' : '') ?>" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password Baru">
                        <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>

                    <div class="mb-3" style="margin: 0 auto;display: table">
                        <?= (website_config('gr_status') == 'on') ? $captcha : '' ?>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
                <div class="d-flex justify-content-between align-items-end mt-3">
                    <h6 class="f-w-500 mb-0">Belum punya akun?</h6>
                    <a href="<?= base_url() ?>auth/register" class="link-primary">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>