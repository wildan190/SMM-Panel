<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= $page_type ?> | <?= website_config('title') ?></title>
    <!-- Primary Meta Tags -->
    <meta name="description" content="<?= website_config('meta_description') ?>" />
    <meta name="keywords" content="<?= website_config('meta_keywords') ?>" />
    <meta name="author" content="<?= website_config('meta_author') ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <link rel="canonical" href="<?= base_url() ?>" />
    <!-- Open Graph / Facebook -->
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:title" content="<?= $page_type ?> | <?= website_config('title') ?>">
    <meta property="og:description" content="<?= website_config('meta_description') ?>">
    <meta property="og:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>">
    <meta property="og:image:secure_url" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta property="og:image:type" content="image/jpg" />
    <meta property="og:image:width" content="3000" />
    <meta property="og:image:height" content="3000" />
    <meta property="og:image:alt" content="<?= website_config('title') ?>" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?= website_config('title') ?>" />
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= base_url() ?>">
    <meta property="twitter:title" content="<?= $page_type ?> | <?= website_config('title') ?>">
    <meta property="twitter:description" content="<?= website_config('meta_description') ?>">
    <meta property="twitter:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>">

    <!-- Custom Tag -->
    <?= htmlspecialchars_decode(stripslashes(website_config('custom_tag')), ENT_QUOTES) ?>

    <!-- App favicon -->
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="32x32" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <meta name="msapplication-TileImage" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />

    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/inter/inter.css" id="main-font-link" />
    <!-- prism css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/prism-coy.css">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material.css" />
    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/flatpickr.min.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style-preset.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/croppr.min.css" />
    <!-- [HoldOn] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/holdon.min.css">
    <!-- [Tiny] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/tiny.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/holdon.min.js"></script>

    <!-- Google Analytics -->
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <!-- End Google Analytics -->

    <!-- [Page specific CSS] start -->
    <style>
        @media (max-width: 1199px) {
            .page-header {
                display: none;
            }

            .pc-container .page-header+.row {
                padding-top: 4px;
            }
        }

        @media only screen and (max-width: 768px) {
            .mobile-br {
                display: block;
            }
        }

        @media only screen and (min-width: 769px) {
            .mobile-br {
                display: none;
            }
        }
    </style>
    <!-- Gradient Text Animation CSS -->
    <style>
        .hero-text-gradient {
            --bg-size: 400%;
            --color-one: rgb(37, 161, 244);
            --color-two: rgb(249, 31, 169);

            background: linear-gradient(90deg, var(--color-one), var(--color-two), var(--color-one)) 0 0 / var(--bg-size) 100%;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: move-bg 24s infinite linear;
        }

        @keyframes move-bg {
            to {
                background-position: var(--bg-size) 0;
            }
        }
    </style>
    <script type="text/javascript">
        function modal_open(type, url) {
            $('#detail_modal').modal('show');
            if (type == 'add') {
                $('#detail_modal_title').html('<i class="fa fa-plus"></i> Tambah Data');
            } else if (type == 'edit') {
                $('#detail_modal_title').html('<i class="fa fa-edit"></i> Ubah Data');
            } else if (type == 'detail') {
                $('#detail_modal_title').html('<i class="fas fa-search me-2"></i> Detail Data');
            } else if (type == 'transaksi') {
                $('#detail_modal_title').html('<i class="fe-shopping-cart"></i> Mulai Transaksi');
            } else if (type == 'detail_layanan') {
                $('#detail_modal_title').html('<i class="fas fa-search me-2"></i> Detail Layanan');
            } else if (type == 'detail_pesanan') {
                $('#detail_modal_title').html('<i class="fas fa-search me-2"></i> Detail Pesanan');
            } else if (type == 'detail_deposit') {
                $('#detail_modal_title').html('<i class="fas fa-search me-2"></i> Detail Deposit');
            } else if (type == 'cancel_deposit') {
                $('#detail_modal_title').html('<i class="fas fa-times-circle fs-6 me-2"></i> Batalkan Deposit');
            } else {
                $('#detail_modal_title').html(type);
            }
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    // tambahkan parameter lain jika diperlukan
                },
                success: function($data) {
                    $('#detail_modal_body').html($data);
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Ups!",
                        html: "Terjadi Kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.",
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    }).then((result) => {
                        $('#modal').modal('hide');
                    });
                },
                beforeSend: function() {
                    $('#detail_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
                },
            });
        }

        function read_popup() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('user/read_popup') ?>",
                success: function() {
                    $('#modal-info').modal('hide');
                },
                error: function() {
                    alert('Terjadi kesalahan, refresh halaman ini.');
                }
            });
        }
    </script>
    <!-- KODE LIVE CHAT TARUH DIBAWAH INI -->

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-theme_contrast="<?php if (user()) { ?><?= user('contrast') ?><?php } else { ?><?= website_config('contrast_theme') ?><?php } ?>" data-pc-sidebar-caption="true" data-pc-preset="<?php if (user()) { ?><?= user('layout') ?><?php } else { ?><?= website_config('color_theme') ?><?php } ?>" data-pc-direction="ltr" data-pc-theme="<?= (user()) ? (user('mode') == 'light' ? 'light' : (user('mode') == 'dark' ? 'dark' : 'default')) : website_config('mode_theme') ?>">

    <!-- GTM - Body -->
    <?= htmlspecialchars_decode(stripslashes(website_config('gtm_body')), ENT_QUOTES) ?>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-W7VM899MYK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-W7VM899MYK');
    </script>

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loadingio-spinner-typing-xprgxbsyl4">
            <div class="ldio-b5rzs5omc1l">
                <div style="left:30.150000000000002px;background:#ffffff;animation-delay:-0.37499999999999994s;"></div>
                <div style="left:50.25px;background:#ffffff;animation-delay:-0.28124999999999994s;"></div>
                <div style="left:70.35000000000001px;background:#ffffff;animation-delay:-0.18749999999999997s;"></div>
                <div style="left:90.45px;background:#ffffff;animation-delay:-0.09374999999999999s;"></div>
            </div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="<?= base_url() ?>" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <!--<img src="<?= base_url() ?>assets/images/logo-dark.svg" />-->
                    <span class="hero-text-gradient fs-3 fw-bold">
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="30"> <?= strtoupper(website_config('title')) ?>
                    </span>
                    <!--<span class="badge bg-light-success rounded-pill ms-2 theme-version"></span>-->
                </a>
            </div>
            <div class="navbar-content">
                <?php if (user()) { ?>
                    <div class="card pc-user-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" alt="profil <?= user('full_name') ?>" class="user-avtar wid-45 rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3 me-2">
                                    <h6 class="mb-0"><?= user('full_name') ?></h6>
                                    <small><?= strtoupper(user('benefit')) ?></small>
                                </div>
                                <a class="btn btn-icon btn-link-secondary avtar-s" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-sort-outline"></use>
                                    </svg>
                                </a>
                            </div>
                            <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                                <div class="pt-3">
                                    <a href="<?= base_url() ?>user/setting">
                                        <i class="fas fa-cog fs-6 ms-1"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <a href="<?= base_url() ?>user/session">
                                        <i class="fab fa-firefox-browser fs-6 ms-1"></i>
                                        <span>Sesi Aktif</span>
                                    </a>
                                    <a href="javascript:;" onclick="confirm_logout();">
                                        <i class="fas fa-sign-out fs-6 ms-1"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card pc-user-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3 me-2">
                                    <h6 class="mb-0">Unknown</h6>
                                    <small>Guest</small>
                                </div>
                            </div>
                            <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                                <div class="pt-3">
                                    <a href="<?= base_url() ?>auth/login">
                                        <i class="fas fa-sign-out fs-6 ms-1"></i>
                                        <span>Masuk</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <ul class="pc-navbar">
                    <style>
                        .pc-sidebar .pc-link .pc-mtext {
                            vertical-align: middle;
                        }

                        .pc-sidebar .pc-micon i {
                            vertical-align: sub;
                        }
                    </style>
                    <!-- MENU HOME USER -->
                    <?php if (user()) { ?>
                        <li class="pc-item pc-caption">
                            <label>HOME</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-house-chimney-user"></i>
                                </span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <!-- MENU STAFF/ADMIN -->
                        <?php if (user('level') != 'Member') { ?>
                            <li class="pc-item pc-caption">
                                <label>STAFF MENU</label>
                                <i class="ti ti-dashboard"></i>
                            </li>
                            <?php if (user('level') == 'Owner') { ?>
                                <li class="pc-item ">
                                    <a href="<?= base_url() ?>admin" class="pc-link">
                                        <span class="pc-micon">
                                            <i class="fas fa-cogs"></i>
                                        </span>
                                        <span class="pc-mtext">Halaman Admin</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>staff/add_user" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-user-plus"></i>
                                    </span>
                                    <span class="pc-mtext">Tambah Member</span>
                                </a>
                            </li>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>staff/balance_transfer" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-money-bill-transfer"></i>
                                    </span>
                                    <span class="pc-mtext">Transfer Saldo</span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- MENU PESANAN -->
                        <li class="pc-item pc-caption">
                            <label>PEMESANAN</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>order/single" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cart-plus"></i>
                                </span>
                                <span class="pc-mtext">Pesanan Baru</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>order/massal" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cart-plus"></i>
                                </span>
                                <span class="pc-mtext">Pesanan Massal</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>order/history" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Riwayat Pesanan</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>order/refill_history" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-recycle"></i>
                                </span>
                                <span class="pc-mtext">Riwayat Refill</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>order/graph" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-pen-nib"></i>
                                </span>
                                <span class="pc-mtext">Laporan Pesanan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>order/childpanel" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ph-duotone ph-rocket"></i>
                                </span>
                                <span class="pc-mtext">Child Panel <span class="badge bg-primary ms-2">NEW</span></span>
                            </a>
                        </li>
                        <!-- MENU DEPOSIT -->
                        <li class="pc-item pc-caption">
                            <label>DEPOSIT</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>deposit/new" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-money-bill-transfer"></i>
                                </span>
                                <span class="pc-mtext">Deposit Baru</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>deposit/history" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Riwayat Deposit</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>deposit/graph" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-pen-nib"></i>
                                </span>
                                <span class="pc-mtext">Laporan Deposit</span>
                            </a>
                        </li>
                        <!-- MENU LAYANAN -->
                        <li class="pc-item pc-caption">
                            <label>LAYANAN</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/price_list" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="pc-mtext">Daftar Layanan</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/service_log" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Update Layanan</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/monitoring" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-desktop"></i>
                                </span>
                                <span class="pc-mtext">Monitoring Layanan</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/fav_services" class="pc-link">
                                <span class="pc-micon">
                                    <i class="far fa-star"></i>
                                </span>
                                <span class="pc-mtext">Layanan Favorit</span>
                            </a>
                        </li>
                        <!-- MENU TIKET -->
                        <li class="pc-item pc-caption">
                            <label>TIKET</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>ticket/new" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-comment-medical"></i>
                                </span>
                                <span class="pc-mtext">Tiket Baru</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>ticket" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-headset"></i>
                                </span>
                                <span class="pc-mtext">Data Tiket</span>
                                <span class="pc-badge" style="margin-top: 2px"><?= $unread_ticket ?></span>
                            </a>
                        </li>
                        <!-- REFERRAL -->
                        <?php if (website_config('referral_status') != 0) { ?>
                            <li class="pc-item pc-caption">
                                <label>REFERRAL</label>
                                <i class="ti ti-dashboard"></i>
                            </li>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>referral/statistic" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-link"></i>
                                    </span>
                                    <span class="pc-mtext">Statistik Referral</span>
                                </a>
                            </li>
                            <li class="pc-item">
                                <a href="<?= base_url() ?>referral/new" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-circle-dollar-to-slot"></i>
                                    </span>
                                    <span class="pc-mtext">Convert Komisi</span>
                                </a>
                            </li>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>referral/history" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-history"></i>
                                    </span>
                                    <span class="pc-mtext">Riwayat Convert</span>
                                </a>
                            </li>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>referral/log" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-history"></i>
                                    </span>
                                    <span class="pc-mtext">Riwayat Komisi</span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- POINT -->
                        <li class="pc-item pc-caption">
                            <label>Point</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>point/new" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-coins"></i>
                                </span>
                                <span class="pc-mtext">Payout Point</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>point/history" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Riwayat Payout</span>
                            </a>
                        </li>
                        <!-- PAGE -->
                        <li class="pc-item pc-caption">
                            <label>PAGE</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/info" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-bullhorn"></i>
                                </span>
                                <span class="pc-mtext">Informasi</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>api/documentation" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-code"></i>
                                </span>
                                <span class="pc-mtext">Dokumentasi API</span>
                            </a>
                        </li>
                        <?php if (website_config('top_order') != 0 or website_config('top_deposit') != 0 or website_config('top_service') != 0) { ?>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>page/hof" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-trophy"></i>
                                    </span>
                                    <span class="pc-mtext">Top 10</span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- AKUN -->
                        <li class="pc-item pc-caption">
                            <label>AKUN</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>user/setting" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cog"></i>
                                </span>
                                <span class="pc-mtext">Pengaturan Akun</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>user/session" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fab fa-firefox-browser"></i>
                                </span>
                                <span class="pc-mtext">Sesi Aktif</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>user/log_balance_usage" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Mutasi Saldo</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>user/log_login" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Riwayat Masuk</span>
                            </a>
                        </li>
                        <!-- SITEMAP -->
                        <li class="pc-item pc-caption">
                            <label>SITEMAP</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <?php
                        $pages = $this->page_model->get_rows();
                        foreach ($pages as $key => $value) { ?>
                            <li class="pc-item ">
                                <a href="<?= base_url() ?>page/site/<?= $value['slug'] ?>" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="fas fa-sitemap"></i>
                                    </span>
                                    <span class="pc-mtext"><?= $value['title'] ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-house-chimney-user"></i>
                                </span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>auth/login" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-right-to-bracket"></i>
                                </span>
                                <span class="pc-mtext">Masuk</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>auth/register" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-user-plus fs-5"></i>
                                </span>
                                <span class="pc-mtext">Daftar</span>
                            </a>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>page/price_list" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="pc-mtext">Layanan</span>
                            </a>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-sitemap"></i>
                                </span>
                                <span class="pc-mtext">Sitemap</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <?php
                                $pages = $this->page_model->get_rows();
                                foreach ($pages as $key => $value) { ?>
                                    <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>page/site/<?= $value['slug'] ?>"><?= $value['title'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                            </ul>
                        </li>
                        <br class="mobile-br">
                        <br class="mobile-br">
                        <br class="mobile-br">
                        <br class="mobile-br">
                        <br class="mobile-br">
                        <br class="mobile-br">
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="javascript:;" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="javascript:;" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>

                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-search-normal-1"></use>
                            </svg>
                        </a>
                        <div class="dropdown-menu pc-h-dropdown drp-search">
                            <form class="px-3 py-2">
                                <input type="search" class="form-control border-0 shadow-none" placeholder="Cari..." id="compo-menu-search" />
                            </form>
                            <div id="search-results" class="search-results"></div>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <?php if (user()) { ?>
                        <li class="pc-h-item">
                            <button type="button" class="btn btn-sm btn-primary bg-gradient me-1" onclick="window.location.href='<?= base_url() ?>deposit/new'">Rp <?= currency(user('balance')) ?></button>
                        </li>
                        <!-- <li class="pc-h-item">
                            <a href="<?= base_url() ?>user/mode/<?= (user('mode') == 'false' ? 'true' : 'false') ?>" class="pc-head-link arrow-none me-0">
                                <svg class="pc-icon text-primary">
                                    <use xlink:href="#<?= (user('mode') == 'false' ? 'custom-sun-1' : 'custom-moon') ?>"></use>
                                </svg>
                            </a>
                        </li> -->
                        <li class="pc-h-item">
                            <a href="#" class="pc-head-link me-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout" aria-controls="offcanvas_pc_layout">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-setting-2"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                                <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" alt="Profil <?= user('full_name') ?>" class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body pb-2">
                                    <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" alt="Profil <?= user('full_name') ?>" class="user-avtar wid-35" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"><?= user('full_name') ?> 🖖</h6>
                                                <span><?= user('username') ?> <span class="text-primary fw-bolder">[<?= strtoupper(user('benefit')) ?>]</span></span>
                                            </div>
                                        </div>
                                        <hr class="border-secondary border-opacity-50" />
                                        <a href="<?= base_url() ?>user/log_balance_usage" class="dropdown-item ">
                                            <span>
                                                <span class="pc-micon">
                                                    <i class="fas fa-history fs-6 me-2"></i>
                                                </span>
                                                <span>Log Mutasi Saldo</span>
                                            </span>
                                        </a>
                                        <a href="<?= base_url() ?>user/setting" class="dropdown-item ">
                                            <span>
                                                <span class="pc-micon">
                                                    <i class="fas fa-cog fs-6 me-2"></i>
                                                </span>
                                                <span>Pengaturan</span>
                                            </span>
                                        </a>
                                        <a href="<?= base_url() ?>user/session" class="dropdown-item ">
                                            <span>
                                                <span class="pc-micon">
                                                    <i class="fab fa-firefox-browser fs-6 me-2"></i>
                                                </span>
                                                <span>Sesi Aktif</span>
                                            </span>
                                        </a>
                                        <hr class="border-secondary border-opacity-50" />
                                        <div class="d-grid mb-0">
                                            <button class="btn btn-primary bg-gradient" onclick="confirm_logout();">
                                                <span class="pc-micon">
                                                    <i class="fas fa-sign-out fs-6 me-2"></i>
                                                </span>
                                                Logout
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php } else { ?>

                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image" class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body pb-2">
                                    <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image" class="user-avtar wid-35" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Guest Account 🖖</h6>
                                                <span>Guest</span>
                                            </div>
                                        </div>
                                        <hr class="border-secondary border-opacity-50" />
                                        <div class="d-grid mb-0">
                                            <button class="btn btn-primary bg-gradient" onclick="window.location.href='<?= base_url() ?>auth/login';">
                                                <span class="pc-micon">
                                                    <i class="fas fa-right-to-bracket fs-6 me-2"></i>
                                                </span>
                                                Masuk
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><?= text_gradient(website_config('bartitle')) ?></a></li>
                                <li class="breadcrumb-item" aria-current="page"><?= $page_type ?></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0"><?= $page_type ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('result') ?>

            <?= $content ?>

            <a href="https://wa.me/6285162911945" class="wa-fab" target="_blank" rel="noopener noreferrer" aria-label="Hubungi WhatsApp">
                <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff;"></i>
            </a>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid d-flex justify-content-center text-center">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0"><?= text_gradient(website_config('footer')) ?></p>
                </div>
            </div>
        </div>
    </footer>
    <div class="pct-c-btn">
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
            <i class="ph-duotone ph-gear-six"></i>
        </a>
    </div>
    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Pengaturan</h5>
            <button type="button" class="btn btn-icon btn-link-danger" data-bs-dismiss="offcanvas" aria-label="Close"><i class="ti ti-x"></i></button>
        </div>
        <div class="pct-body" style="height: calc(100% - 85px)">
            <div class="offcanvas-body py-0">
                <form method="POST" action="<?= base_url() ?>user/setting?act=theme">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <input type="hidden" name="theme_mode" id="theme_mode" value="<?= isset($_POST['theme_mode']) ? $_POST['theme_mode'] : htmlspecialchars(user('mode')) ?>">
                    <input type="hidden" name="theme_contrast" id="theme_contrast" value="<?= isset($_POST['theme_contrast']) ? $_POST['theme_contrast'] : htmlspecialchars(user('contrast')) ?>">
                    <input type="hidden" name="theme_preset" id="theme_preset" value="<?= isset($_POST['theme_preset']) ? $_POST['theme_preset'] : htmlspecialchars(user('layout')) ?>">


                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                            <div class="pc-dark">
                                <h6 class="mb-1">Mode Tema</h6>
                                <p class="text-muted text-sm">Pilih mode terang, gelap atau otomatis</p>
                                <div class="row theme-layout">
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button type="button" class="preset-btn btn<?= (user('mode') == 'light') ? ' active' : '' ?>" data-value="true" onclick="layout_change('light'); layout_change2('light');" data-bs-toggle="tooltip" title="Terang">
                                                <svg class="pc-icon text-warning">
                                                    <use xlink:href="#custom-sun-1"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button type="button" class="preset-btn btn<?= (user('mode') == 'dark') ? ' active' : '' ?>" data-value="false" onclick="layout_change('dark'); layout_change2('dark');" data-bs-toggle="tooltip" title="Gelap">
                                                <svg class="pc-icon">
                                                    <use xlink:href="#custom-moon"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button type="button" class="preset-btn btn<?= (user('mode') == 'default') ? ' active' : '' ?>" data-value="default" onclick="layout_change_default(); layout_change2('default');" data-bs-toggle="tooltip" title="Secara otomatis menetapkan tema berdasarkan skema warna sistem operasi pengguna.">
                                                <span class="pc-lay-icon d-flex align-items-center justify-content-center">
                                                    <i class="ph-duotone ph-cpu"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <h6 class="mb-1">Kontras Tema</h6>
                            <p class="text-muted text-sm">Pilih kontras tema</p>
                            <div class="row theme-contrast">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button type="button" class="preset-btn btn <?= (user('contrast') == 'true') ? 'active' : '' ?>" data-value="true" onclick="layout_theme_contrast_change('true'); layout_sidebar_change2('true');" data-bs-toggle="tooltip" title="Aktif">
                                            <svg class="pc-icon">
                                                <use xlink:href="#custom-mask"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button type="button" class="preset-btn btn <?= (user('contrast') == 'false') ? 'active' : '' ?>" data-value="false" onclick="layout_theme_contrast_change('false'); layout_sidebar_change2('false');" data-bs-toggle="tooltip" title="Nonaktif">
                                            <svg class="pc-icon">
                                                <use xlink:href="#custom-mask-1-outline"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <h6 class="mb-1">Kustom Tema</h6>
                            <p class="text-muted text-sm">Pilih warna Utama Anda</p>
                            <div class="theme-color preset-color">
                                <a href="#!" class="<?= (user('layout') == 'preset-1') ? 'active' : '' ?>" data-value="preset-1" onclick="layout_preset2('preset-1');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-2') ? 'active' : '' ?>" data-value="preset-2" onclick="layout_preset2('preset-2');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-3') ? 'active' : '' ?>" data-value="preset-3" onclick="layout_preset2('preset-3');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-4') ? 'active' : '' ?>" data-value="preset-4" onclick="layout_preset2('preset-4');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-5') ? 'active' : '' ?>" data-value="preset-5" onclick="layout_preset2('preset-5');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-6') ? 'active' : '' ?>" data-value="preset-6" onclick="layout_preset2('preset-6');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-7') ? 'active' : '' ?>" data-value="preset-7" onclick="layout_preset2('preset-7');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-8') ? 'active' : '' ?>" data-value="preset-8" onclick="layout_preset2('preset-8');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-9') ? 'active' : '' ?>" data-value="preset-9" onclick="layout_preset2('preset-9');"><i class="ti ti-check"></i></a>
                                <a href="#!" class="<?= (user('layout') == 'preset-10') ? 'active' : '' ?>" data-value="preset-10" onclick="layout_preset2('preset-10');"><i class="ti ti-check"></i></a>
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger bg-gradient" onclick="window.location.href='<?= base_url() ?>user/setting?act=reset_theme';"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button type="submit" class="btn btn-primary bg-gradient"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                        </div>
                    </div>
                </form>
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

    <?php if (user()) : ?>
        <?php if (user('crop_foto') == 0) : ?>
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/cropper.min.css">
            <script src="<?= base_url() ?>assets/js/plugins/cropper.min.js"></script>
            <style>
                .preview {
                    overflow: hidden;
                    width: 160px;
                    height: 160px;
                    margin: 10px;
                    border: 1px solid red;
                }
            </style>
            <div class="modal fade" id="imgcrop_modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-crop me-2"></i>Crop Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row" style="margin-top: -20px; max-width: 100% !important;">
                                    <div class="col-md-8">
                                        <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" style="max-width: 100%;" id="cropbox">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-danger float-end my-2" onclick="reset_img();"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                            <button type="button" class="btn btn-primary float-end my-2" onclick="cropAndClose();"><i class="fas fa-crop fs-6 me-2"></i>Crop</button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                var image = document.getElementById('cropbox');
                var cropper; // Deklarasikan variabel cropper di luar fungsi agar bisa diakses secara global

                // Fungsi untuk menampilkan modal data crop dan inisialisasi cropper
                function showCropModal() {
                    $('#imgcrop_modal').modal('show'); // Tampilkan modal secara manual
                    var coptions = {
                        aspectRatio: 1 / 1,
                        viewMode: 1,
                        preview: '.preview'
                    };
                    cropper = new Cropper(image, coptions); // Inisialisasi cropper
                }

                // Panggil fungsi showCropModal saat dokumen selesai dimuat
                $(document).ready(function() {
                    showCropModal();
                });

                $("#imgcrop_modal").on('hide.bs.modal', function() {
                    setTimeout(() => {
                        cropper.destroy();
                        location.reload(true);
                    }, 250);
                });

                function reset_img() {
                    window.location.href = '<?= base_url() ?>user/setting?act=reset_foto';
                }

                function cropAndClose() {
                    crop(); // Panggil fungsi crop untuk mengirim permintaan AJAX
                    $('#imgcrop_modal').modal('hide'); // Tutup modal secara manual
                }

                function crop() {
                    var csrfName = $('.txt_csrfname').attr('name');
                    var csrfHash = $('.txt_csrfname').val();
                    var data = cropper.getData();
                    console.log(cropper.getData());
                    $.ajax({
                        url: '<?= base_url() ?>ajax/crop',
                        type: 'POST',
                        data: {
                            tw: data.width,
                            th: data.height,
                            x: data.x,
                            y: data.y,
                            [csrfName]: csrfHash
                        },
                        success: function(response) {
                            try {
                                var data = JSON.parse(response);

                                if (data.status === 'success') {
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'Okay',
                                        customClass: {
                                            confirmButton: 'btn btn-primary',
                                        },
                                        buttonsStyling: false,
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Terjadi kesalahan tanpa pesan keterangan.',
                                        icon: 'error',
                                        confirmButtonText: 'Okay',
                                        customClass: {
                                            confirmButton: 'btn btn-primary',
                                        },
                                        buttonsStyling: false,
                                    });
                                }
                            } catch (error) {
                                console.error('Gagal parsing respons JSON:', error);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX Error:', textStatus, errorThrown);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan dalam melakukan permintaan.',
                                icon: 'error',
                                confirmButtonText: 'Okay',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                                buttonsStyling: false,
                            });
                        },
                        beforeSend: function() {
                            // Tambahkan logika loading atau indikator visual jika diperlukan
                        },
                        complete: function() {
                            // Tambahkan logika yang dijalankan setelah permintaan selesai, jika diperlukan
                        }
                    });
                }
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->session->userdata('login')) { ?>
        <?php if (user('is_read_popup') == '0') { ?>
            <div class="modal fade" id="modal-info" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-bullhorn me-2"></i>Informasi Terbaru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-1" style="max-height: 400px; overflow: auto;">
                            <?php if (count($info_popup) == 0) { ?>
                                <div class="alert alert-primary alert-dismissible alert-solid alert-label-icon fade show" role="alert">
                                    <div class="">
                                        <i class="fa fa-info label-icon"></i><strong>Belum ada informasi yang ditampilkan</strong>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <ul class="list-group list-group-flush border-top-0">
                                    <?php } else {
                                    foreach ($info_popup as $key => $value) {
                                    ?>
                                        <li class="list-group-item pt-0 px-0">
                                            <div class="d-flex align-items-start ">
                                                <div class="flex-grow-1 me-2">
                                                    <span class="mb-0"><span class="fs-5 badge text-white fw-bold bg-<?= $this->lib->status_info_bg($value['category']) ?> rounded-pill"><i class="fas fa-info-circle"></i> <?= strtoupper($value['category']) ?></span><small class="fw-normal float-end"><?= $this->lib->format_date($value['created_at']) ?></small></span>
                                                    <p class="my-1" style="margin-top: 0.6rem !important">
                                                    <p><?= $value['content'] ?></p>
                                                    </p>
                                                    <small>Pembaruan terakhir: <?= $this->lib->format_date($value['updated_at']) ?></small>
                                                </div>
                                            </div>
                                        </li>
                                        <hr>
                                <?php }
                                } ?>
                                </ul>
                        </div>
                        <div class="modal-footer p-2">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="read_popup()"><i class="fas fa-thumbs-up me-2"></i>Sudah membaca</button>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#modal-info').modal('show');
                });
            </script>
    <?php
        }
    }
    ?>


    <!-- Required Js -->
    <script src="<?= base_url() ?>assets/js/plugins/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/fonts/custom-font.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/config.js"></script> -->

    <script type="text/javascript">
        function layout_change2(value) {
            $('#theme_mode').val(value);
        }

        function layout_sidebar_change2(value) {
            $('#theme_contrast').val(value);
        }

        function layout_preset2(value) {
            $('#theme_preset').val(value);
        }

        'use strict';
        var theme_contrast = '<?= (user() ? user('contrast') : website_config('color_theme')) ?>'; // [ false , true ]
        var caption_show = 'true'; // [ false , true ]
        var preset_theme = '<?= (user() ? user('layout') : website_config('color_theme')) ?>'; // [ preset-1 to preset-10 ]                        
        var dark_layout = '<?= (user()) ? (user('mode') == 'light' ? 'false' : (user('mode') == 'default' ? 'default' : 'true')) : website_config('mode_theme') ?>'; // [ false , true , default ]
        var rtl_layout = 'false'; // [ false , true ]
        var box_container = 'false'; // [ false , true ]
        var version = 'v9.0';
    </script>

    <script src="<?= base_url() ?>assets/js/pcoded.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/prism.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/croppr.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/flatpickr.min.js"></script>
    <!-- Sweet Alert -->
    <script src="<?= base_url() ?>assets/js/plugins/sweetalert2.all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        // pc-component
        var elem = document.querySelectorAll('.header-user-profile a');
        for (var l = 0; l < elem.length; l++) {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (elem[l].href == pageUrl && elem[l].getAttribute('href') != '') {
                elem[l].classList.add('active');
            }
        }

        // pencarian navbar
        document.querySelector('#compo-menu-search').addEventListener("keyup", function() {
            var tval = document.querySelector('#compo-menu-search').value.toLowerCase();
            var elem = document.querySelectorAll('.pc-item a');
            var resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';

            for (var l = 0; l < elem.length; l++) {
                var aval = elem[l].innerHTML.toLowerCase();
                var n = aval.indexOf(tval);

                if (n !== -1) {
                    var resultItem = document.createElement('div');
                    resultItem.classList.add('search-result-item');

                    var resultLink = document.createElement('a');
                    resultLink.href = elem[l].getAttribute('href');
                    resultLink.textContent = elem[l].textContent;

                    resultItem.appendChild(resultLink);
                    resultsContainer.appendChild(resultItem);
                }
            }

            // Menambahkan style untuk menampilkan hasil pencarian
            resultsContainer.style.display = tval.length > 0 ? 'block' : 'none';
        });
    </script>
    <!-- style hasil pencarian navbar -->
    <style>
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .search-result-item {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-bottom: 1px solid #ccc;
            /* Menambahkan border di bagian bawah setiap hasil pencarian */
        }

        .search-result-item:last-child {
            border-bottom: none;
            /* Menghapus border di bagian bawah elemen terakhir untuk menghindari garis ekstra */
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
        }

        .search-result-item a {
            text-decoration: none;
            font-weight: bold;
        }

        .search-result-item a:hover {
            text-decoration: underline;
        }
    </style>


    <script type="text/javascript">
        $(window).keypress(function(event) {
            if (event.which == '13' && !$(event.target).is('textarea')) {
                event.preventDefault();
            }
        });

        if (dark_layout == 'default') {
            setTimeout(() => {
                $('.theme-layout button[data-value=default]').trigger('click');
            }, 0);
        }

        (function($) {
            $.fn.hasScrollBar = function() {
                return this[0] ? this[0].scrollHeight > this.innerHeight() : false;
            }
        })(jQuery);

        if (!$('body').hasScrollBar()) {
            setTimeout(function() {
                var oldStyle = $('body.swal2-height-auto').attr('style');
                $('body.swal2-height-auto').attr('style', oldStyle + 'padding-right: 0 !important;');
            }, 1);
        }

        if (!$('body').hasScrollBar()) {
            setTimeout(function() {
                var oldStyle = $('body.modal-open').attr('style');
                $('body.modal-open').attr('style', oldStyle + 'padding-right: 0 !important;');
            }, 1);
        }

        $(".modal").on('hide.bs.modal', function() {
            setTimeout(function() {
                $('.select2').select2();
            }, 300);
        });

        $(".modal").on('shown.bs.modal', function() {
            setTimeout(function() {
                $(".select2").each((_i, e) => {
                    var $e = $(e);
                    $e.select2({
                        dropdownParent: $e.parent()
                    });
                })
            }, 200);
        });

        if (!($(".modal").data('bs.modal') || {})._isShown) {
            document.querySelector('body').style.overflow = 'auto';
            $('.select2').select2();
        }

        $('form').submit(function() {
            HoldOn.open({
                theme: "sk-rect",
                message: "Please wait...",
                textColor: "white"
            });
        });

        var uri = window.location.toString();
        if (uri.indexOf("#") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("#"));
            window.history.replaceState({}, document.title, clean_uri);
        }

        function confirm_logout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                icon: 'question',
                html: 'Semua sesi Anda yang tersimpan akan dihapus.',
                showCancelButton: true,
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary bg-gradient',
                    cancelButton: 'btn btn-danger bg-gradient',
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url() ?>auth/logout";
                }
            });
        }

        function copy_text(title, text) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.setAttribute("id", "dummy_id");
            document.getElementById("dummy_id").value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            Swal.fire({
                title: 'Yeay!',
                icon: 'success',
                html: title + ' berhasil disalin.',
                confirmButtonText: 'Okay',
                customClass: {
                    confirmButton: 'btn btn-primary bg-gradient',
                },
                buttonsStyling: false,
            });
        }

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
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>