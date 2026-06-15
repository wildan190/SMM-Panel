<div class="row">
    <?php if (empty(user('telegram'))) { ?>
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle fs-6 me-1"></i><strong>Pemberitahuan!</strong><br /> Username Telegram kamu masih kosong, harap perbarui <a href="<?= base_url() ?>user/setting">disini</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } ?>
    <div class="col-12 mb-4">
        <div class="card h-100" style="position: relative; overflow: hidden; border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);">
            <img src="<?= base_url() ?>assets/images/widget/img-status-7.svg" 
                 style="position: absolute; right: -10px; top: -10px; width: 150px; height: auto; z-index: 1; opacity: 0.8;" 
                 class="img-fluid" />
            
            <div class="card-body" style="position: relative; z-index: 2;">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h1 class="text-primary fw-bold mb-2" style="letter-spacing: 3px; font-size: 1.7rem;">W E L C O M E</h1>
                        <div class="text-dark">
                            <p class="mb-1">
                                <b>
                                <?php 
                                    $waktu = gmdate("H:i", time() + 7 * 3600); 
                                    $jam = explode(":", $waktu)[0];
                                    if ($jam >= 0 && $jam < 10) $ucapan = "Selamat Pagi";
                                    else if ($jam >= 10 && $jam < 15) $ucapan = "Selamat Siang";
                                    else if ($jam >= 15 && $jam < 18) $ucapan = "Selamat Sore";
                                    else $ucapan = "Selamat Malam";
                                    echo $ucapan; 
                                ?> <?= user('full_name') ?></b>,<br>
                                Jika anda perlu bantuan silahkan kirim Tiket atau bisa langsung via Live Chat dipojok kanan bawah
                            </p>
                            <p class="mb-0" style="font-size: 0.9rem;">
                                <span class="me-1">♻️</span> Pesanan & Deposit tetap berjalan normal dan diproses otomatis nonstop.
                            </p>
                        </div>
                    </div>

                    <div class="col-4 text-end">
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" 
                             style="border-radius: 50%; width: 75px; height: 75px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" 
                             alt="Logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-body pc-component">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <i class="fas fa-fire-alt me-2"></i>Layanan Rekomendasi
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-xs align-middle m-0">
                                        <?php if (!empty($service_recommended)) { 
                                            foreach ($service_recommended as $key => $value) { ?>
                                            <tr>
                                                <td class="text-muted">#<?= $value['service_id'] ?></td>
                                                <td>
                                                    <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);" class="text-reset text-wrap fs-14 mb-0">
                                                        <?= $value['service_name'] ?></a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url() ?>order/single?id=<?= $value['service_id'] ?>">
                                                        <div class="avtar avtar-xs bg-primary bg-gradient"><i class="fas fa-cart-plus text-white"></i></div>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } } else { ?>
                                            <tr><td colspan="3"><h6 class="text-center">Data belum tersedia.</h6></td></tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-star me-1"></i>Layanan Terlaris Bulan Ini
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-xs align-middle m-0">
                                        <?php if (!empty($service_top)) { 
                                            foreach ($service_top as $key => $value) { ?>
                                            <tr>
                                                <td class="text-muted">#<?= $value['id'] ?></td>
                                                <td>
                                                    <a href="javascript:;" onclick="detail_service(<?php echo $value['id']; ?>);" class="text-reset text-wrap fs-14 mb-0">
                                                        <?= $value['name'] ?></a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url() ?>order/single?id=<?= $value['id'] ?>">
                                                        <div class="avtar avtar-xs bg-primary bg-gradient"><i class="fas fa-cart-plus text-white"></i></div>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } } else { ?>
                                            <tr><td colspan="3"><h6 class="text-center">Data belum tersedia.</h6></td></tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-6 mb-4">
    <div id="carouselUltraPedia" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php 
            $get_banners = $this->db->get('banners')->result_array();
            if (!empty($get_banners)) :
                foreach ($get_banners as $key => $b) : ?>
                    <button type="button" data-bs-target="#carouselUltraPedia" data-bs-slide-to="<?= $key ?>" class="<?= ($key == 0) ? 'active' : '' ?>"></button>
                <?php endforeach; 
            else : ?>
                <button type="button" data-bs-target="#carouselUltraPedia" data-bs-slide-to="0" class="active"></button>
            <?php endif; ?>
        </div>
        
        <div class="carousel-inner shadow-md">
            <?php if (!empty($get_banners)) : 
                foreach ($get_banners as $key => $b) : ?>
                <div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
                    <?php 
                    // Cek lokasi gambar. Jika di uploads tidak ada, coba cek di assets/images/slider/
                    $path_uploads = 'uploads/' . $b['image'];
                    $path_assets = 'assets/images/slider/' . $b['image'];
                    
                    if (file_exists(FCPATH . $path_uploads)) {
                        $img_url = base_url($path_uploads);
                    } elseif (file_exists(FCPATH . $path_assets)) {
                        $img_url = base_url($path_assets);
                    } else {
                        $img_url = base_url('assets/images/slider/img-slide-1.jpg'); // Fallback jika file hilang
                    }
                    ?>
                    <img src="<?= $img_url ?>" class="d-block w-100 rounded-3" alt="Banner" style="min-height: 200px; object-fit: cover;">
                </div>
            <?php endforeach; 
            else : ?>
                <div class="carousel-item active">
                    <img src="<?= base_url('assets/images/slider/img-slide-1.jpg') ?>" class="d-block w-100 rounded-3" alt="Default">
                </div>
            <?php endif; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselUltraPedia" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselUltraPedia" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

    <div class="col-md-4 col-xl-4">
        <div class="card bg-primary available-balance-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Saldo Anda</p>
                        <h4 class="mb-0 text-white">Rp <?= currency(user('balance')) ?></h4>
                    </div>
                    <div class="avtar"><i class="fas fa-wallet f-18"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-4">
        <div class="card bg-primary available-balance-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Pesanan Selesai</p>
                        <h4 class="mb-0 text-white">Rp <?= currency($widget_order[0]['rupiah']) ?> (<?= currency($widget_order[0]['total']) ?>)</h4>
                    </div>
                    <div class="avtar"><i class="fas fa-cart-arrow-down f-18"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-4">
        <div class="card bg-primary available-balance-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Deposit Selesai</p>
                        <h4 class="mb-0 text-white">Rp <?= currency($widget_deposit[0]['rupiah']) ?> (<?= currency($widget_deposit[0]['total']) ?>)</h4>
                    </div>
                    <div class="avtar"><i class="fas fa-money-bill-transfer f-18"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user me-2"></i>Detail Akun</h4>
            </div>
            <div class="card-body pb-3">
                <div class="row">
                    <div class="col-12 d-grid mb-3">
                        <a href="javascript:;" class="btn btn-primary bg-gradient benefit_account" data-bs-toggle="modal" data-bs-target="#benefit_account">Lihat Benefit</a>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">Level saat ini</p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 text-primary fw-bolder"><?= strtoupper(user('benefit')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">Minimum Payout</p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder"><?= currency(benefit('min_payout', user('benefit'))) ?> Point</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">Rate Payout</p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">1 Point ≈ Rp <?= currency(benefit('rate_payout', user('benefit'))) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <?php if ($next_level != 'null') {
                    $next = $this->benefit_model->get_rows(['type' => $next_level])
                ?>
                    <div class="row align-items-center mb-2">
                        <div class="col-6 mb-2 mb-sm-0">
                            <p class="mb-0">Next Level</p>
                        </div>
                        <div class="col-6 mb-2 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 me-3">
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0 text-primary fw-bolder"><?= strtoupper($next_level) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-6 mb-2 mb-sm-0">
                            <p class="mb-0">Complete Order</p>
                        </div>
                        <div class="col-6 mb-2 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 me-3">
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0 fw-bolder">Rp <?= currency(benefit('trx', $next_level)) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-6 mb-2 mb-sm-0">
                            <p class="mb-0">Progress (Rp)</p>
                        </div>
                        <div class="col-6 mb-2 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 me-3">
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0 fw-bolder">Rp <?= currency($widget_order[0]['rupiah']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-0">
    <div class="col-6 mb-2 mb-sm-0">
        <p class="mb-0">Progress (%)</p>
    </div>
    <div class="col-6 mb-2 mb-sm-0">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1 me-3">
                <div class="progress" style="height: 10px;">
                    <?php 
                        // Ambil target transaksi dan pastikan tidak nol
                        $target_trx = benefit('trx', $next_level); 
                        $current_trx = $widget_order[0]['rupiah'];
                        $percentage = ($target_trx > 0) ? number_format(($current_trx / $target_trx) * 100, 2) : 0;
                    ?>
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $percentage ?>%"></div>
                </div>
            </div>
            <div class="flex-shrink-0">
                <p class="mb-0 fw-bolder"><?= $percentage ?>%</p>
            </div>
        </div>
    </div>
</div>
<hr>
<?php } ?>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">
                            Admin Online
                        </p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">
                                    <?php echo (custom_statistic('total_admin_online') != 0) ? currency(custom_statistic('total_admin_online')) : $this->user_model->get_count(['where' => [['level' => 'Owner']]]); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">
                            Member Online
                        </p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">
                                    <?php echo (custom_statistic('total_user_online') != 0) ? currency(custom_statistic('total_user_online')) : $this->user_model->get_count(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">
                            Submit Ticket
                        </p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">
                                    <a href="<?= base_url() ?>ticket/new">Kirim</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">
                            WhatsApp CS
                        </p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">
                                    <a href="https://wa.me/6285162911945">Hubungi</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-2">
                    <div class="col-6 mb-2 mb-sm-0">
                        <p class="mb-0">
                            Grup Telegram
                        </p>
                    </div>
                    <div class="col-6 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0 fw-bolder">
                                    <a href="https://t.me/vanpayidchannel" target="_blank" rel="noopener noreferrer">Gabung</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 d-flex align-items-center"><i class="ph-duotone ph-arrows-counter-clockwise fs-3 me-2"></i>Update Layanan</h4>
            </div>
            <!-- end card header -->
            <div class="card-body pb-3" style="max-height: 395.328px; overflow: auto;">
                <ul class="list-group border-dashed">
                    <?php if (!empty($service_logs)) {
                        foreach ($service_logs as $key => $value) {
                            if ($value['type'] == 'price_increased') {
                                $bg = 'warning';
                                $icon = 'fas fa-arrow-circle-up';
                            } elseif ($value['type'] == 'price_decreased') {
                                $bg = 'success';
                                $icon = 'fas fa-arrow-circle-down';
                            } elseif ($value['type'] == 'update_min' or $value['type'] === 'update_max') {
                                $bg = 'info';
                                $icon = 'far fa-dot-circle';
                            } elseif ($value['type'] == 'enabled') {
                                $bg = 'success';
                                $icon = 'fas fa-check-circle';
                            } elseif ($value['type'] == 'insert') {
                                $bg = 'success';
                                $icon = 'fas fa-plus-circle';
                            } else {
                                $bg = 'danger';
                                $icon = 'fas fa-times-circle';
                            }
                    ?>
                            <li class="list-group-item">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-icon btn-<?= $bg ?> bg-gradient avtar-l"><i class="<?= $icon ?>"></i></button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <span class="text-muted f-12">
                                            <?= $this->lib->tanggal_indonesia($value['created_at']) ?>
                                        </span><br>
                                        <?php if ($value['type'] == 'update_min' or $value['type'] == 'update_max') {
                                        ?>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);" class="text-reset fs-14 mb-0"><b>
                                                    <?= $value['service_name'] ?>
                                                </b> -
                                                <?= ($value['type'] == 'update_min' ? 'Perubahan' : 'Perubahan') ?> jumlah
                                                <?= ($value['type'] == 'update_min' ? 'Minimal' : 'Maksimal') ?> Order dari <b>
                                                    <?= currency($value['before_update']) ?>
                                                </b> ke <b>
                                                    <?= currency($value['after_update']) ?>
                                                </b>
                                            </a>

                                        <?php
                                        } elseif ($value['type'] == 'price_increased' or $value['type'] == 'price_decreased') {
                                        ?>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);" class="text-reset fs-14 mb-0"><b>
                                                    <?= $value['service_name'] ?>
                                                </b> -
                                                <?= ($value['type'] == 'price_increased' ? 'Kenaikan' : 'Penurunan') ?> harga dari
                                                <b>Rp
                                                    <?= currency($value['before_update']) ?>
                                                </b> ke <b>Rp
                                                    <?= currency($value['after_update']) ?>
                                                </b>
                                            </a>
                                        <?php
                                        } elseif ($value['type'] == 'enabled' or $value['type'] == 'disabled') {
                                        ?>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);" class="text-reset fs-14 mb-0"><b>
                                                    <?= $value['service_name'] ?>
                                                </b> -
                                                <?= ($value['type'] == 'enabled' ? 'Layanan sudah <span class="text-success"><b>AKTIF</b></span>' : 'Layanan <span class="text-danger"><b>MAINTENANCE</b></span>') ?>
                                            </a>
                                        <?php
                                        } elseif ($value['type'] == 'insert') {
                                        ?>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['service_id']; ?>);" class="text-reset fs-14 mb-0"><b>
                                                    <?= $value['service_name'] ?>
                                                </b> - Layanan <span class="text-success"><b>BARU</b></span> ditambahkan</a>
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                                <!-- end row -->
                            </li><!-- end -->
                        <?php
                        }
                    } else {
                        ?>
                        <h6 class="text-center">Data belum tersedia.</h6>
                    <?php
                    }
                    ?>
                </ul>
                <!-- end -->
            </div>
            <!-- end card body -->
            <div class="card-footer">

                <h6 class="text-center m-0">
                    <a href="<?= base_url() ?>page/service_log">Lihat Selengkapnya</a>
                </h6>

            </div>
        </div>
        <!-- end card -->
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Informasi Terbaru</h4></div>
            <div class="card-body pb-3" style="max-height: 500px; overflow: auto;">
                <?php if (!empty($info)) {
                    foreach ($info as $key => $value) { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <span class="badge bg-primary mb-2"><?= $this->lib->status_info($value['category']) ?></span>
                            <small class="float-end text-muted"><?= $this->lib->tanggal_indonesia($value['created_at']) ?></small>
                            <p><?= $value['content'] ?></p>
                        </li>
                    </ul>
                <?php } } else { ?>
                    <h6 class="text-center">Data belum tersedia.</h6>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function level_detail(to) {
        $.ajax({
            type: "GET",
            url: "<?= base_url('user/benefit/'); ?>" + to,
            data: { '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>' },
            success: function(data) { $('.benefit-details').html(data); }
        });
    }
</script>