<div class="row">
    <div class="col-md-12">
        <!-- <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <div class="modal fade filter-data" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-md-3">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2 form-control" name="row">
                                    <option value="10">10 baris</option>
                                    <option value="25">25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <label class="form-label">Tanggal</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="start_date" value="">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">sampai</span>
                                    </div>
                                    <input type="date" class="form-control" name="end_date" id="table-end-date" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kolom Sortir</label>
                                <select class="select2 form-control" name="sort_field">
                                    <option value="">Kolom...</option>
                                    <option value="id">ID</option>
                                    <option value="rate">RATE POINT</option>
                                    <option value="point">JUMLAH POINT</option>
                                    <option value="balance">SALDO DITERIMA</option>
                                    <option value="created_at">TGL. PAYOUT</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Tipe Sortir</label>
                                <select class="select2 form-control" name="sort_type">
                                    <option value="">Tipe...</option>
                                    <option value="asc">ASC</option>
                                    <option value="desc">DESC</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kolom Cari</label>
                                <select class="select2 form-control" name="search_field">
                                    <option value="">Kolom...</option>
                                    <option value="id">ID</option>
                                    <option value="rate">RATE POINT</option>
                                    <option value="point">JUMLAH POINT</option>
                                    <option value="balance">SALDO DITERIMA</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kata Kunci Cari</label>
                                <input type="text" class="form-control" name="search_value" placeholder="Kata Kunci..." value="">
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>point/history" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Payout</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th>Rate Point</th>
                                <th>Jumlah Point</th>
                                <th>Saldo Diterima</th>
                                <th>Tgl. Payout</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['rate'] ?></td>
                                    <td><?= currency($value['amount']) ?></td>
                                    <td>Rp <?= currency($value['balance']) ?></td>
                                    <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                </tr>
                            <?php
                            }
                            if (empty($table)) {
                            ?>
                                <tr>
                                    <td colspan="5" align="center">Data belum tersedia.</td>
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