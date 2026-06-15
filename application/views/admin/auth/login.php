<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="60"><br>
                            <a href="<?= base_url() ?>" class="fs-3 fw-bolder hero-text-gradient"><?= website_config('title') ?></a>
                        </div>
                        <hr>
                        <div class="">
                            <form method="post" class="">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <?php $this->load->view('result') ?>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control <?= (form_error('username') ? 'is-invalid' : '') ?>" name="username" id="username" placeholder="Username">
                                    <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password</label>

                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" name="password" class="form-control pe-5 <?= (form_error('password') ? 'is-invalid' : '') ?>" placeholder="Password" id="password-input">
                                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex mt-1 justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember" value="1" checked>
                                        <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <button class="btn btn-primary text-white w-100" type="submit">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end row -->