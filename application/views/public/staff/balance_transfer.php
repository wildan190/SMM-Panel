<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-users"></i> Transfer Saldo</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group mb-2">
                        <label>Username (Penerima Saldo) *</label>
                        <input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Transfer Saldo *</label>
                        <input type="number" class="form-control" name="amount">
                        <small class="text-danger">*Min. 1.000</small>
                    </div>
                    <hr>
                    <div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane fs-6 me-2"></i>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>