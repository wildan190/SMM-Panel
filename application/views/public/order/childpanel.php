<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="sticky-md-top product-sticky">
                            <div id="carouselExampleCaptions" class="carousel slide ecomm-prod-slider"
                                data-bs-ride="carousel">
                                <div class="carousel-inner bg-light rounded position-relative">
                                    <div class="card-body position-absolute end-0 top-0">
                                        <div class="form-check prod-likes">
                                            <input type="checkbox" class="form-check-input">
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="card-body position-absolute bottom-0 end-0">
                                        <ul class="list-inline ms-auto mb-0 prod-likes">
                                            <li class="list-inline-item m-0">
                                                <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                    <i class="ti ti-zoom-in f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item m-0">
                                                <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                    <i class="ti ti-zoom-out f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item m-0">
                                                <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                    <i class="ti ti-rotate-clockwise f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="carousel-item active">
                                        <img src="<?= base_url() ?>assets/images/childpanel/Child1.jpg" class="d-block w-100"
                                            alt="Product images">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?= base_url() ?>assets/images/childpanel/Child1.jpg" class="d-block w-100"
                                            alt="Product images">
                                    </div>
                                </div>
                                <ol
                                    class="list-inline carousel-indicators position-relative product-carousel-indicators my-sm-3 mx-0">
                                    <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                        class="list-inline-item w-25 h-auto active">
                                        <img src="<?= base_url() ?>uploads/website/<?= website_config('favicon') ?>"
                                            class="d-block wid-50 rounded" alt="Product images">
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="badge bg-success f-14 align-items-center"><i
                                class="ph-duotone ph-rocket me-1"></i>Sewa Panel</span>
                        <h2 class="my-3 text-primary">SEWA SMM PANEL FLAXSPEDIA</h2>
                        <h5 class="mt-4 mb-sm-3 mb-1 f-w-500">Description</h5>
                        <ul>
                            <li class="mb-1">10 Primary Theme Color</li>
                            <li class="mb-1">Customized Footer / Copyright</li>
                            <li class="mb-1">Customized Permissions For Admin</li>
                            <li class="mb-1">Customized Favicon</li>
                            <li class="mb-1">Customized Open Graph Image</li>
                            <li class="mb-1">Customized Meta Tags</li>
                            <li class="mb-1">Customized Additional Tags</li>
                            <li class="mb-1">Customized Statistic System</li>
                            <li class="mb-1">Light & Dark Mode Available</li>
                            <li class="mb-1">Support Refill System</li>
                            <li class="mb-1">Support Level System</li>
                            <li class="mb-1">Support Point System</li>
                            <li class="mb-1">Support Referral System</li>
                            <li class="mb-1">Support Payment Gateway (Paydisini, Tripay & Tokopay)</li>
                            <li class="mb-1">Support Whatsapp Gateway</li>
                        </ul>
                        <div class="mb-3 row">
                            <label class="col-form-label col-lg-3 col-sm-12">Primary Color</label>
                            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                                <div class="theme-color preset-color">
                                    <?php for($i=1; $i<=10; $i++): ?>
                                    <a href="#!" class="<?= (user('layout') == 'preset-'.$i) ? 'active' : '' ?>"
                                        data-value="preset-<?= $i ?>" onclick="layout_preset2('preset-<?= $i ?>');"><i
                                            class="ti ti-check"></i></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, rgba(var(--bs-primary-rgb), 0.1), rgba(var(--bs-primary-rgb), 0.05)); border-left: 5px solid var(--bs-primary) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-primary text-white me-2">
                        <i class="ti ti-info-circle f-20"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-primary">Panduan & Instruksi Pemesanan</h5>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-1 f-20"></i></span>
                                <span>Pastikan Anda sudah memiliki <b>Domain aktif.</b> jika anda beli paket Pro atau Unlimited Domain dari kami.</span>
                            </li>
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-2 f-20"></i></span>
                                <span><b>Nameserver (NS) Domain</b> akan diinformasikan setelah pemesanan.</span>
                            </li>
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-3 f-20"></i></span>
                                <span>Sewa Panel otomatis terhubung ke akun <b><?= website_config('title') ?></b> Anda.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-4 f-20"></i></span>
                                <span>Proses aktivasi membutuhkan waktu estimasi <b>1x24 Jam</b>.</span>
                            </li>
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-5 f-20"></i></span>
                                <span>Akses <b>Admin Panel</b> akan diberikan setelah status pesanan Aktif.</span>
                            </li>
                            <li class="d-flex mb-2">
                                •<span class="text-primary me-2"><i class="ti ti-circle-number-6 f-20"></i></span>
                                <span>Setelah pesan, harap <b>Konfirmasi ke Admin</b> untuk mempercepat proses.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

                        <form method="POST">
                            <input type="hidden" class="txt_csrfname"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            
                            <div class="row mt-4">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Nama Domain Anda <span class="text-danger">*</span></label>
                                    <div class="input-group border border-primary rounded shadow-sm">
                                        <span class="input-group-text bg-primary text-white"><i class="ti ti-world"></i></span>
                                        <input type="text" class="form-control" name="domain" placeholder="contoh: domainanda.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label fw-bold">Pilih Paket <span class="text-danger">*</span></label>
                                <div class="payment-group form-group">
                                    <div class="row gy-2 gx-2">
                                        <div class="col-12">
                                            <div class="payment-menu h-100">
                                                <input type="radio" name="plan" id="plan_39" value="39" required>
                                                <label for="plan_39" class="payment-item h-100" style="text-align: start;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                                    <i class="fas fa-rocket fs-2 p-2 text-white"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fw-bold">Lite</p>
                                                            <p class="small m-0">
                                                                3.000 Pesanan/bulan<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Terima Beres.<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Server Lite<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Kontrol Panel Admin<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Payment Gateway Tripay, Paydisini & Tokopay<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Bantuan Teknis Support</p>
                                                        </div>
                                                        <div class="flex-shrink-0 align-self-end ms-2">
                                                            <p class="mb-0 fw-bold">Rp 50.000<small class="small">/bulan</small></p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="payment-menu h-100">
                                                <input type="radio" name="plan" id="plan_40" value="40">
                                                <label for="plan_40" class="payment-item h-100" style="text-align: start;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                                    <i class="fas fa-rocket fs-2 p-2 text-white"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fw-bold">Basic</p>
                                                            <p class="small m-0">
                                                                5.000 pesanan/bulan<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Terima Beres.<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Server Basic<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Kontrol Panel Admin<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Payment Gateway Tripay, Paydisini & Tokopay<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Bantuan Teknis Support</p>
                                                        </div>
                                                        <div class="flex-shrink-0 align-self-end ms-2">
                                                            <p class="mb-0 fw-bold">Rp 100.000<small class="small">/bulan</small></p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="payment-menu h-100">
                                                <input type="radio" name="plan" id="plan_42" value="42">
                                                <label for="plan_42" class="payment-item h-100" style="text-align: start;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                                    <i class="fas fa-rocket fs-2 p-2 text-white"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fw-bold">Pro</p>
                                                            <p class="small m-0">
                                                                10.000 pesanan/bulan<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Terima Beres.<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Gratis Domain .my.id<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Server Khusus (Pro Performance)<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Kontrol Panel Admin<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Payment Gateway Tripay, Paydisini & Tokopay<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Full Support Prioritas</p>
                                                        </div>
                                                        <div class="flex-shrink-0 align-self-end ms-2">
                                                            <p class="mb-0 fw-bold">Rp 250.000<small class="small">/bulan</small></p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="payment-menu h-100">
                                                <input type="radio" name="plan" id="plan_43" value="43">
                                                <label for="plan_43" class="payment-item h-100" style="text-align: start;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary bg-gradient">
                                                                    <i class="fas fa-rocket fs-2 p-2 text-white"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fw-bold">Unlimited</p>
                                                            <p class="small m-0">
                                                                Unlimited pesanan/bulan<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Terima Beres.<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Gratis Domain .com<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Server Khusus (High Performance)<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Kontrol Panel Admin<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Payment Gateway Tripay, Paydisini & Tokopay<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Full Support Prioritas</p>
                                                        </div>
                                                        <div class="flex-shrink-0 align-self-end ms-2">
                                                            <p class="mb-0 fw-bold">Rp 500.000<small class="small">/bulan</small></p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="payment-menu h-100">
                                                <input type="radio" name="plan" id="plan_47" value="47">
                                                <label for="plan_47" class="payment-item h-100" style="text-align: start;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary">
                                                                    <i class="fas fa-code fs-2 p-2 text-white"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fw-bold">Source Code (Lifetime)</p>
                                                            <p class="small m-0">
                                                                Bayar sekali, miliki selamanya. Install di server sendiri dengan kontrol penuh.<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> File Script CODEIGNITER 3<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> Database SQL<br>
                                                                <i class="fas fa-check-circle text-success me-1"></i> <b>Tanpa Enkripsi</b><br>
                                                        </div>
                                                        <div class="flex-shrink-0 align-self-end ms-2">
                                                            <p class="mb-0 fw-bold">Rp 1.500.000</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary float-end px-5 shadow-sm"><i class="fas fa-rocket fs-6 me-2"></i>Pesan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr class="my-5">
                <?php $childpanel_orders = $this->db->where('user_id', user('id'))->get('childpanel')->result();
                if (!empty($childpanel_orders)): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">Riwayat Pesanan</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Domain</th>
                                        <th>Status</th>
                                        <th>Tgl Order</th>
                                        <th>Expired</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($childpanel_orders as $index => $order): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= auto_link($order->domain, 'both', TRUE) ?></td>
                                        <td><span class="badge bg-light-<?= ($order->status == 'Active') ? 'success' : 'warning' ?> text-<?= ($order->status == 'Active') ? 'success' : 'warning' ?>"><?= $order->status ?></span></td>
                                        <td><?= $this->lib->format_date($order->order_date) ?></td>
                                        <td><?= $this->lib->format_date($order->expired_date) ?></td>
                                        <td>
                                            <?php if ($order->status == 'Active'): ?>
                                            <a href="<?= site_url('childpanel/perpanjang/' . $order->id) ?>" class="btn btn-sm btn-success">Perpanjang</a>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled>Perpanjang</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
