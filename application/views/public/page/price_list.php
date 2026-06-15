<style>
    .star-section {
        display: inline-flex;
        flex-direction: row-reverse;
        /* Mengubah arah tata letak menjadi dari kiri ke kanan */
    }

    .star i.star-btn {
        color: #ccc;
        transition: color 0.2s;
        cursor: pointer;
    }

    .star i.star-btn:hover,
    .star i.star-btn:hover~i.star-btn {
        color: var(--bs-warning) !important;
    }

    /* .star i.fas.fa-star-half-alt {
        position: relative;
        margin-right: -0.5em;
    } */
</style>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <div class="modal fade filter-data" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2 form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?> baris</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Filter Kategori</label>
                                <select class="select2 form-control" name="category" id="category">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    foreach ($categories as $key => $value) {
                                    ?>
                                        <option value="<?= $value['id'] ?>" <?= ($this->input->get('category') == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kolom Sortir</label>
                                <select class="form-control select2" name="sort_field">
                                    <option value="">Kolom...</option>
                                    <?php
                                    foreach ($sort_field as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($key == $this->input->get('sort_field')) ? 'selected' : '' ?>>
                                            <?= $value ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Tipe Sortir</label>
                                <select class="form-control select2" name="sort_type">
                                    <option value="">Tipe...</option>
                                    <?php
                                    foreach ($sort_type as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($key == $this->input->get('sort_type')) ? 'selected' : '' ?>>
                                            <?= $value ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kolom Cari</label>
                                <select class="form-control select2" name="field">
                                    <option value="">Kolom...</option>
                                    <?php
                                    foreach ($field as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($key == $this->input->get('field')) ? 'selected' : '' ?>>
                                            <?= $value ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Kata Kunci Cari</label>
                                <input type="text" class="form-control" name="value" id="value" value="<?= $this->input->get('value') ?>" placeholder="Kata Kunci...">
                            </div>
                            <hr>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>page/price_list" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
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
                <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Daftar Layanan</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-nowrap table-bordered align-middle table-hover m-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th width="20%; !important">Layanan <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Layanan dengan tanda ♻️ artinya layanan tersebut dapat di <em>Refill</em>."><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Min <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Minimal Pemesanan"><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Maks <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Maksimal Pemesanan"><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Harga</th>
                                <th class="text-nowrap">Waktu Rata-Rata <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Waktu rata-rata</em> didasarkan pada 10 pesanan terakhir dengan status pesanan <em>Success</em>."><i class="fas fa-exclamation-circle"></i></a></th>
                                <th>Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $current_category = '';
                            foreach ($table as $value) {
                                if ($value['category_name'] != $current_category) {
                                    echo '<tr><th colspan="8" style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
                                            <h5 class="d-none d-md-block d-lg-block text-center mb-0"><b>' . $value['category_name'] . '</b></h5>
                                            <h5 class="d-block d-md-none d-lg-none mb-0" style="margin-top: 0;"><b>' . $value['category_name'] . '</b></h5>
                                        </th></tr>';
                                    $current_category = $value['category_name'];
                                }
                                $count_review = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id']]]]);
                                $countFive = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '5']]]);
                                $countFour = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '4']]]);
                                $countThree = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '3']]]);
                                $countTwo  = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '2']]]);
                                $countOne = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id'], 'rating' => '1']]]);
                                if ($count_review <> 0) {
                                    $calculateRating = $this->lib->calculateRating($countFive, $countFour, $countThree, $countTwo, $countOne);
                                } else {
                                    $calculateRating = 0;
                                }
                                $fav_user = $this->service_favorit_model->get_row(['service_id' => $value['id'], 'user_id' => user()]);
                                if ($fav_user) {
                                    $tombol = 'unfav';
                                    $icon = 'fas fa-star text-primary me-1';
                                } else {
                                    $tombol = 'fav';
                                    $icon = 'far fa-star text-primary me-1';
                                }
                            ?>
                                <tr>
                                    <td class="text-nowrap">
                                        <?php if (user()) { ?>
                                            <a href="javascript:;" onclick="<?= $tombol ?>('<?= $value['id'] ?>');" id="fs-<?= $value['id'] ?>">
                                                <i class="<?= $icon ?>"></i>
                                            </a>
                                        <?php } ?>
                                        <?= $value['id'] ?>
                                    </td>
                                    <td class="text-wrap"><?= $value['name'] ?> <?php if ($value['refill'] == 1) { ?>♻️<?php } ?></td>
                                    <td class="text-center"><?= currency($value['min']) ?></td>
                                    <td class="text-center"><?= currency($value['max']) ?></td>
                                    <td class="text-center">Rp <?= currency($value['price']) ?></td>
                                    <td class="text-center"><?= get_service_average($value['id']) ?></td>
                                    <td class="text-nowrap star">
                                        <?php
                                        $ratings = $this->service_rating_model->get_count(['where' => [['service_id' => $value['id']]]]);
                                        if ($ratings <> 0) {
                                            $bintang = '';
                                            for ($i = 5; $i >= 1; $i--) {
                                                if ($i <= $calculateRating) {
                                                    $bintang .= '<i class="fas fa-star text-warning"></i>';
                                                } elseif ($i - 0.5 == $calculateRating || ($i > $calculateRating && $calculateRating > $i - 1)) {
                                                    $bintang .= '<i class="fas fa-star-half-alt text-warning"></i>';
                                                } else {
                                                    $bintang .= '<i class="fas fa-star text-muted"></i>';
                                                }
                                            }

                                            echo '<div class="star-section">' . $bintang . '</div>';
                                            echo '(' . $calculateRating . '/5)';
                                        } else {
                                            echo '<i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i> (0/5)';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-wrap">
                                        <?php if (user()) { ?>
                                            <a href="<?= base_url() ?>order/single?id=<?php echo $value['id']; ?>" class="btn btn-success btn-sm round mb-1 w-100"><i class="fas fa-cart-plus fs-6 me-2"></i>Pesan</a>
                                            <a href=javascript:;" onclick="monitor_service(<?php echo $value['id']; ?>);" class="btn btn-danger btn-sm round mb-1 w-100"><i class="fas fa-desktop fs-6 me-2"></i>Monitoring</a>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['id']; ?>);" class="btn btn-primary btn-sm round mb-1 text-nowrap w-100"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>

                                            <?php if (website_config('rating_status') == 1) { ?>
                                                <a href="javascript:;" onclick="rating_service(<?= $value['id'] ?>)" class="btn btn-warning btn-sm round mb-1 w-100"><i class="fas fa-star fs-6 me-2"></i>Rating</a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="javascript:;" onclick="detail_service(<?php echo $value['id']; ?>);" class="btn btn-primary btn-sm round mb-1 text-nowrap w-100"><i class="fas fa-search fs-6 me-2"></i>Lihat Detail</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="align-items-center mt-2 row text-center text-sm-start">
                    <div class="col-sm mb-2">
                        <div class="text-muted">
                            <?= $pagination_links ?>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <span class="text-muted">
                            Menampilkan <?= currency($awal) ?> sampai <?= ($akhir >= $total_data) ? currency($total_data) : currency($akhir) ?> dari <?= currency($total_data) ?> data.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="monitor_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monitor_modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3" id="monitor_modal_body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rating_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rating_modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3" id="rating_modal_body">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#rows').on('change', function() {
            var rows = $('#rows').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            var category = $('#category').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            var search = $('#search').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            window.location.href = "<?= base_url('page/price_list') ?>?rows=" + rows + "&category=" + category + "&search=" + search;
        });

        $('#category').on('change', function() {
            var rows = $('#rows').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            var category = $('#category').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            var search = $('#search').val() || ''; // Tambahkan default value untuk mengatasi potensi undefined
            window.location.href = "<?= base_url('page/price_list') ?>?rows=" + rows + "&category=" + category + "&search=" + search;
        });
    });
</script>
<script type="text/javascript">
    function detail_service(id) {
        $('#detail_modal_title').html('<i class="fas fa-search me-2"></i>Detail Layanan #' + id);
        $('#detail_modal').modal('show');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('page/detail_service/'); ?>" + id,
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "html",
            success: function(data) {
                $('#detail_modal_body').html(data);
            },
            error: function() {
                $('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                $('#detail_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
            }
        });
    }

    function rating_service(id) {
        $('#rating_modal_title').html('<i class="fas fa-star me-2"></i>Rating Layanan #' + id);
        $('#rating_modal').modal('show');
        $.ajax({
            type: "GET", // Ganti menjadi POST
            url: "<?php echo base_url('page/service_rating/'); ?>" + id,
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "html",
            success: function(data) {
                $('#rating_modal_body').html(data);
            },
            error: function() {
                $('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                $('#rating_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
            }
        });
    }

    function fav(id) {
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>ajax/fav_service",
            data: {
                "id": id,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function(data) {
                if (data.result) {
                    $('#fs-' + id).html('<i class="fas fa-star text-primary"></i>');
                    $('#fs-' + id).attr('onclick', 'unfav(\'' + id + '\');');
                    Swal.fire({
                        title: 'Yeay!',
                        icon: 'success',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary bg-gradient',
                        },
                        buttonsStyling: false,
                    });
                } else {
                    Swal.fire({
                        title: 'Ups!',
                        icon: 'error',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary bg-gradient',
                        },
                        buttonsStyling: false,
                    });
                }
            },
            error: function() {},
            beforeSend: function() {}
        });
    }

    function unfav(id) {
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>ajax/unfav_service",
            data: {
                "id": id,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function(data) {
                if (data.result) {
                    $('#fs-' + id).html('<i class="far fa-star text-primary"></i>');
                    $('#fs-' + id).attr('onclick', 'fav(\'' + id + '\');');
                    Swal.fire({
                        title: 'Yeay!',
                        icon: 'success',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary bg-gradient',
                        },
                        buttonsStyling: false,
                    });
                } else {
                    Swal.fire({
                        title: 'Ups!',
                        icon: 'error',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary bg-gradient',
                        },
                        buttonsStyling: false,
                    });
                }
            },
            error: function() {},
            beforeSend: function() {}
        });

        // Setelah berhasil unfav, perbarui ikon bintang menjadi tidak full
        $('#fs-' + id).html('<i class="far fa-star text-primary"></i>');
    }

    function monitor_service(id) {
        $('#monitor_modal_title').html('<i class="fas fa-search me-2"></i>Monitoring Layanan #' + id);
        $('#monitor_modal').modal('show');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('page/monitor_service/'); ?>" + id,
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "html",
            success: function(data) {
                $('#monitor_modal_body').html(data);
            },
            error: function() {
                $('#monitor_modal_body').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                $('#monitor_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
            }
        });
    }
</script>