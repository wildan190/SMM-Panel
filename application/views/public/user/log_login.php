<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <div class="modal fade filter-data" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Tanggal</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="start_date" id="table-start-date" value="<?= ($this->input->get('start_date')) ? $this->input->get('start_date') : '' ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">sampai</span>
                                    </div>
                                    <input type="date" class="form-control" name="end_date" id="table-end-date" value="<?= ($this->input->get('end_date')) ? $this->input->get('end_date') : '' ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Tampilkan</label>
                                <select class="form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Kata Kunci Cari</label>
                                <input type="text" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="">
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>user/log_login" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Log Masuk</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th class="text-nowrap">Tgl. Masuk</th>
                                <th class="text-nowrap">Device</th>
                                <th class="text-nowrap">Browser</th>
                                <th class="text-nowrap">IP Address</th>
                                <th class="text-nowrap">User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                    <td><?= $value['ud'] ?></td>
                                    <td><?= $value['browser'] ?> <?= $value['browser_version'] ?> (<?= $value['platform'] ?>)</td>
                                    <td><?= $value['ip_address'] ?></td>
                                    <td><?= $value['ua'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="align-items-center mt-2 row text-center text-sm-start">
                    <div class="col-sm mb-2">
                        <div class="text-muted">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <span class="text-muted">Menampilkan <?= currency($awal) ?> sampai <?php
                                                                                            if ($akhir >= $total_data) {
                                                                                                $akhir_page = $total_data;
                                                                                            } else {
                                                                                                $akhir_page = $akhir;
                                                                                            }
                                                                                            ?><?= currency($akhir_page) ?> dari <?= currency($total_data) ?> data.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>