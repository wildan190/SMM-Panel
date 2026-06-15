<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title_forgot" value="<?= website_config('title_forgot') ?>">
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description_forgot" rows="5"><?= website_config('meta_description_forgot') ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <textarea class="form-control" name="meta_keywords_forgot" rows="5"><?= website_config('meta_keywords_forgot') ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control" name="brand_forgot" value="<?= website_config('brand_forgot') ?>">
                </div>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>