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
                <div class="saprator my-2">
                    <span>Lupa Password</span>
                </div>
                <div class="my-3 text-center">
                    <p class="text-muted">Pastikan <em><b>email</b></em> atau <em><b>whatsapp</b></em> pada akun Anda
                        aktif.</p>
                </div>
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <?php $this->load->view('result') ?>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control <?= (form_error('email_or_whatsapp') ? 'is-invalid' : '') ?>" for="email_or_whatsapp" name="email_or_whatsapp" id="email_or_whatsapp" placeholder="Masukkan Email/WhatsApp">
                        <?php echo form_error('email_or_whatsapp', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>

                    <div class="form-check">
                        <input type="radio" class="form-check-input input-primary" name="recovery_method" id="email" value="email" checked>
                        <label class="form-check-label" for="email">Melalui Email</label>
                    </div>

                    <div class="form-check">
                        <input type="radio" class="form-check-input input-primary" name="recovery_method" id="whatsapp" value="whatsapp">
                        <label class="form-check-label" for="whatsapp">Melalui WhatsApp</label>
                    </div>

                    <div class="mt-3" style="margin: 0 auto; display: table">
                        <?= (website_config('gr_status') == 'on') ? $captcha : '' ?>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-end mt-3">
                    <a href="<?= base_url() ?>auth/login" class="link-primary">Masuk</a>
                    <a href="<?= base_url() ?>auth/register" class="link-primary">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>