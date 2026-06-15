<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label">Host</label>
                        <input type="text" class="form-control" name="smtp_host" value="<?= website_config('smtp_host') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="smtp_username" value="<?= website_config('smtp_username') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="smtp_password" <?= ($this->input->post('smtp_password') == '') ? '' : 'disabled' ?> autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Encrypt</label>
                        <select class="select2-data form-control" name="smtp_encrypt">
                            <option value="ssl" <?= (website_config('smtp_encrypt') == 'ssl') ? 'selected' : '' ?>>SSL <?= (website_config('smtp_encrypt') == 'ssl') ? '(Dipilih)' : '' ?></option>
                            <option value="tls" <?= (website_config('smtp_encrypt') == 'tls') ? 'selected' : '' ?>>TLS <?= (website_config('smtp_encrypt') == 'tls') ? '(Dipilih)' : '' ?></option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Port</label>
                        <input type="number" class="form-control" name="smtp_port" value="<?= website_config('smtp_port') ?>" autocomplete="off">
                    </div>
                </div>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>