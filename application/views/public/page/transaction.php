                    <div class="row justify-content-center">
                        <div class="col-md-8">
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
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Pulsa Reguler', '<?= base_url('') ?>transaction/form/Pulsa')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-mobile-vibrate text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Pulsa Reguler</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Sosial Media', '<?= base_url('') ?>transaction/form_sosmed/SosialMedia')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-instagram text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Sosial Media</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Paket Internet', '<?= base_url('') ?>transaction/form/PaketInternet')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-shutter text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Paket Internet</span></h5>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr>
                                            <th>
                                            <a href="javascript: void(0);" onclick="modal_open('Beli Saldo E-Money', '<?= base_url('') ?>transaction/form/Emoney')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-bill text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Saldo E-Money</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Games', '<?= base_url('') ?>transaction/form/Games')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-game text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Games</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Voucher Game', '<?= base_url('') ?>transaction/form/VoucherGame')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-ticket text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Voucher Game</span></h5>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                        <tr>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Token Listrik', '<?= base_url('') ?>transaction/form/TokenListrik')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-auto-flash text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Token Listrik</span></h5>
                                                </a>
                                            </th>
                                            
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Telpon & SMS', '<?= base_url('') ?>transaction/form/PaketSMS')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-phone text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Telpon & SMS</span></h5>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="javascript: void(0);" onclick="modal_open('Beli Lainnya', '<?= base_url('') ?>transaction/form/Other')" class="text-primary btn-loading">
                                                    <center>
                                                        <h1><i class="uil uil-list-ul text-primary"></i></h1>
                                                    </center>
                                                    <h5 class="text-dark mt-3"><span>Lainnya</span></h5>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
