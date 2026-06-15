<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-primary"><i class="fas fa-user-lock me-2"></i>Google Auth</h4>
            </div>
            <div class="card-body pb-6">
            <div class="alert alert-primary">
                <div class="alert-body">
                    <i class="fas fa-info-circle me-2"></i>Google Auth hanya tersedia pada halaman <em><b>Login</b></em> dan <em><b>Register</b></em>.
                </div>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="mb-3">
                        <label class="form-label">Client ID</label>
                        <input type="text" class="form-control" name="google_client_id" value="<?= website_config('google_client_id') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Client Secret</label>
                        <input type="text" class="form-control" name="google_client_secret" value="<?= website_config('google_client_secret') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Redirect URL</label>
                        <input type="text" class="form-control" name="google_redirect_url" value="<?= website_config('google_redirect_url') ?>">
                        <small class="text-muted">Redirect URI di Google Console harus sama dengan ini.</small>
                    </div>
                    <button type="submit" name="submit_google" class="btn btn-primary w-100">Simpan Google Auth</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-primary"><i class="fab fa-google me-2"></i>Google Recaptcha V2</h4>
            </div>
            <div class="card-body pb-3">
            <div class="alert alert-primary">
                <div class="alert-body">
                    <i class="fas fa-info-circle me-2"></i>Google Recaptcha V2 hanya tersedia pada halaman <em><b>Login</b></em>, <em><b>Register</b></em>, <em><b>Forgot Password</b></em>, dan <em><b>Reset Password</b></em>.
                </div>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="mb-3">
                        <label class="form-label d-block">Status Recaptcha</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="gr_status_check" <?= (website_config('gr_status') == 'on') ? 'checked' : '' ?>>
                            <label class="form-check-label"><?= (website_config('gr_status') == 'on') ? 'Active' : 'Inactive' ?></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site Key</label>
                        <input type="text" class="form-control" name="gr_site_key" value="<?= website_config('gr_site_key') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Secret Key</label>
                        <input type="text" class="form-control" name="gr_secret_key" value="<?= website_config('gr_secret_key') ?>">
                    </div>
                    <button type="submit" name="submit_recaptcha" class="btn btn-primary w-100">Simpan ReCaptcha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('gr_status_check').addEventListener('change', function() {
    window.location.href = '<?= base_url('admin/web_settings/grecaptcha?gr_status=') ?>' + (this.checked ? 'on' : 'off');
});
</script>
