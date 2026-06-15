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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <button class="btn btn-primary" type="button">Tipe</button>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">Semua</option>
                                            <?php
                                            foreach ($type as $key => $value) {
                                            ?>
                                                <option value="<?= $key ?>" <?= ($this->input->get('type') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>page/service_log" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-history me-2"></i>Update Layanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-nowrap">ID Layanan</th>
                                        <th class="text-nowrap">Nama Layanan</th>
                                        <th>Tipe</th>
                                        <th>Keterangan</th>
                                        <th class="text-nowrap">Tgl. Pembaruan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($table)) {
                                        foreach ($table as $key => $value) {
                                            if ($value['type'] == 'price_increased') {
                                                $bg = 'warning';
                                                $icon = 'fas fa-arrow-circle-up fs-6';
                                            } elseif ($value['type'] == 'price_decreased') {
                                                $bg = 'success';
                                                $icon = 'fas fa-arrow-circle-down fs-6';
                                            } elseif ($value['type'] == 'update_min' or $value['type'] === 'update_max') {
                                                $bg = 'info';
                                                $icon = 'far fa-dot-circle fs-6';
                                            } elseif ($value['type'] == 'enabled') {
                                                $bg = 'success';
                                                $icon = 'fas fa-check-circle fs-6';
                                            } elseif ($value['type'] == 'insert') {
                                                $bg = 'success';
                                                $icon = 'fas fa-plus-circle fs-6';
                                            } else {
                                                $bg = 'danger';
                                                $icon = 'fas fa-times-circle fs-6';
                                            }
                                    ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);"><b><?= $value['service_id'] ?></b></a>
                                                </td>
                                                <td><?= $value['service_name'] ?></td>
                                                <td class="text-center"><span class="btn btn-sm btn-<?= $bg ?>"><i class="<?= $icon ?>"></i><?php if ($value['type'] == 'update_min' or $value['type'] == 'update_max') { ?>
                                                            JUMLAH <?= ($value['type'] == 'update_min' ? 'MINIMAL' : 'MAKSIMAL') ?>

                                                        <?php } elseif ($value['type'] == 'price_increased' or $value['type'] == 'price_decreased') { ?>
                                                            <?= ($value['type'] == 'price_increased' ? 'KENAIKAN' : 'PENURUNAN') ?> HARGA
                                                        <?php } elseif ($value['type'] == 'disabled') { ?>
                                                            MAINTENANCE
                                                        <?php } elseif ($value['type'] == 'enabled') { ?>
                                                            LAYANAN AKTIF
                                                        <?php } elseif ($value['type'] == 'insert') { ?>
                                                            LAYANAN BARU
                                                        <?php } ?>
                                                </td>
                                                <td class="text-nowrap"><?php if ($value['type'] == 'update_min' or $value['type'] == 'update_max') { ?>
                                                        Dari <b><?= currency($value['before_update']) ?></b> ke <b><?= currency($value['after_update']) ?></b>

                                                    <?php } elseif ($value['type'] == 'price_increased' or $value['type'] == 'price_decreased') { ?>
                                                        Dari <b>Rp <?= currency($value['before_update']) ?></b> ke <b>Rp <?= currency($value['after_update']) ?></b>
                                                    <?php } elseif ($value['type'] == 'disabled') { ?>
                                                        Layanan tidak bisa digunakan
                                                    <?php } elseif ($value['type'] == 'enabled') { ?>
                                                        Layanan bisa digunakan
                                                    <?php } elseif ($value['type'] == 'insert') { ?>
                                                        Layanan baru ditambahkan
                                                    <?php } ?>
                                                </td>
                                                <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        if ($value <= 0) {
                                        ?>
                                            <tr>
                                                <td colspan="5" align="center">Data belum tersedia.</td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
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
                                <?php
                                if ($total_data > 0) {
                                ?>
                                    <span class="text-muted">Menampilkan <?= currency($awal) ?> sampai <?php
                                                                                                        if ($akhir >= $total_data) {
                                                                                                            $akhir_page = $total_data;
                                                                                                        } else {
                                                                                                            $akhir_page = $akhir;
                                                                                                        }
                                                                                                        ?><?= currency($akhir_page) ?> dari <?= currency($total_data) ?> data.</span>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>