<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= (website_config('meta_description')) ? website_config('meta_description') : $config['meta']['description'] ?>" />
    <meta name="keywords" content="<?= (website_config('meta_keywords')) ? website_config('meta_keywords') : $config['meta']['keywords'] ?>" />
    <meta name="author" content="<?= (website_config('meta_author')) ? website_config('meta_author') : $config['meta']['author'] ?>" />
    <link rel="canonical" href="<?= base_url() ?>" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <title>
        <?= (website_config('bartitle')) ? website_config('bartitle') : $config['bartitle'] ?>
    </title>

    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= website_config('bartitle') ? website_config('bartitle') : $config['bartitle'] ?>" />
    <meta property="og:description" content="<?= (website_config('meta_description')) ? website_config('meta_description') : $config['meta']['description'] ?>" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:site_name" content="<?= (website_config('title')) ? website_config('title') : $config['title'] ?>" />
    <meta property="og:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta property="og:image:secure_url" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta property="og:image:width" content="3000" />
    <meta property="og:image:height" content="3000" />
    <meta property="og:image:alt" content="<?= (website_config('title')) ? website_config('title') : $config['title'] ?>" />
    <meta property="og:image:type" content="image/jpg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= (website_config('title')) ? website_config('title') : $config['title'] ?>" />
    <meta name="twitter:description" content="<?= (website_config('meta_description')) ? website_config('meta_description') : $config['meta']['description'] ?>" />
    <meta name="twitter:image" content="<?= base_url() ?>uploads/website/<?= website_config('logo') ?>" />
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="<?= website_config('title') ?>" />
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

    <!-- Google Analytics -->
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <!-- End Google Analytics -->

    <style>
        body {
            overflow: auto;
        }
    </style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-theme_contrast="true" data-pc-sidebar-caption="true" data-pc-preset="<?= website_config('color_theme') ?>" data-pc-direction="ltr" data-pc-theme="light">

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

    <div class="modal fade" id="tos_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Ketentuan Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 250px; overflow: auto;">
                    <p>Ketentuan Layanan yang disediakan oleh <em>
                            <?= website_config('title') ?>
                        </em> telah ditetapkan
                        kesepakatan-kesepakatan berikut.</p>
                    <b>1. Umum</b>
                    <ul>
                        <li>Dengan mendaftar dan menggunakan layanan <em>
                                <?= website_config('title') ?>
                            </em>, Anda secara otomatis
                            menyetujui semua ketentuan layanan kami. Kami berhak mengubah ketentuan layanan ini tanpa
                            pemberitahuan terlebih dahulu. Anda diharapkan membaca semua ketentuan layanan kami sebelum
                            membuat pesanan.</li>
                        <li>Syarat dan Ketentuan Penggunaan ini merupakan catatan elektronik dalam arti hukum yang
                            berlaku. Catatan elektronik ini dibuat oleh sistem komputer dan tidak memerlukan tanda
                            tangan fisik atau digital.</li>
                        <li>Penolakan: <em>
                                <?= website_config('title') ?>
                            </em> tidak akan bertanggung jawab jika Anda mengalami kerugian
                            dalam bisnis Anda.</li>
                        <li>Kewajiban: <em>
                                <?= website_config('title') ?>
                            </em> tidak bertanggung jawab jika Anda mengalami suspensi atau
                            penghapusan akun yang dilakukan oleh Instagram, Twitter, Facebook, Youtube, dan lain-lain.
                        </li>
                    </ul>

                    <b>2. Layanan</b>
                    <ul>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> dapat digunakan untuk media promosi sosial media dan membantu
                            meningkatkan penampilan atau popularitas akun Anda.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> tidak menjamin pengikut baru Anda dapat berinteraksi dengan Anda,
                            kami hanya menjamin bahwa Anda mendapat pengikut yang Anda beli.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> tidak menjamin bahwa 100% akun kami akan memiliki gambar profil,
                            gambar bio dan unggahan penuh, meskipun kami berusaha keras mewujudkan realitas ini untuk
                            semua akun.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> tidak memiliki estimasi atau jendela waktu kapan pesanan Anda akan
                            diselesaikan, namun kami menjamin seluruh pesanan tuntas tanpa terkecuali. Estimasi pada
                            deskripsi layanan hanya perkiraan.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> berusaha sebaik mungkin untuk memberikan apa yang Anda / Reseller
                            harapkan kepada kami.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> tidak menjamin bahwa pesanan Anda tidak mengalami drop atau
                            penurunan, karena pada dasarnya seluruh layanan kami dapat mengalami drop dan drop pada
                            pesanan itu murni atau pure dari sistem platform. Anda dapat menggunakan layanan refill
                            untuk mendapat jaminan isi ulang jika sewaktu-waktu pesanan Anda mengalami drop.</li>
                        <li><em>
                                <?= website_config('title') ?>
                            </em> hanya melakukan pengecekan berdasarkan satu data pesanan terakhir
                            yang Anda pesan dan bukan total keseluruhan pesanan.</li>
                        <li>Proses pesanan pada umumnya selesai dalam hitungan menit atau jam tergantung dari layanan
                            yang Anda pilih.</li>
                        <li>Data target seperti username dan url yang Anda input saat membuat pesanan hanyalah untuk
                            keperluan proses pesanan dan kami tidak akan menyebarluaskannya karena kami menjaga dengan
                            baik Privasi Anda.</li>
                    </ul>

                    <b>3. Refund</b>
                    <ul>
                        <li>Kami tidak menerima permintaan pengembalian saldo dalam bentuk apapun setelah deposit
                            berhasil dilakukan, tidak ada cara untuk mengembalikannya. Anda harus menggunakan saldo Anda
                            untuk memesan dari <em>
                                <?= website_config('title') ?>
                            </em>.</li>
                        <li>Deposit yang tidak di konfirmasi selama 24 jam akan kita anggap hangus, dikarenakan sangat
                            sulit untuk melakukan pengecekan data ataupun mutasi. Karena kami menerima ratusan data
                            deposit setiap hari.</li>
                        <li>Kami tidak menerima permintaan pembatalan/pengembalian dana setelah pesanan masuk ke sistem
                            kami. Kami memberikan pengembalian dana yang sesuai jika pesanan tidak dapat diselesaikan.
                        </li>
                        <li>Jika kami mendapat laporan adanya aktifitas penipuan atau kecurangan. Kami berhak
                            nonaktifkan akun Anda.</li>
                        <li>Jika Anda melakukan double pesan ke target yang sama, atau Anda membuat pesanan kedua
                            sebelum pesanan pertama selesai, kami tidak bertanggung jawab dan tidak ada pengembalian
                            saldo jika terjadi masalah pada salah satu pesanan Anda. Harap berhati-hati dan luangkan
                            waktu Anda untuk menunggu proses pesanan yang telah dibuat.</li>
                        <li>Jika pesanan Anda melebihi batas maksimal pertarget dan pesanan Anda bermasalah, maka tidak
                            ada pengembalian dana dikarenakan itu kesalahan dari pengguna, (Maksimal order pertarget
                            yang tertera di label layanan).</li>
                        <li>Pesanan dengan target akun private atau salah target, tidak akan mendapat pengembalian dana
                            dikarenakan itu kesalahan dari pengguna. Pastikan Anda selalu mengecek kembali pesanan
                            sebelum pesanan dibuat.
                        <li>Untuk layanan No Refill atau tanpa garansi, tidak ada pengembalian dana atau refund saldo
                            bahkan jika drop dalam 5 menit sejak pesanan selesai. Order dengan resiko Anda sendiri!</li>
                    </ul>

                    <b>4. Refill</b>
                    <ul>
                        <li>Layanan yang memiliki label ♻️ pada nama atau deskripsinya, layanan tersebut memiliki tombol
                            refill atau kualitas refill otomatis.</li>
                        <li>Anda diwajibkan untuk menggunakan tombol refill ini jika pesanan mengalami drop!</li>
                        <li>Jika tombol refill tidak bekerja dalam 3 hari, Anda dapat membuat laporan refill secara
                            manual melalui Tiket / WA Support kami.</li>
                        <li>Untuk layanan yang tidak memiliki label ♻️ atau tombol refill, silahkan buat laporan dengan
                            cara kirimkan ID Pesanan refill Anda melalui tiket atau kontak kami.</li>
                        <li>Pesanan dengan status partial tidak dapat direfill.</li>
                        <li>Pesanan akan dapat direfill jika drop dibawah jumlah pesan.</li>
                        <li>Pesanan akan dapat direfill jika jaminan atau periode isi ulang masih berlaku dan belum
                            expired.</li>
                        <li>Pesanan yang turun dibawah jumlah awal pada pesanan tidak dapat direfill, karena sudah
                            dipastikan drop dari pesanan lama sehingga Anda bisa naikan terlebih dahulu pesanan target
                            sampai berada diatas jumlah awal.</li>
                        <li>Jika Anda mengirim atau membuat laporan isi ulang pada saat periode jaminan isi ulang masih
                            berlaku, dan pesanan Anda tidak terefill sampai periode jaminan isi ulang berakhir. Tidak
                            ada pengembalian dana untuk kasus ini.</li>
                        <li>Pesanan yang ada dalam daftar laporan refill, akan dikirimkan setiap hari kepenyedia layanan
                            untuk permintaan isi ulang sehingga kami tidak memiliki estimasi / jendela waktu kapan
                            pesanan akan selesai direfill, semua pesanan yang ada dalam daftar laporan akan di
                            konfirmasi seperti biasa jika pesanan sudah selesai refill. Kami bekerja sebaik mungkin
                            untuk menyelesaikan seluruh pesanan serta mengisi ulang pesanan yang memiliki jaminan
                            refill.</li>
                        <li>Apabila Anda memiliki banyak pesanan untuk target dan jenis layanan yang sama, maka refill
                            hanya berlaku untuk pesanan terakhir yang ditempatkan.</li>
                    </ul>

                    <b>5. Privacy</b>
                    <ul>
                        <li>Kami menjaga privasi Anda dengan serius dan akan mengambil semua tindakan untuk melindungi
                            informasi pribadi Anda.</li>
                        <li>Informasi / data pribadi yang Anda berikan kepada kami selama penggunaan situs akan
                            diperlakukan sebagai kerahasiaan ketat sesuai dengan hukum dan peraturan yang berlaku.</li>
                        <li>Setiap informasi pribadi yang diterima hanya akan digunakan untuk mengisi pesanan Anda. Kami
                            tidak akan menjual atau mendistribusikan ulang informasi Anda kepada siapa pun. Semua
                            informasi dienkripsi dan disimpan di server yang aman.</li>
                    </ul>
                </div>
                <div class="modal-footer py-2">
                    <a href="javascript:;" class="btn btn-primary float-end" id="agree"><i class="fas fa-thumbs-up fs-6 me-2"></i>Saya Setuju</a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="<?= base_url() ?>assets/js/plugins/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/fonts/custom-font.js"></script>
    <!--<script src="<?= base_url() ?>assets/js/config.js"></script>-->
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
        var theme_contrast = 'true'; // [ false , true ]
        var caption_show = 'true'; // [ false , true ]
        var preset_theme = '<?= website_config('color_theme') ?>'; // [ preset-1 to preset-10 ]
        var dark_layout = 'false'; // [ false , true , default ]
        var rtl_layout = 'false'; // [ false , true ]
        var box_container = 'false'; // [ false , true ]
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