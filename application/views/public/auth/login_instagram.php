<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">
        
            <div class="card-body p-4"> 
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                </div>
                <div class="p-2 mt-4">
                    <form method="post" class="">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
						<?php $this->load->view('result') ?> 
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control <?= (form_error('username') ? 'is-invalid' : '') ?>" name="username" id="username" placeholder="Username">
                            <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="mb-3">
                            <div class="float-end">
                                <a href="<?= base_url() ?>auth/forgot" class="text-muted">Lupa Password?</a>
                            </div>
                            <label class="form-label" for="password-input">Password</label>
                            
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" name="password" class="form-control pe-5 <?= (form_error('password') ? 'is-invalid' : '') ?>" placeholder="Password" id="password-input">
                                <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>

                        <div class="form-check">
                        	<input type="checkbox" class="form-check-input" id="checkbox-signin" value="1" checked>
                            <label class="form-check-label" for="auth-remember-check">Ingat Saya</label>
                        </div>
                        
                        <div class="mt-4">
                            <button class="btn btn-blue text-white w-100" type="submit">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0">Belum punya akun ?  <a href="<?= base_url() ?>auth/register" class="fw-semibold text-primary text-decoration-underline"> Daftar </a> </p>
        </div>

    </div>
</div>
<!-- end row -->
