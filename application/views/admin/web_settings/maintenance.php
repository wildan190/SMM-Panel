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
                        <label class="form-label">Maintenance WEB</label>
                        <select class="select2-data form-control" name="mt_web">
                            <option value="0" <?= (website_config('mt_web') == 0) ? 'selected' : '' ?>>Tidak <?= (website_config('mt_web') == 0) ? '(Dipilih)' : '' ?></option>
                            <option value="1" <?= (website_config('mt_web') == 1) ? 'selected' : '' ?>>Ya <?= (website_config('mt_web') == 1) ? '(Dipilih)' : '' ?></option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Maintenance API</label>
                        <select class="select2-data form-control" name="mt_api">
                            <option value="0" <?= (website_config('mt_api') == 0) ? 'selected' : '' ?>>Tidak <?= (website_config('mt_api') == 0) ? '(Dipilih)' : '' ?></option>
                            <option value="1" <?= (website_config('mt_api') == 1) ? 'selected' : '' ?>>Ya <?= (website_config('mt_api') == 1) ? '(Dipilih)' : '' ?></option>
                        </select>
                    </div>
                </div>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>