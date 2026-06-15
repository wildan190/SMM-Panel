<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-cogs me-2"></i>
                    <?= $page ?>
                </h4>
            </div>
            <div class="card-body pb-3">
                <form method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">ID Provider (Pisahkan dengan koma)</label>
                            <textarea class="form-control" name="api_service_id" id="api_service_id"
                                placeholder="Masukkan ID Provider dipisahkan dengan koma (,)"></textarea>
                        </div>
                    </div>
                    <div class="mb-0 float-end">
                        <button type="submit" class="btn btn-primary"><i
                                class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>