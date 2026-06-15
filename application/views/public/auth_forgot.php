<!doctype html>
<html lang="en">

<head>

    <title><?= website_config('title_forgot') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= website_config('meta_description_forgot') ?>" />
    <meta name="keywords" content="<?= website_config('meta_keywords_forgot') ?>" />
    <meta name="author" content="<?= website_config('meta_author') ?>" />
    <link rel="canonical" href="<?= base_url() ?>" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />

    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= website_config('title_forgot') ?>" />
    <meta property="og:description" content="<?= website_config('meta_description_forgot') ?>" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:site_name" content="<?= website_config('title_forgot') ?>" />
    <meta property="og:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta property="og:image:secure_url" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta property="og:image:width" content="3000" />
    <meta property="og:image:height" content="3000" />
    <meta property="og:image:alt" content="<?= website_config('title_forgot') ?>" />
    <meta property="og:image:type" content="image/jpg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= website_config('title_forgot') ?>" />
    <meta name="twitter:description" content="<?= website_config('meta_description_forgot') ?>" />
    <meta name="twitter:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="<?= website_config('title_forgot') ?>" />
    <meta name="twitter:label2" content="Time to read" />
    <meta name="twitter:data2" content="1 minute" />

    <!-- Custom Tag -->
    <?= htmlspecialchars_decode(stripslashes(website_config('custom_tag')), ENT_QUOTES) ?>

    <!-- App favicon -->
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="32x32" />
    <link rel="icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />
    <meta name="msapplication-TileImage" content="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>" />

    <!-- Google Analytics -->
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <!-- End Google Analytics -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/inter/inter.css" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style-preset.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Sweet Alert -->
    <script src="<?= base_url() ?>assets/js/plugins/sweetalert2.all.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body {
            overflow: auto;
        }
    </style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-theme_contrast="<?= website_config('contrast_theme') ?>" data-pc-sidebar-caption="true" data-pc-preset="<?= website_config('color_theme') ?>" data-pc-direction="ltr" data-pc-theme="<?= website_config('mode_theme') ?>">

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
    <div class="auth-main">
        <?php $this->load->view('result') ?>

        <?= $content ?>
    </div>

    <a href="https://wa.me/6285162911945" class="wa-fab" target="_blank" rel="noopener noreferrer" aria-label="Hubungi WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff;"></i>
    </a>

    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="<?= base_url() ?>assets/js/plugins/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/fonts/custom-font.js"></script>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

        $('.select2').select2();

        $('form').on('submit', function() {
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
        });

        function goauth2(url) {
            window.location.href = url;
        }


        function tos() {
            $('#tos_modal').modal('show');
            $('#agree').on('click', function() {
                $('#tos_modal').modal('hide');
                $('#tos').prop('checked', true);
            });
        }

        function btn_submit() {
            $('#tos_modal').modal('show');
            $('#agree').on('click', function() {
                $('#tos_modal').modal('hide');
                $('#tos').prop('checked', true);
                $('#form-register').submit();
            });
        }

        $(document).ready(function() {
            var uri = window.location.toString();
            if (uri.indexOf("#") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("#"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        });
    </script>
    <script type="text/javascript">
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

        $('.select2').select2();

        $('form').on('submit', function() {
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
        });

        $(document).ready(function() {
            var uri = window.location.toString();
            if (uri.indexOf("#") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("#"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>