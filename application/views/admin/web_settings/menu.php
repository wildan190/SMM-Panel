<div class="col-md-12">
    <div class="card">
        <div class="card-body p-2" style="margin-bottom: -4px;">
            <div class="row gx-1">

                <!-- Baris Pertama -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/general') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'general' ? 'active' : '') ?>">Umum</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/landing_page') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'landing_page' ? 'active' : '') ?>">Landing Page</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/login_page') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'login_page' ? 'active' : '') ?>">Login Page</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/register_page') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'register_page' ? 'active' : '') ?>">Register Page</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/forgot_page') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'forgot_page' ? 'active' : '') ?>">Forgot Page</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/benefit') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'benefit' ? 'active' : '') ?>">Benefit & Referral</a>
                </div>

                <!-- Baris Kedua -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/gateway') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'gateway' ? 'active' : '') ?>">WA Gateway</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/smtp') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'smtp' ? 'active' : '') ?>">SMTP</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/grecaptcha') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'grecaptcha' ? 'active' : '') ?>">Google & Recaptcha V2</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/maintenance') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'maintenance' ? 'active' : '') ?>">Maintenance</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/custom_statistic') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'custom_statistic' ? 'active' : '') ?>">Custom Statistic</a>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-grid">
                    <a href="<?= base_url('admin/web_settings/payment_gateway') ?>" class="p-2 btn btn-outline-primary d-flex justify-content-center mb-1 <?= ($this->uri->segment(3) == 'payment_gateway' ? 'active' : '') ?>">Payment Gateway</a>
                </div>
            </div>
        </div>
    </div>
</div>