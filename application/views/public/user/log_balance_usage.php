<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <div class="modal fade filter-data" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel"><i class="fas fa-filter me-2"></i> Filter Data</h5>
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
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <button class="btn btn-primary" type="button">Baris</button>
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
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <button class="btn btn-primary" type="button">Kategori</button>
                                        <select class="form-control" name="category" id="category">
                                            <option value="">Semua</option>
                                            <?php
                                            foreach ($category as $key => $value) {
                                            ?>
                                                <option value="<?= $key ?>" <?= ($this->input->get('category') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="Kata Kunci Cari">
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>user/log_balance_usage" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <?php
                    if ($this->input->get('start_date') and $this->input->get('end_date') <> '') {
                        $awal_tgl = $this->lib->format_date($this->input->get('start_date'));
                        $akhir_tgl = $this->lib->format_date($this->input->get('end_date'));
                        $data = '<div class="alert alert-primary">
                        <div class="alert-body">
                            <i class="fas fa-info-circle me-2"></i>Menampilkan Data dari <em><b>' . $awal_tgl . '</b></em> - <em><b>' . $akhir_tgl . '</b></em>
                        </div>
                    </div>';
                    } else {
                        $data = '';
                    }
                    ?>
                    <?= $data ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-success) !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white text-opacity-75">Kredit (CR)</p>
                                <h4 class="mb-0 text-white">Rp <?= number_format($widget['plus'][0]['rupiah'], 0, ',', '.') ?> (<?= number_format($widget['plus'][0]['total'], 0, ',', '.') ?>)</h4>
                            </div>
                            <div class="avtar">
                                <i class="fas fa-plus-square f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-danger available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-danger) !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white text-opacity-75">Debit (DB)</p>
                                <h4 class="mb-0 text-white">Rp <?= number_format(isset($widget['minus'][0]['rupiah']) ? $widget['minus'][0]['rupiah'] : 0, 0, ',', '.') ?> (<?= number_format(isset($widget['minus'][0]['total']) ? $widget['minus'][0]['total'] : 0, 0, ',', '.') ?>)</h4>
                            </div>
                            <div class="avtar">
                                <i class="fas fa-minus-square f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Mutasi Saldo</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th>Tgl</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Deskripsi</th>
                                <th>Saldo Awal</th>
                                <th>Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table as $key => $value) : ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                    <td><?= strtoupper($value['category']) ?></td>
                                    <td>
                                        <?= ($value['type'] == 'plus') ? '+ Rp ' . number_format($value['amount'], 0, ',', '.') . ' <span class="badge bg-light-success">CR</span>' : '- Rp ' . number_format($value['amount'], 0, ',', '.') . ' <span class="badge bg-light-danger">DB</span>' ?>
                                    </td>
                                    <td><?= $value['description'] ?></td>
                                    <td>Rp <?= number_format($value['before'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($value['after'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($table)) : ?>
                                <tr>
                                    <td colspan="7" align="center">Data belum tersedia.</td>
                                </tr>
                            <?php endif; ?>
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