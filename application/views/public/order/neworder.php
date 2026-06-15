
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- [ Detail Pengguna ] Start -->
                            <!-- [ Detail Pengguna ] End -->
                            <!-- [ Carousel ] Start -->
                            <div id="carouselExampleCaptions" class="carousel slide mb-0" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                        <img class="d-block img-fluid" src="<?= base_url() ?>assets/images/banner.jpeg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block img-fluid" src="<?= base_url() ?>assets/images/banner.jpeg">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <!-- [ Carousel ] End -->
                            <div class="card card-body text-center">
                                <table class="mb-0">
                                    <tbody>
                                    <tr>
                                            <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                            <th>
                                                <a href="<?= base_url('') ?>order_pulsa/form/Pulsa" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-phone text-primary"></i></h1>

                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Pulsa Reguler</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Transaksi Sosial Media', '<?= base_url('') ?>order/page')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-instagram text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Social Media</span></h5>
                                                </a>
                                            </th>
                                            
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Paket Internet', '<?= base_url('') ?>order_pulsa/form/PaketInternet')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-random text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Paket Internet</span></h5>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr>
                                            <th>
                                            <a href="javascript: void(0);" onclick="modal_open('Beli Saldo Emoney', '<?= base_url('') ?>order_pulsa/form/Emoney')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-wallet text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Saldo E-Money</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Games', '<?= base_url('') ?>order_pulsa/form/Games')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-ticket text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Games</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Voucher Game', '<?= base_url('') ?>order_pulsa/form/VoucherGame')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-ticket text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Voucher Game</span></h5>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Token Listrik', '<?= base_url('') ?>order_pulsa/form/TokenListrik')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-flash text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Token Listrik</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Telpon & SMS', '<?= base_url('') ?>order_pulsa/form/PaketSMS')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-whatsapp text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Telpon & SMS</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Telpon & SMS', '<?= base_url('') ?>order_pulsa/form/Other')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="fa fa-list-ul text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Lainnya</span></h5>
                                                </a>
                                            </th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>