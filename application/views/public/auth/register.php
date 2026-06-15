<div class="auth-wrapper v1">
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url() ?>" class="fs-3 hero-text-gradient fw-bolder">
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="60"><br>
                        <?= website_config('title') ?>
                    </a>
                </div><br>
                <div class="text-center mb-3">
    <a href="<?= base_url('auth/google_login/register') ?>" class="btn btn-outline-primary shadow-sm btn-sm" style="max-width: 230px; width: 100%; display: inline-flex; align-items: center; justify-content: center; padding: 10px 15px; border-radius: 8px; border-width: 1px;">
        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="18" class="me-2">
        <span style="font-size: 13px; font-weight: 600; color: var(--bs-primary);">Daftar dengan Google</span>
    </a>
</div>

                <div class="saprator my-2">
                    <span>Daftar</span>
                </div>
                <form id="form-register" method="post" autocomplete="on">
                    <!-- Input hidden untuk token CSRF -->
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <?php $this->load->view('result') ?>
                    <!-- Input Email -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="useremail">Email</label>
                        <input type="email" class="form-control <?= (form_error('email') ? 'is-invalid' : '') ?>" name="email" placeholder="Masukkan Email anda" value="<?= set_value('email') ?>">
                        <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input No WhatsApp -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="whatsapp">No WhatsApp <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan nomor dengan awalan 628 sebagai kode negara Indonesia"></i></label>
                        <input type="number" class="form-control <?= (form_error('whatsapp') ? 'is-invalid' : '') ?>" name="whatsapp" placeholder="6282277777960" value="<?= set_value('whatsapp') ?>">
                        <?php echo form_error('whatsapp', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="fullname">Nama Lengkap</label>
                        <input type="text" class="form-control <?= (form_error('full_name') ? 'is-invalid' : '') ?>" name="full_name" placeholder=" Nama Lengkap" value="<?= set_value('full_name') ?>">
                        <?php echo form_error('full_name', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input Kelamin -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="gender">Jenis Kelamin</label>
                        <select class="form-control <?= (form_error('gender') ? 'is-invalid' : '') ?>" name="gender">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <?php echo form_error('gender', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input Username -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" class="form-control <?= (form_error('username') ? 'is-invalid' : '') ?>" name="username" placeholder="Masukkan Username" value="<?= set_value('username') ?>">
                        <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input Password -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="userpassword">Password</label>
                        <input type="password" class="form-control <?= (form_error('password') ? 'is-invalid' : '') ?>" name="password" placeholder="Masukkan Password" value="<?= set_value('password') ?>">
                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="userpassword">Konfirmasi Password</label>
                        <input type="password" class="form-control <?= (form_error('confirm_password') ? 'is-invalid' : '') ?>" name="confirm_password" placeholder="Konfirmasi password" value="<?= set_value('confirm_password') ?>">
                        <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Input Kode Referral -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="referral">Kode Referral (Optional)</label>
                        <input type="number" class="form-control" name="referral_code" placeholder="Kode referral (Optional)" value="<?= ($this->session->userdata('referral_code')) ? $this->session->userdata('referral_code') : '' ?>" <?= ($this->session->userdata('referral_code')) ? 'disabled' : '' ?>>
                        <?php echo form_error('referral_code', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <!-- Checkbok Ketentuan Layanan -->
                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-light-primary" type="checkbox" name="terms" id="terms" value="1">
                            <label class="form-check-label text-muted" for="terms">Saya setuju dengan <a href="<?= website_config('terms_link') ?>">Ketentuan
                                    Layanan</a></label>
                        </div>
                    </div>
                    <!-- Captcha -->
                    <div class="mt-3" style="margin: 0 auto;display: table">
                        <?= (website_config('gr_status') == 'on') ? $captcha : '' ?>
                    </div>
                    <!-- Tombol Daftar -->
                    <div class="d-grid mt-3">
                        <button type="button" class="btn btn-primary" onclick="btn_submit();">Daftar</button>
                    </div>
                </form>
                <!-- Link ke Halaman Login -->
                <div class="d-flex justify-content-between align-items-end mt-3">
                    <h6 class="f-w-500 mb-0">Sudah punya akun?</h6>
                    <a href="<?= base_url() ?>auth/login" class="link-primary">Masuk Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>