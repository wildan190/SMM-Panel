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
                            <label class="form-label">Pilih API</label>
                            <select class="form-control select2-data" name="api_id" id="api_id">
                                <option value="">Pilih API</option>
                                <?php foreach ($api as $api_item): ?>
                                    <option value="<?= $api_item['id'] ?>">
                                        <?= $api_item['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">ID Provider</label>
                            <input type="number" class="form-control" name="api_service_id" id="api_service_id"
                                placeholder="PROVIDER ID" value="">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea type="text" class="form-control" name="description" id="description"
                                placeholder="Deskripsi" rows="8"></textarea>
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