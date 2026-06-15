<div class="auth-wrapper v1">
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url() ?>" class="fs-3 hero-text-gradient fw-bolder">
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="60"><br>
                        <?= website_config('brand_login') ?>
                    </a>
                </div><br>
                <div class="text-center mb-3">
    <a href="<?= base_url('auth/google_login/login') ?>" class="btn btn-outline-primary shadow-sm btn-sm" style="max-width: 230px; width: 100%; display: inline-flex; align-items: center; justify-content: center; padding: 10px 15px; border-radius: 8px; border-width: 1px;">
        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="18" class="me-2">
        <span style="font-size: 13px; font-weight: 600; color: var(--bs-primary);">Login dengan Google</span>
    </a>
</div>

                <div class="saprator my-3">
                    <span>Masuk</span>
                </div>
                <h5 class="text-center text-muted f-w-500 mb-3">👋 Silahkan masuk ke akun Anda</h5>
                <form method="post" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <?php $this->load->view('result') ?>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control <?= (form_error('username') ? 'is-invalid' : '') ?>" name="username" id="username" placeholder="Username" value="<?= set_value('username') ?>">
                        <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control pe-5 <?= (form_error('password') ? 'is-invalid' : '') ?>" placeholder="Password" id="password-input" value="<?= set_value('password') ?>">
                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember" value="1" checked>
                            <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                        </div>
                        <a href="<?= base_url() ?>auth/forgot" class="h6 text-secondary f-w-400 mb-0">Lupa Password?</a>
                    </div>
                    <div class="mt-3" style="margin: 0 auto;display: table">
                        <?= (website_config('gr_status') == 'on') ? $captcha : '' ?>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Masuk</button>
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