<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= website_config('title_landing') ?></title>
    <!-- Primary Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?= website_config('meta_description_landing') ?>" />
    <meta name="keywords" content="<?= website_config('meta_keywords_landing') ?>" />
    <meta name="author" content="<?= website_config('meta_author') ?>" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <link rel="canonical" href="<?= base_url() ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:title" content="<?= website_config('title_landing') ?>" />
    <meta property="og:description" content="<?= website_config('meta_description_landing') ?>" />
    <meta property="og:image" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <meta property="og:image:secure_url" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <meta property="og:image:width" content="3000" />
    <meta property="og:image:height" content="3000" />
    <meta property="og:image:type" content="image/jpg" />
    <meta property="og:image:alt" content="<?= website_config('title_landing') ?>" />
    <meta property="og:locale" content="id_ID" />
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta name="twitter:card" content="summary_large_image"" />
    <meta property=" twitter:url" content="<?= base_url() ?>">
    <meta property="twitter:title" content="<?= website_config('title_landing') ?>" />
    <meta property="twitter:description" content="<?= website_config('meta_description_landing') ?>" />
    <meta property="twitter:image" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />

    <!-- Custom Tag -->
    <?= htmlspecialchars_decode(stripslashes(website_config('custom_tag')), ENT_QUOTES) ?>

    <!-- App favicon -->
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="32x32" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <meta name="msapplication-TileImage" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />

    <!-- [Page specific CSS] start -->
    <link href="<?= base_url() ?>assets/css/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
    <!-- [Page specific CSS] end -->
    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/inter/inter.css" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style-preset.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/landing.css" />

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />


    <!-- Google Analytics -->
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <!-- End Google Analytics -->

    <style>
        .landing-page {
            overflow-y: scroll;
        }
    </style>

            <style>
            .landing-page header {
                background-image: url(<?= base_url() ?>assets/images/landing/lpimage1-default.jpg);
                background-position: center;
                background-size: cover;
                box-shadow: inset 0 0 0 1000px rgba(255, 255, 255, .8);
            }

            [data-pc-theme=dark].landing-page header {
                background: url(<?= base_url() ?>assets/images/landing/lpimage1-default.jpg) center !important;
                background-position: center !important;
                background-size: cover !important;
                box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, .8) !important;
            }
        </style>
    
            <style>
            @media (min-width: 767.99px) {
                .bgImageCustom {
                    padding-top: 150px;
                }
            }
        </style>
    
    <style>
        @media (min-width: 767.99px) {
            header h1 {
                font-size: 2.1875rem;
            }
        }
    </style>
    
    <style>
    /* Animasi Melayang (Floating) */
@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-25px); } /* Menggerakkan gambar ke atas */
    100% { transform: translateY(0px); }
}

/* Terapkan ke logo di header */
.img-head img {
    animation: floating 4s ease-in-out infinite; /* Gerakan halus terus menerus */
    filter: drop-shadow(0 20px 15px rgba(0,0,0,0.1)); /* Tambahan bayangan agar lebih hidup */
}
</style>

    

    <style>
    .platform-section {
        padding: 60px 0; /* Padding atas-bawah section */
        background-color: transparent;
    }

    /* Mengatur jarak teks judul agar tidak mendorong kotak terlalu jauh */
    .platform-section .title-area {
        margin-bottom: 15px !important; /* Jarak antara teks ke kotak (kecilkan angka ini jika ingin lebih rapat) */
    }

    .platform-section h2 {
        margin-bottom: 5px; /* Jarak antara judul ke sub-judul */
    }

    .marquee-platforms {
        width: 100%;
        overflow: hidden;
        padding-top: 0; /* Menghilangkan ruang kosong di atas kotak */
    }

    .platform-track {
        display: flex;
        align-items: center;
        gap: 12px; 
        padding: 10px 0;
    }

    .platform-pill {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 10px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        flex-shrink: 0;
    }

    .platform-pill i {
        font-size: 20px;
        margin-right: 10px;
    }

    .platform-pill span {
        font-size: 15px;
        font-weight: 700;
        color: #333;
    }
</style>
</head>

<body class="landing-page" data-pc-theme_contrast="<?= website_config('contrast_theme') ?>" data-pc-sidebar-caption="true" data-pc-preset="<?= website_config('color_theme') ?>" data-pc-direction="ltr" data-pc-theme="<?= website_config('mode_theme') ?>">

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

    <!-- [ Main Content ] start -->
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
    <!-- [ Header ] start -->
    <!-- <header id="home" style="background-image: url(assets/images/landing/img-headerbg.jpg)"> -->
    <header id="home" class="bgImageCustom">

        <?php $this->load->view('alert') ?>

        <!-- [ Nav ] start -->
        <nav class="navbar navbar-expand-md navbar-light default">
            <div class="container">
                <a class="navbar-brand my-0 py-0 fs-3 fw-bolder hero-text-gradient" href="<?= base_url() ?>"><?= website_config('navbar_brand_landing') ?></a>
                <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-start">
                        <li class="nav-item px-1">
                            <a class="nav-link" href="<?= base_url() ?>">Home</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="<?= base_url() ?>page/price_list">Layanan</a>
                        </li>
                        <li class="nav-item dropdown px-1">
                            <a class="nav-link dropdown-toggle" href="javascript:;" data-bs-toggle="dropdown">Sitemap</a>
                            <ul class="dropdown-menu">
                                <?php
                                $pages = $this->page_model->get_rows();
                                foreach ($pages as $key => $value) { ?>
                                    <li><a class="dropdown-item" href="<?= base_url() ?>page/site/<?= $value['slug'] ?>"><?= $value['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="<?= base_url() ?>auth/register">Daftar</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="<?= base_url() ?>auth/login">Masuk</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="btn btn btn-primary bg-gradient" href="<?= base_url() ?>auth/login">Masuk</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- [ Nav ] end -->
        <!-- [ Container ] start -->
        <div class="container-fluid">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-md my-auto order-md-1 order-2">
                        <div class="mt-5 mt-md-0">
                            <h5 class="wow fadeInDown fw-bold" data-wow-delay="0.3s"><?= text_gradient(website_config('title')) ?></h5>
                            <h1 class="mb-3 wow fadeInLeft" data-wow-delay="0.1s"><?= text_gradient(website_config('description1_landing')) ?></h1>
                            <div class="row wow fadeInLeft" data-wow-delay="0.3s">
                                <div class="col-md-8">
                                    <p class="text-muted f-13 mb-0"><?= text_gradient(website_config('description2_landing')) ?></p>
                                </div>
                            </div>
                            <div class="mt-3 mb-4 mb-sm-5 wow fadeInLeft" data-wow-delay="0.4s">
                                <a href="<?= base_url() ?>auth/login" class="btn btn-primary"><i class="fas fa-right-to-bracket fs-6 me-2"></i>Masuk</a>
                                <a href="<?= base_url() ?>auth/register" class="btn btn-secondary me-2"><i class="fas fa-user-plus fs-6 me-2"></i>Daftar</a>
                            </div>
                            <div class="row g-5 justify-content-center text-center wow fadeInUp" data-wow-delay="0.5s">
                            </div>
                        </div>
                    </div>
                    <div class="offset-lg-1 offset-md-1 col-lg-4 col-md-5 col-9 order-md-2 order-1 wow fadeInRight" data-wow-delay="0.1s">

    <div class="img-head">

        <img class="w-100 p-4" src="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" alt="Logo" style="max-width: 400px !important;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
        <div class="wave wave4"></div>
    </header>
    <!-- [ Header ] End -->
    <!-- [ Top Features apps ] start -->
    <section class="p-0">
    <div class="container position-relative" style="margin-top: -100px; z-index: 15 !important;">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-4">
                <div class="card border-1 shadow-sm card-1 wow fadeInLeft" data-wow-delay="0.1s" 
                     style="background-color: #ffffff; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill-opacity='0.15'%3E%3Cpath fill='%23ff6b6b' d='M10 10h10v2H10z'/%3E%3Cpath fill='%234dabf7' d='M40 20l5 5-5 5-5-5z'/%3E%3Cpath fill='%23fcc419' d='M60 10l3 8h-6z'/%3E%3Cpath fill='%23ff6b6b' d='M20 50l5-5 5 5-5 5z'/%3E%3Cpath fill='%234dabf7' d='M50 60h10v2H50z'/%3E%3Cpath fill='%23fcc419' d='M10 70l3 8h-6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); background-repeat: repeat; background-size: 60px;">
                    <div class="text-center p-3">
                        <h3 class="fw-semibold text-primary"><?php echo (custom_statistic('total_user') != 0) ? currency(custom_statistic('total_user')) : currency($this->user_model->get_count()); ?></h3>
                        <p class="m-0">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="card border-1 shadow-sm card-2 wow fadeInDown" data-wow-delay="0.1s"
                     style="background-color: #ffffff; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill-opacity='0.15'%3E%3Cpath fill='%23ff6b6b' d='M10 10h10v2H10z'/%3E%3Cpath fill='%234dabf7' d='M40 20l5 5-5 5-5-5z'/%3E%3Cpath fill='%23fcc419' d='M60 10l3 8h-6z'/%3E%3Cpath fill='%23ff6b6b' d='M20 50l5-5 5 5-5 5z'/%3E%3Cpath fill='%234dabf7' d='M50 60h10v2H50z'/%3E%3Cpath fill='%23fcc419' d='M10 70l3 8h-6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); background-repeat: repeat; background-size: 60px;">
                    <div class="card-body text-center p-3">
                        <h3 class="fw-semibold text-primary"><?php echo (custom_statistic('total_order') != 0) ? currency(custom_statistic('total_order')) : currency($this->order_model->get_count()); ?></h3>
                        <p class="m-0">Pesanan Dikerjakan</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="card border-1 shadow-sm card-3 wow fadeInRight" data-wow-delay="0.1s"
                     style="background-color: #ffffff; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill-opacity='0.15'%3E%3Cpath fill='%23ff6b6b' d='M10 10h10v2H10z'/%3E%3Cpath fill='%234dabf7' d='M40 20l5 5-5 5-5-5z'/%3E%3Cpath fill='%23fcc419' d='M60 10l3 8h-6z'/%3E%3Cpath fill='%23ff6b6b' d='M20 50l5-5 5 5-5 5z'/%3E%3Cpath fill='%234dabf7' d='M50 60h10v2H50z'/%3E%3Cpath fill='%23fcc419' d='M10 70l3 8h-6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); background-repeat: repeat; background-size: 60px;">
                    <div class="card-body text-center p-3">
                        <h3 class="fw-semibold text-primary"><?= currency($this->service_model->get_count()) ?></h3>
                        <p class="m-0">Layanan Tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="platform-section">
    <div class="container">
        <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
            <div class="col-md-8 col-xl-6 title-area">
                <h2 class="fw-bold">Platform yang Didukung</h2>
                <p class="mb-0 text-muted"><?= text_gradient('Tersedia berbagai platform media sosial populer untuk kebutuhan bisnis dan personal Anda') ?></p>
            </div>
        </div>
    </div>

    <div class="marquee-platforms wow fadeInUp" data-wow-delay="0.4s">
        <div class="platform-track">
            <div class="platform-pill"><i class="fab fa-tiktok" style="color: #000;"></i><span>TikTok</span></div>
            <div class="platform-pill"><i class="fab fa-instagram" style="color: #E4405F;"></i><span>Instagram</span></div>
            <div class="platform-pill"><i class="fab fa-facebook" style="color: #1877F2;"></i><span>Facebook</span></div>
            <div class="platform-pill"><i class="fab fa-youtube" style="color: #FF0000;"></i><span>YouTube</span></div>
            <div class="platform-pill">
                <svg width="20" height="20" viewBox="0 0 24 24" style="margin-right: 10px; fill: #000; vertical-align: middle;"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                <span>X (Twitter)</span>
            </div>
            <div class="platform-pill"><i class="fas fa-shopping-bag" style="color: #EE4D2D;"></i><span>Shopee</span></div>
            <div class="platform-pill"><i class="fab fa-telegram" style="color: #0088cc;"></i><span>Telegram</span></div>
            <div class="platform-pill"><i class="fab fa-pinterest" style="color: #E60023;"></i><span>Pinterest</span></div>
            <div class="platform-pill"><i class="fab fa-twitch" style="color: #9146FF;"></i><span>Twitch</span></div>
            <div class="platform-pill"><i class="fab fa-linkedin" style="color: #0A66C2;"></i><span>LinkedIn</span></div>
            <div class="platform-pill"><i class="fab fa-spotify" style="color: #1DB954;"></i><span>Spotify</span></div>
            <div class="platform-pill"><i class="fab fa-soundcloud" style="color: #ff7700;"></i><span>SoundCloud</span></div>
            <div class="platform-pill"><i class="fab fa-discord" style="color: #5865F2;"></i><span>Discord</span></div>
            <div class="platform-pill"><i class="fab fa-whatsapp" style="color: #25D366;"></i><span>WhatsApp</span></div>
        </div>
    </div>
</section>
    <section>
        <div class="container title">
            <p class="p-0 d-none d-lg-block" style="margin-top: -75px;"></p>
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-8 col-xl-6">
                    <h2 class="mb-3"><?= website_config('about_title_landing') ?></h2>
                    <p class="mb-0"><?= text_gradient(website_config('about_description_landing')) ?></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center mb-4 mb-sm-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body mt-2 text-center">
                            <h5 class="mb-3"><?= website_config('about_1_title') ?></h5>
                            <p class="text-muted mb-3"><?= text_gradient(website_config('about_1_content')) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body mt-2 text-center">
                            <h5 class="mb-3"><?= website_config('about_2_title') ?></h5>
                            <p class="text-muted mb-3"><?= text_gradient(website_config('about_2_content')) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body mt-2 text-center">
                            <h5 class="mb-3"><?= website_config('about_3_title') ?></h5>
                            <p class="text-muted mb-3"><?= text_gradient(website_config('about_3_content')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Top Features ] End -->
    <!-- [ working apps ] start -->
    <section class="bg-primary overflow-hidden">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-8 col-xl-6">
                    <h2 class="mb-3 text-white"><?= text_gradient(website_config('feature_title')) ?></h2>
                    <p class="mb-0 text-white text-opacity-75"><?= text_gradient(website_config('feature_description')) ?></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center d-flex align-items-stretch">
                <?php
                $data = $this->landing_config_model->get_rows(['where' => [['type' => 'features']]]);
                foreach ($data as $key => $value) {
                ?>
                    <div class="col-md-6 app_dotsContainer d-flex align-items-stretch">
                        <a class="app-link active wow fadeInUp" data-wow-delay="0.2s" style="width: 100%;">
                            <h4 class="text-white f-w-500"><?= text_gradient($value['title']) ?></h4>
                            <p class="mb-0 text-white text-opacity-75"><?= text_gradient($value['content']) ?></p>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- [ working apps ] End -->
    <!-- [ Applications apps ] start -->
    <!-- [ Applications apps ] End -->
    <!-- [ support team apps ] start -->
    <section class="support-team-block">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-8 col-xl-6">
                    <h2 class="mb-3"><?= text_gradient(website_config('testi_title')) ?></h2>
                    <!-- prettier-ignore -->
                    <p class="mb-0"><?= text_gradient(website_config('testi_description')) ?></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="marquee marquee-text wow fadeInUp" data-wow-delay="0.4s">
                        <ul class="list-inline marquee-list">
                            <?php
                            $data = $this->landing_config_model->get_rows(['where' => [['type' => 'testimonial_top']]]);
                            foreach ($data as $key => $value) {
                            ?>
                                <li class="list-inline-item">
                                    <div class="card support-card" style="box-shadow: none !important;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="<?= base_url() ?>assets/images/user/<?= $value['icon'] ?>" alt="user-image" class="rounded-circle wid-60 hei-60" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <p class="mb-1">“<?= $value['content'] ?>“</p>
                                                    <small><?= $value['name'] ?> - <span class="text-muted"><?= $value['title'] ?></span></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="marquee-1 marquee-text wow fadeInUp" data-wow-delay="0.5s">
                        <ul class="list-inline marquee-list">
                            <?php
                            $data = $this->landing_config_model->get_rows(['where' => [['type' => 'testimonial_bottom']]]);
                            foreach ($data as $key => $value) {
                            ?>
                                <li class="list-inline-item">
                                    <div class="card support-card" style="box-shadow: none !important;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="<?= base_url() ?>assets/images/user/<?= $value['icon'] ?>" alt="user-image" class="rounded-circle wid-60 hei-60" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <p class="mb-1">“<?= $value['content'] ?>“</p>
                                                    <small><?= $value['name'] ?> - <span class="text-muted"><?= $value['title'] ?></span></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ support team apps ] End -->
    <!-- [ Productivity apps ] start -->
    <!-- [ dashboard apps ] End -->
    <!-- [ companies apps ] start -->
    <!-- [ companies apps ] End -->

    <!-- [ footer apps ] start -->
    <footer class="footer" style="margin-top: -10rem;">
        <div class="border-bottom footer-center" style="padding: 0 0 !important;"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col my-1 wow fadeInUp d-flex justify-content-center" data-wow-delay="0.4s">
                    <p class="mb-0"><?= text_gradient(website_config('footer')) ?></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/fonts/custom-font.js"></script>
    <!-- Sweet Alert -->
    <script src="<?= base_url() ?>assets/js/plugins/sweetalert2.all.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/config.js"></script> -->
    <?php
    $dark_layout = ($mode_theme = website_config('mode_theme')) == 'light' ? false : ($mode_theme == 'dark' ? true : 'default');
    ?>
    <script type="text/javascript">
        'use strict';
        var theme_contrast = '<?= website_config('contrast_theme') ?>'; // [ false , true ]
        var caption_show = true; // [ false , true ]
        var preset_theme = '<?= website_config('color_theme') ?>'; // [ preset-1 to preset-10 ]
        var dark_layout = '<?= $dark_layout ?>'; // [ false , true , default ]
        var rtl_layout = false; // [ false , true ]
        var box_container = false; // [ false , true ]
        var version = 'v9.0';

        function layout_change2(value) {
            $('#theme_mode').val(value);
        }

        function layout_sidebar_change2(value) {
            $('#theme_contrast').val(value);
        }

        function layout_preset2(value) {
            $('#theme_preset').val(value);
        }
    </script>

    <script src="<?= base_url() ?>assets/js/pcoded.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/wow.min.js"></script>
    <!-- <script src="//cdn.jsdelivr.net/jquery.marquee/1.4.0/jquery.marquee.min.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jQuery.Marquee/1.6.0/jquery.marquee.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/Jarallax.js"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();

        // slider start
        $('.screen-slide').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.app_dotsContainer',
            URLhashListener: true,
            items: 1
        });
        $('.workspace-slider').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.workspace-card-block',
            URLhashListener: true,
            items: 1.5
        });
        // slider end
        // marquee start
        $('.marquee').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true
        });
        $('.marquee-1').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true,
            direction: 'right'
        });
        // marquee end
    </script>
    
    <script>
$(document).ready(function(){
    $('.marquee-platforms').marquee({
        duration: 25000, // Kecepatan gerak
        gap: 20,         // Jarak antar loop (samakan dengan gap CSS)
        delayBeforeStart: 0,
        direction: 'left',
        duplicated: true,
        pauseOnHover: true,
        startVisible: true
    });
});
</script>
</body>

</html>