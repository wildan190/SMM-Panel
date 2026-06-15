<div class="row justify-content-center">
    <div class="col-md-12 text-center">
        <h3 class="text-uppercase"><i class="fas fa-trophy text-warning me-2"></i>Pengguna Teratas<i class="fas fa-trophy text-warning ms-2"></i></h3>
        <p>Dibawah ini merupakan top 10 pengguna dengan total pemesanan & deposit tertinggi bulan ini.<br />Terima kasih telah menjadi pelanggan setia kami.</p>
    </div>
    <?php if (website_config('top_order') == 1) { ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>10 Pesanan Teratas</h4>
                </div>
                <div class="card-body pb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($order as $key => $value) {
                                    $label = "table-secondary"; // Default label untuk 4 sampai 10

                                    // Tentukan label sesuai dengan nomor
                                    switch ($no) {
                                        case 1:
                                            $label = "table-info";
                                            break;
                                        case 2:
                                            $label = "table-success";
                                            break;
                                        case 3:
                                            $label = "table-warning";
                                            break;
                                    }

                                    // Tampilkan baris tabel
                                ?>
                                    <tr class="<?= $label ?>">
                                        <td><?= $no ?></td>
                                        <td><?= ($no == 1) ? '<i class="fas fa-trophy text-warning"></i> ' : '' ?><?= $value['full_name'] ?></td>
                                        <td>Rp <?= number_format($value['rupiah'], 0, ',', '.') ?> (<?= number_format($value['total'], 0, ',', '.') ?> Pemesanan)</td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (website_config('top_deposit') == 1) { ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>10 Deposit Teratas</h4>
                </div>
                <div class="card-body pb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($deposit as $key => $value) {
                                    $label = "table-secondary"; // Default label untuk 4 sampai 10

                                    // Tentukan label sesuai dengan nomor
                                    switch ($no) {
                                        case 1:
                                            $label = "table-info";
                                            break;
                                        case 2:
                                            $label = "table-success";
                                            break;
                                        case 3:
                                            $label = "table-warning";
                                            break;
                                    }

                                    // Tampilkan baris tabel
                                ?>
                                    <tr class="<?= $label ?>">
                                        <td><?= $no ?></td>
                                        <td><?= ($no == 1) ? '<i class="fas fa-trophy text-warning"></i> ' : '' ?><?= $value['full_name'] ?></td>
                                        <td>Rp <?= number_format($value['rupiah'], 0, ',', '.') ?> (<?= number_format($value['total'], 0, ',', '.') ?> Deposit)</td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (website_config('top_service') == 1) { ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>10 Layanan Teratas</h4>
                </div>
                <div class="card-body pb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($service as $key => $value) {
                                    $label = "table-secondary"; // Default label untuk 4 sampai 10

                                    // Tentukan label sesuai dengan nomor
                                    switch ($no) {
                                        case 1:
                                            $label = "table-info";
                                            break;
                                        case 2:
                                            $label = "table-success";
                                            break;
                                        case 3:
                                            $label = "table-warning";
                                            break;
                                    }

                                    // Tampilkan baris tabel

                                    // Tampilkan baris tabel
                                ?>
                                    <tr class="<?= $label ?>">
                                        <td><?= $no ?></td>
                                        <td><?= ($no == 1) ? '<i class="fas fa-trophy text-warning"></i> ' : '' ?><?= $value['name'] ?></td>
                                        <td><?= number_format($value['total'], 0, ',', '.') ?> Pemesanan (Rp <?= number_format($value['rupiah'], 0, ',', '.') ?>)</td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>