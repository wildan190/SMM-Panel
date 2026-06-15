<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
            </div>
            <div class="card-body">
                <form method="post" class="mb-4">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label class="form-label">Pilih Kategori</label>
                            <select class="form-control select2-data" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($service_category as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan semua layanan dalam kategori ini?');"><i class="fas fa-power-off me-2"></i>Nonaktifkan Layanan</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Waktu Penonaktifan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deactivation_history as $history): ?>
                                <tr>
                                    <td><?= $history->category_name ?></td>
                                    <td><?= $history->created_at ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2-data').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
