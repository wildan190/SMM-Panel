<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <a href="javascript:;" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target=".info-monitoring"><i class="fas fa-info-circle fs-6 me-2"></i>Informasi Monitoring</a>
        <div class="modal fade info-monitoring" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Informasi Monitoring</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-0">
                            <h5 class="alert-heading">Informasi Untuk Monitoring Layanan !</h5>
                            <div class="alert-body">
                                <ul class="mb-0">
                                    <li>Fitur ini dibuat untuk pengguna yang ini melihat kecepatan <b>waktu proses</b>
                                        pesanan pada layanan.</li>
                                    <li><b>Waktu proses</b> yang terdapat dibawah ini merupakan 1 pesanan terakhir dari
                                        layanan tersebut.</li>
                                    <li><b>Waktu proses</b> yang terdapat dibawah ini bukan <b>waktu rata-rata</b>, Anda
                                        bisa melihat pada halaman Daftar Layanan untuk melihat <b>waktu rata-rata</b>
                                        pada tiap layanan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade filter-data" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-md-4">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2 form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>>
                                            <?= $value ?> baris
                                        </option>

                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Filter Kategori</label>
                                <select class="select2 form-control" name="category" id="category">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    foreach ($categories as $key => $value) {
                                    ?>
                                        <option value="<?= $value['id'] ?>" <?= ($this->input->get('category') == $value['id']) ? 'selected' : '' ?>>
                                            <?= $value['name'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Cari ID Layanan</label>
                                <input type="number" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="ID Layanan...">
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>page/monitoring" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
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
                <h4 class="mb-0"><i class="fas fa-desktop me-2"></i>Monitoring Layanan</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-nowrap table-bordered align-middle table-hover m-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th width="20%; !important">Nama Layanan <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Layanan dengan tanda ♻️ artinya layanan tersebut dapat di <em>Refill</em>."><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Jumlah <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Jumlah Pesanan"><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Harga</th>
                                <th class="text-nowrap">Waktu Proses <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Waktu Proses</em> didasarkan pada 1 pesanan terakhir dengan status pesanan <em>Success</em>."><i class="fas fa-exclamation-circle"></i></a>
                                </th>
                                <th>Pembaruan Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $current_category = '';
                            foreach ($table as $value) {
                                if ($value['category_name'] != $current_category) {
                                    echo '<tr><th colspan="6" style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
                                                <h5 class="d-none d-md-block d-lg-block text-center mb-0"><b>' . $value['category_name'] . '</b></h5>
                                                <h5 class="d-block d-md-none d-lg-none mb-0" style="margin-top: 0;"><b>' . $value['category_name'] . '</b></h5>
                                            </th></tr>';
                                    $current_category = $value['category_name'];
                                }
                            ?>
                                <tr>
                                    <td>
                                        <a href="javascript:;" onclick="detail_service(<?php echo $value['id']; ?>);">
                                            <?= $value['id'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $value['name'] ?>
                                        <?php if ($value['refill'] == 1) { ?>♻️
                                    <?php } ?>
                                    </td>
                                    <td>
                                        <?= currency($value['last_order_quantity']) ?>
                                    </td>
                                    <td>
                                        Rp
                                        <?= currency($value['last_order_price']) ?>
                                    </td>
                                    <td>
                                        <?= $this->lib->timeProcess($value['last_order_created'], $value['last_order_updated']) ?>
                                    </td>
                                    <td>
                                        <?= $this->lib->time_elapsed_string($value['last_order_updated']) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class=" align-items-center mt-2 row text-center text-sm-start">
                    <div class="col-sm mb-2">
                        <div class="text-muted">
                            <?= $pagination_links ?>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <span class="text-muted">
                            Menampilkan
                            <?= currency($awal) ?> sampai
                            <?= ($akhir >= $total_data) ? currency($total_data) : currency($akhir) ?> dari
                            <?= currency($total_data) ?> data.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail_modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3" id="detail_modal_body">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#rows').on('change', function() {
            var rows = $('#rows').val();
            var category = $('#category').val();
            var search = $('#search').val();
            window.location = "<?= base_url('page/monitoring') ?>?rows=" + rows + "&category=" + category + "&search=" + search;
        });
        $('#category').on('change', function() {
            var rows = $('#rows').val();
            var category = $('#category').val();
            var search = $('#search').val();
            window.location = "<?= base_url('page/monitoring') ?>?rows=" + rows + "&category=" + category + "&search=" + search;
        });
    });
</script>