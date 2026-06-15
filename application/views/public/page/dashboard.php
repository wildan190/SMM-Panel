<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card text-center">
                    <h1 class="text-logo mb-4 mt-4"><?= website_config('title') ?></h1>
                    <p><?= website_config('meta_description') ?></p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <a href="<?= base_url() ?>auth/login" class="btn btn-blue"><i class="uil uil-sign-in-alt"></i> Masuk</a>
                            <a href="<?= base_url() ?>auth/register" class="btn btn-primary"><i class="uil-user-plus"></i> Registrasi</a>
                            <a href="<?= base_url() ?>transaction/new" class="btn btn-info"><i class="uil uil-shopping-cart-alt"></i> Transaksi Langsung</a>
                        </div>
                    </div>
                    <hr>
                    <h2 class="text-logo mb-4 mt-4">MENGAPA MEMILIH KAMI?</h2>
                    <p>Banyak hal yang harus anda perhatikan sebelum memilih website yang berkualitas, kami dari <?= website_config('title') ?> selalu menyediakan hal terbaik untuk anda.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center">
                    <h1 class="mt-5"><i class="uil-phone-alt"></i></h1>
                    <h4 class="text-logo">Pelayanan Bantuan</h4>
                    <p class="mb-5 mr-2 ml-2">Kami Selalu Siap Membantu Jika Anda Membutuhkan Kami Dalam Penggunaan Layanan Kami Selama 24 Jam / 7 Hari.</p>   
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center">
                    <h1 class="mt-5"><i class="uil uil-web-grid"></i></h1>
                    <h4 class="text-logo">Tampilan Responsive</h4>
                    <p class="mb-5 mr-2 ml-2">Kami Menggunakan Desain Website Yang Dapat Diakses Dari Berbagai Device, Daik Smartphone Android Maupun Deskop.</p>   
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center">
                    <h1 class="mt-5"><i class="uil uil-pricetag-alt"></i></h1>
                    <h4 class="text-logo">Harga Terjangkau</h4>
                    <p class="mb-5 mr-2 ml-2">Kami menawarkan harga pulsa reguler, kuota internet, voucher games, token listrik yang terjangkau dan promo-promo menarik.</p>   
                </div>
            </div>
        </div>
    </div>
</div>