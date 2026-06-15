<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cog me-2"></i>Perbarui Cookie</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label class="form-label">Masukkan Cookie <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="cookie"><?= website_config('cookie') ?></textarea>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-cog fs-6 me-2"></i>Ubah Cookie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>