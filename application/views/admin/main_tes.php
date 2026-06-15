<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= website_config('title') ?></title>
    <!-- Primary Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= website_config('meta_description') ?>" />
    <meta name="keywords" content="<?= website_config('meta_keywords') ?>" />
    <meta name="author" content="<?= website_config('meta_author') ?>">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:title" content="<?= website_config('title') ?>">
    <meta property="og:description" content="<?= website_config('meta_description') ?>">
    <meta property="og:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= base_url() ?>">
    <meta property="twitter:title" content="<?= website_config('title') ?>">
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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material.css" />
    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/flatpickr.min.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style-preset.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Sweet Alert -->
    <script src="<?= base_url() ?>assets/js/plugins/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script type="text/javascript">
        function modal_open(type, size, url, prov) {
            $('#modal-size').removeClass('modal-xl').removeClass('modal-md').removeClass('modal-sm');
            if (size == 'sm') {
                $('#modal-size').addClass('modal-sm');
            } else if (size == 'md') {
                $('#modal-size').addClass('modal-md');
            } else if (size == 'lg') {
                $('#modal-size').addClass('modal-lg');
            } else if (size == 'xl') {
                $('#modal-size').addClass('modal-xl');
            }
            $('#modal').modal('show');
            if (type == 'add') {
                $('#modal-title').html('<i class="fas fa-plus-circle me-2"></i>Tambah Data');
            } else if (type == 'edit') {
                $('#modal-title').html('<i class="fas fa-edit me-2"></i>Ubah Data');
            } else if (type == 'detail') {
                $('#modal-title').html('<i class="fas fa-search me-2"></i>Detail Data');
            } else if (type == 'search') {
                $('#modal-title').html('<i class="fas fa-search me-2"></i>Lihat Data');
            } else if (type == 'api_profile') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Profile <span class="text-primary">' + prov + '</span>');
            } else if (type == 'api_service') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Service <span class="text-primary">' + prov + '</span>');
            } else if (type == 'api_order') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Order <span class="text-primary">' + prov + '</span>');
            } else if (type == 'api_status') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Status Order <span class="text-primary">' + prov + '</span>');
            } else if (type == 'api_refill') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Refill <span class="text-primary">' + prov + '</span>');
            } else if (type == 'api_status_refill') {
                $('#modal-title').html('<i class="fas fa-code me-2"></i>Status Refill <span class="text-primary">' + prov + '</span>');
            } else {
                $('#modal-title').html('Unknown');
            }
            var delay = 1000;
            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
                success: function ($data) {
                    // setTimeout(function(){
                    $('#modal-body').html($data);
                    // }, delay);
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Ups!",
                        html: "Terjadi Kesalahan.",
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    }).then((result) => {
                        $('#modal').modal('hide');
                    });
                },
                beforeSend: function () {
                    $('#modal-body').html('<div class="progress rounded-corner m-b-15"><div class="progress-bar bg-primary progress-bar-striped" style="width: 100%"></div></div>');
                }
            });
        }

        function modal_delete(id, url) {
            $('#modal-delete').modal('show');
            $('#modal-delete-body').html('Yakin ingin menghapus data #' + id + '?');
            $('#btn-delete').attr('onclick', "get_data('" + url + "')");
        }

        function swal_delete(id, url) {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                html: 'Yakin ingin menghapus data <b>#' + id + '</b>?',
                showCancelButton: true,
                confirmButtonText: `Yakin`,
                cancelButtonText: `Batal`,
                customClass: {
                    confirmButton: 'btn btn-primary me-1',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    get_data(url);
                }
            })
        }

        function btn_post(form, url) {
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'html',
                data: $(form).serialize(),
                success: function (data) {
                    $.unblockUI();
                    $('#modal-result').html(data);
                },
                error: function () {
                    $.unblockUI();
                    $('#modal-result').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Terjadi kesalahan!</div>');
                },
                beforeSend: function () {
                    $.blockUI({
                        message: '',
                        baseZ: 10000,
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                    $('#modal-result').html('<div class="progress rounded-corner mb-1 m-b-15"><div class="progress-bar bg-primary progress-bar-striped" style="width: 100%"></div></div>');
                }
            });
        }

        function btn_post_img_payment(form, url) {
            var form = $('#form')[0];
            var data = new FormData(form);
            data.append('img_payment', $('#img_payment')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.unblockUI();
                    $('#modal-result').html(data);
                },
                error: function () {
                    $.unblockUI();
                    $('#modal-result').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Terjadi kesalahan!</div>');
                },
                beforeSend: function () {
                    $.blockUI({
                        message: '',
                        baseZ: 10000,
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                    $('#modal-result').html('<div class="progress rounded-corner mb-1 m-b-15"><div class="progress-bar bg-primary progress-bar-striped" style="width: 100%"></div></div>');
                }
            });
        }
    </script>
    <style>
        @media (max-width: 5199px) {
            .page-header {
                display: none;
            }

            .pc-container .page-header+.row {
                padding-top: 4px;
            }
        }
    </style>
</head>

<body data-pc-theme_contrast="<?= website_config('contrast_theme') ?>" data-pc-sidebar-caption="true"
    data-pc-preset="<?= website_config('color_theme') ?>" data-pc-direction="ltr"
    data-pc-theme="<?= website_config('mode_theme') ?>">

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
                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" width="30">
                        <?= strtoupper(website_config('title')) ?>
                    </span>
                    <!--<span class="badge bg-light-success rounded-pill ms-2 theme-version"></span>-->
                </a>
            </div>
            <div class="navbar-content">
                <?php if (admin()) { ?>
                    <div class="card pc-user-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image"
                                        class="user-avtar wid-45 rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3 me-2">
                                    <h6 class="mb-0"><?= admin('full_name') ?></h6>
                                    <small><?= strtoupper(admin('level')) ?></small>
                                </div>
                                <a class="btn btn-icon btn-link-secondary avtar-s" data-bs-toggle="collapse"
                                    href="#pc_sidebar_userlink">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-sort-outline"></use>
                                    </svg>
                                </a>
                            </div>
                            <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                                <div class="pt-3">
                                    <a href="<?= base_url() ?>admin/auth/setting">
                                        <i class="fas fa-cog fs-6 ms-1"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <a href="<?= base_url() ?>admin/auth/session">
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
                                    <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image"
                                        class="user-avtar wid-45 rounded-circle" />
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
                    <?php if (admin()) { ?>
                        <li class="pc-item pc-caption">
                            <label>Navigation</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>admin" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-house-circle-check"></i>
                                </span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="pc-mtext">Layanan</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/service">Daftar
                                        Layanan</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/service_category">Kategori
                                        Layanan</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/service_recommended">Layanan
                                        Rekomendasi</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/custom_price">Harga
                                        Khusus</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/service/desc">Deskripsi
                                        Layanan</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/service/nonaktif">Nonaktifkan
                                        Layanan</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/service/deactivate_by_category">Nonaktifkan
                                        Kategori</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/service/activate_by_category">Aktifkan
                                        Kategori</a></li>

                            </ul>
                        </li>


                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cart-plus"></i>
                                </span>
                                <span class="pc-mtext">Pemesanan</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/order">Riwayat
                                        Pesanan</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/refill">Refill
                                        Pesanan</a></li>
                                        <li class="pc-item"><a class="pc-link" href="<?= base_url() ?>admin/childpanel">Pesanan Sewa Panel</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/order/report">Laporan
                                        Pesanan</a></li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-money-bill-transfer"></i>
                                </span>
                                <span class="pc-mtext">Deposit</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                <span class="pc-badge" style="margin-top: 2px"><?= $depo_pending ?></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/deposit">Data
                                        Deposit</a>
                                </li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/deposit_method">Metode
                                        Deposit</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/deposit/report">Laporan
                                        Deposit</a></li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="pc-mtext">Pengguna</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/admin">Data Admin</a>
                                </li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/user">Data
                                        User</a></li>
                            </ul>
                        </li>
                        <li class="pc-item ">
                            <a href="<?= base_url() ?>admin/ticket" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-headset"></i>
                                </span>
                                <span class="pc-mtext">Tiket Support</span>
                                <span class="pc-badge" style="margin-top: 2px"><?= $unread_ticket ?></span>
                            </a>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span class="pc-mtext">Log</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/log_login_user">Masuk
                                        Pengguna</a></li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/log_login_admin">Masuk
                                        Admin</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/log_balance_usage">Penggunaan
                                        Saldo</a></li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cogs"></i>
                                </span>
                                <span class="pc-mtext">Konfigurasi Provider</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/api">Provider</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/replace_keyword">Replace Keyword Service</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Get Layanan<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link"
                                                href="<?= base_url() ?>admin/service_api">Ambil Satuan</a></li>
                                        <li class="pc-item"><a class="pc-link"
                                                href="<?= base_url() ?>admin/fetch_service/by_category">Ambil By
                                                Kategori</a></li>
                                        <li class="pc-item"><a class="pc-link"
                                                href="<?= base_url() ?>admin/fetch_service">Ambil Semua</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu ">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-cogs"></i>
                                </span>
                                <span class="pc-mtext">Konfigurasi Panel</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/info">Berita &
                                        Informasi</a></li>
                                        <li class="pc-item">
    <a class="pc-link" href="<?= base_url('admin/banner') ?>">
        <span class="pc-micon"><i class="fas fa-images"></i></span>
        <span class="pc-mtext">Kelola Banner</span>
    </a>
</li>
                                <li class="pc-item "><a class="pc-link" href="<?= base_url() ?>admin/page">Halaman</a></li>
                                <li class="pc-item "><a class="pc-link"
                                        href="<?= base_url() ?>admin/web_settings/general">Konfigurasi Website</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-house-circle-check"></i>
                                </span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>auth/login" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-right-to-bracket"></i>
                                </span>
                                <span class="pc-mtext">Masuk</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>auth/register" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-user-plus fs-5"></i>
                                </span>
                                <span class="pc-mtext">Daftar</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url() ?>page/price_list" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="pc-mtext">Layanan</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                </li>
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
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <?php if (admin()) { ?>
                        <li class="pc-h-item">
                            <?php
                            $widget = [
                                'saldo_api' => $this->api_model->get_rows(['select' => 'SUM(balance) AS rupiah, COUNT(id) AS total'])
                            ];
                            ?>
                            <button type="button" class="btn btn-sm btn-primary me-1" onclick="window.location.href=#">Rp
                                <?= currency($widget['saldo_api'][0]['rupiah']) ?></button>
                        </li>
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image" class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body pb-2">
                                    <div class="profile-notification-scroll position-relative"
                                        style="max-height: calc(100vh - 225px)">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image"
                                                    class="user-avtar wid-35" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"><?= admin('full_name') ?> 🖖</h6>
                                                <span><?= admin('username') ?> <span
                                                        class="text-primary fw-bolder"><?= strtoupper(admin('level')) ?></span></span>
                                            </div>
                                        </div>
                                        <hr class="border-secondary border-opacity-50" />
                                        <a href="<?= base_url() ?>admin/auth/setting" class="dropdown-item ">
                                            <span>
                                                <span class="pc-micon">
                                                    <i class="fas fa-cog fs-6 me-2"></i>
                                                </span>
                                                <span>Pengaturan</span>
                                            </span>
                                        </a>
                                        <a href="<?= base_url() ?>admin/auth/session" class="dropdown-item ">
                                            <span>
                                                <span class="pc-micon">
                                                    <i class="fab fa-firefox-browser fs-6 me-2"></i>
                                                </span>
                                                <span>Sesi Aktif</span>
                                            </span>
                                        </a>
                                        <hr class="border-secondary border-opacity-50" />
                                        <div class="d-grid mb-0">
                                            <button class="btn btn-primary" onclick="confirm_logout();">
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
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image" class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body pb-2">
                                    <div class="profile-notification-scroll position-relative"
                                        style="max-height: calc(100vh - 225px)">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img src="<?= base_url() ?>assets/images/male.jpg" alt="user-image"
                                                    class="user-avtar wid-35" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Guest Account 🖖</h6>
                                                <span>Guest</span>
                                            </div>
                                        </div>
                                        <hr class="border-secondary border-opacity-50" />
                                        <div class="d-grid mb-0">
                                            <button class="btn btn-primary"
                                                onclick="window.location.href='<?= base_url() ?>auth/login';">
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
                                <li class="breadcrumb-item"><a
                                        href="<?= base_url() ?>"><?= website_config('title') ?></a></li>
                                <li class="breadcrumb-item" aria-current="page">Halaman Admin</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Halaman Admin</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('result') ?>

            <?= $content ?>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid d-flex justify-content-center text-center">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0"><?= text_gradient(website_config('footer')) ?></span></b></a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- end main content-->
    <!-- END layout-wrapper -->

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog" id="modal-size">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-3" id="modal-body">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var snowEditor = document.querySelectorAll(".snow-editor")
        snowEditor.forEach(function (item) {
            var snowEditorData = {};
            var issnowEditorVal = item.classList.contains("snow-editor");
            if (issnowEditorVal == true) {
                snowEditorData.theme = 'snow',
                    snowEditorData.modules = {
                        'toolbar': [
                            [{
                                'font': []
                            }, {
                                'size': []
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'script': 'super'
                            }, {
                                'script': 'sub'
                            }],
                            [{
                                'header': [false, 1, 2, 3, 4, 5, 6]
                            }, 'blockquote', 'code-block'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }, {
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }],
                            ['direction', {
                                'align': []
                            }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
            }
            new Quill(item, snowEditorData);
        });
    </script>
    <!-- Required Js -->

    <!-- Required Js -->
    <script src="<?= base_url() ?>assets/js/plugins/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/fonts/custom-font.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/tinymce/tinymce.min.js"></script>
    <!--<script src="<?= base_url() ?>assets/js/config.js"></script>-->
    <?php
    $dark_layout = ($mode_theme = website_config('mode_theme')) == 'light' ? false : ($mode_theme == 'dark' ? true : 'default');
    ?>
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
        var theme_contrast = '<?= website_config('contrast_theme') ?>'; // [ false , true ]
        var caption_show = true; // [ false , true ]
        var preset_theme = '<?= website_config('color_theme') ?>'; // [ preset-1 to preset-10 ]
        var dark_layout = '<?= $dark_layout ?>'; // [ false , true , default ]
        var rtl_layout = false; // [ false , true ]
        var box_container = false; // [ false , true ]
        var version = 'v9.0';
    </script>
    <script src="<?= base_url() ?>assets/js/pcoded.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/prism.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/croppr.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/flatpickr.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        $(window).keypress(function (event) {
            if (event.which == '13' && !$(event.target).is('textarea')) {
                event.preventDefault();
            }
        });

        (function ($) {
            $.fn.hasScrollBar = function () {
                return this[0] ? this[0].scrollHeight > this.innerHeight() : false;
            };
        })(jQuery);

        if (!$('body').hasScrollBar()) {
            setTimeout(function () {
                var oldStyle = $('body.swal2-height-auto').attr('style');
                $('body.swal2-height-auto').attr('style', oldStyle + 'padding-right: 0 !important;');
            }, 1);
        }

        if (!$('body').hasScrollBar()) {
            setTimeout(function () {
                var oldStyle = $('body.modal-open').attr('style');
                $('body.modal-open').attr('style', oldStyle + 'padding-right: 0 !important;');
            }, 1);
        }

        $(".modal").on('hide.bs.modal', function () {
            setTimeout(function () {
                $('.select2-data').select2();
            }, 200);
        });

        $(".modal").on('shown.bs.modal', function () {
            setTimeout(function () {
                $(".select2-data").each((_i, e) => {
                    var $e = $(e);
                    $e.select2({
                        dropdownParent: $e.parent()
                    });
                })
            }, 300);
        });

        if (!($(".modal").data('bs.modal') || {})._isShown) {
            document.querySelector('body').style.overflow = 'auto';
            $('.select2-data').select2();
        }

        $(document).ready(function () {
            $('.select2-data').select2();
        });

        var clipboard = new ClipboardJS('.btn');
        clipboard.on('success', function (e) {
            Swal.fire({
                title: 'Yeay!',
                icon: 'success',
                html: 'Teks berhasil disalin.',
                confirmButtonText: 'Okay',
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false,
            });
            e.clearSelection();
        });

        function confirm_logout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                icon: 'question',
                html: 'Semua sesi Anda yang tersimpan akan dihapus.',
                showCancelButton: true,
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url() ?>admin/auth/logout";
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
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false,
            });

        }
    </script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
    <!-- Ckeditor js -->
    <script src="<?= base_url() ?>assets/js/plugins/ckeditor/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            const textareas = document.querySelectorAll('.classic-editor');

            textareas.forEach((textarea) => {
                ClassicEditor.create(textarea).catch((error) => {
                    console.error(error);
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script>

    <!-- TinyMCE -->
    <script>
        tinymce.init({
            height: '500',
            selector: '#h3ruc0d3',
            content_style: 'body { font-family: "Inter", sans-serif; }',
            menubar: false,
            toolbar: [
                'styles fontsize forecolor backcolor emoticons',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | preview code'
            ],
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'template', 'help'
            ],
            skin: 'oxide',
            content_css: '<?= base_url() ?>assets/css/tiny.css'
        });
    </script>
    <!-- [Page Specific JS] end -->
    <!-- end main content-->
</body>

</html>