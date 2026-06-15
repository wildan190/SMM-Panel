<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-3">
                <h4 class="mb-0"><i class="fas fa-link me-2"></i>Statistik Referral</h4>
            </div>
            <?php if (user('referral_status') == 0) { ?>
                <div class="card-body pb-3">
                    <div class="alert alert-primary">
                        <div class="alert-body">
                            <i class="fas fa-exclamation-circle me-1"></i>Undang pengguna baru dan dapatkan komisi!
                            <br>Jika pengguna baru menggunaan kode referral kamu dan melakukan transaksi, kamu akan mendapatkan saldo komisi disetiap transaksi mereka.
                        </div>
                    </div>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target=".confirm-referral" class="btn btn-primary d-grid">AKTIFKAN SEKARANG</a>
                    <div class="modal fade confirm-referral" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Syarat &amp; Ketentuan Referral</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow: auto;">
                                    Sebagai afiliasi resmi dari <?= website_config('title') ?> (<?= base_url() ?>), Anda setuju untuk mematuhi syarat dan ketentuan yang terdapat dalam perjanjian ini. Harap baca seluruh perjanjian dengan seksama sebelum mendaftar dan mempromosikan <?= website_config('title') ?> sebagai afiliator.
                                    <br><br>
                                    Partisipasi Anda dalam Program ini semata-mata untuk mengiklankan situs web kami secara legal untuk menerima komisi keanggotaan dari produk yang dibeli oleh individu yang dirujuk ke <?= website_config('title') ?> oleh situs web Anda sendiri atau rujukan pribadi.
                                    <br><br>
                                    Dengan mendaftar sebagai program afiliasi <?= website_config('title') ?>, Anda menunjukkan penerimaan Anda terhadap perjanjian ini dan syarat dan ketentuannya.
                                    <br><br>
                                    <b>1. Persetujuan atau Penolakan Aplikasi</b>
                                    <ul>
                                        <li>Kami berhak untuk menyetujui atau menolak Aplikasi Program Afiliasi APAPUN atas kebijakan kami sendiri dan mutlak. Anda tidak akan memiliki tuntutan hukum terhadap kami atas penolakan Aplikasi Program Afiliasi Anda.</li>
                                    </ul>
                                    <b>2. Komisi</b>
                                    <ul>
                                        <li>Setiap individu yang dirujuk ke <?= website_config('title') ?> melakukan transaksi, maka Anda akan mendapatkan Saldo Komisi dari transaksi tersebut.</li>
                                        <li>Pesanan dengan Status Success dan Partial saja yang akan menambah Saldo Komisi Anda (Status Pesanan Pending/Processing/Error tidak menambah Saldo Komisi Anda).</li>
                                        <li>Anda dapat melakukan Convert Saldo Komisi pada halaman yang telah kami sediakan dan minimal untuk Convert Saldo Komisi adalah Rp 1.000.</li>
                                        <li>
                                            Persenan Komisi yang Anda dapat menyesuaikan dengan Level Akun Anda, berikut Daftar Persenan Komisi berdasarkan Level Akun :<br>
                                            - SILVER : <?= website_config('referral_rate_silver') ?>%<br>
                                            - GOLD : <?= website_config('referral_rate_gold') ?>%<br>
                                            - PLATINUM : <?= website_config('referral_rate_platinum') ?>%<br>
                                            - DIAMOND : <?= website_config('referral_rate_diamond') ?>%<br>
                                            Saldo Komisi dapat di-Stack, sebagai contoh :<br>
                                            Status Level Akun Anda adalah <?= user('benefit') ?> (Benefit Persenan Komisi <?= website_config('referral_rate_' . strtolower(user('benefit')) . '') ?>%) dan Individu yang dirujuk melakukan transaksi sebesar Rp 10.000 sehingga Anda akan mendapatkan Saldo Komisi Rp <?= currency((10000 * website_config('referral_rate_' . strtolower(user('benefit')) . '')) / 100) ?>.<br>
                                            Jadi setiap Individu yang dirujuk melakukan transaksi, maka Anda akan mendapatkan Saldo Komisi (Bisa di-Stack)
                                        </li>
                                    </ul>
                                    <b>3. Penghentian</b>
                                    <ul>
                                        <li>Iklan yang tidak pantas (Klaim palsu, Hyperlink yang menyesatkan, dll).</li>
                                        <li>Spamming (Email massal, Posting newsgroup massal, dll).</li>
                                        <li>Beriklan di situs yang berisi atau mempromosikan aktifitas ilegal.</li>
                                        <li>Pelanggaran hak kekayaan intelektual. <?= website_config('title') ?> berhak untuk meminta perjanjian lisensi dari mereka yang menggunakan merek dagang <?= website_config('title') ?> untuk melindungi hak kekayaan intelektual kami.</li>
                                        <li>Menawarkan potongan harga, diskon, atau bentuk lain dari imbalan yang dijanjikan dari komisi afiliasi Anda sebagai insentif.</li>
                                        <li>Referensi diri, transaksi penipuan, dugaan penipuan afiliasi.</li>
                                        <li><?= website_config('title') ?> berhak untuk menghentikan akun afiliasi kapan saja, karena pelanggaran apa pun terhadap perjanjian ini atau tanpa alasan.</li>
                                    </ul>
                                    <b>4. Tautan Afiliasi</b>
                                    <ul>
                                        <li>Anda dapat menggunakan tautan afiliasi dan membuat teks untuk mengiklankan di situs web Anda maupun di dalam pesan email Anda. Anda juga dapat mengiklankan situs <?= website_config('title') ?> di iklan baris, majalah, dan surat kabar online dan offline.</li>
                                    </ul>
                                    <b>5. Diskon dan Penawaran</b>
                                    <ul>
                                        <li><?= website_config('title') ?> terkadang menawarkan diskon untuk memilih afiliasi dan pelanggan kami. Jika Anda tidak mendapatkan pra-persetujuan / diberikan diskon bermerek, maka Anda tidak diperbolehkan untuk mempromosikan diskon tersebut. Di bawah ini adalah persyaratan yang berlaku untuk setiap afiliasi yang sedang mempertimbangkan untuk mempromosikan produk kami sehubungan dengan kesepakatan atau diskon.</li>
                                        <li>Afiliasi tidak boleh menggunakan teks yang menyesatkan pada tautan, tombol, atau gambar afiliasi untuk menyiratkan bahwa apa pun selain penawaran resmi saat ini kepada afiliasi tertentu.</li>
                                        <li>Afiliasi tidak boleh menawar diskon <?= website_config('title') ?>, Diskon <?= website_config('title') ?>, atau frasa lain yang menyiratkan diskon tersedia.</li>
                                        <li>Afiliasi tidak boleh membuat pop-up, pop-under, iframe, bingkai, atau tindakan lain yang terlihat atau tidak terlihat mengatur cookie afiliasi kecuali jika pengguna telah menyatakan minat yang jelas dan eksplisit dalam mengaktifkan penghematan tertentu dengan mengklik tautan yang ditandai dengan jelas, tombol atau gambar untuk diskon atau kesepakatan tertentu. Tautan Anda harus mengarahkan pengunjung ke situs <?= website_config('title') ?>.</li>
                                        <li>Pengguna harus dapat melihat informasi dan detail diskon/promo sebelum cookie afiliasi ditetapkan (Seperti “Klik di sini untuk melihat diskon dan membuka jendela ke situs pedagang” tidak diperbolehkan).</li>
                                    </ul>
                                    <b>6. Kewajiban</b>
                                    <ul>
                                        <li><?= website_config('title') ?> tidak akan bertanggung jawab atas kerusakan tidak langsung atau tidak disengaja (Kehilangan Pendapatan / Komisi) karena kegagalan pelacakan afiliasi, kehilangan file database, atau akibat dari niat merusak Program dan/atau situs web kami.</li>
                                        <li>Kami tidak membuat jaminan tersurat maupun tersirat sehubungan dengan Program dan/atau keanggotaan atau produk.</li>
                                    </ul>
                                    <b>7. Jangka Waktu Perjanjian</b>
                                    <ul>
                                        <li>Jangka waktu Perjanjian ini dimulai setelah Anda menerima Program dan akan berakhir ketika akun Afiliasi Anda dihentikan.</li>
                                        <li>Syarat dan ketentuan perjanjian ini dapat diubah oleh kami setiap saat. Jika ada modifikasi pada syarat dan ketentuan Perjanjian ini yang tidak dapat Anda terima, satu-satunya pilihan Anda adalah menghentikan akun Afiliasi Anda. Partisipasi Anda yang berkelanjutan dalam Program ini merupakan penerimaan Anda terhadap perubahan apa pun.</li>
                                    </ul>
                                    <b>8. Ganti Rugi</b>
                                    <ul>
                                        <li>Afiliasi akan mengganti kerugian dan membebaskan <?= website_config('title') ?> dan afiliasi dan anak perusahaannya, pejabat, direktur, karyawan, pemegang lisensi, penerus dan penerima, termasuk yang dilisensikan atau diberi wewenang oleh <?= website_config('title') ?> untuk mengirimkan dan mendistribusikan materi, dari setiap dan semua kewajiban, kerusakan , denda, penilaian, klaim, biaya, kerugian, dan pengeluaran (termasuk biaya dan biaya hukum yang wajar) yang timbul dari atau terkait dengan setiap dan semua klaim yang dipertahankan sehubungan dengan Perjanjian ini karena kelalaian, kesalahan penyajian, kegagalan untuk mengungkapkan, atau kesengajaan kesalahan Afiliasi.</li>
                                    </ul>
                                    <b>9. Tanda Tangan Elektronik Efektif</b>
                                    <ul>
                                        <li>Perjanjian adalah kontrak elektronik yang menetapkan persyaratan yang mengikat secara hukum dari partisipasi Anda dalam program afiliasi <?= website_config('title') ?>. Anda menunjukkan penerimaan Anda terhadap Perjanjian ini dan semua syarat dan ketentuan yang terkandung atau dirujuk dalam Perjanjian ini dengan menyelesaikan proses aplikasi ShareASale dan/atau <?= website_config('title') ?>. Tindakan ini menciptakan tanda tangan elektronik yang mempunyai kekuatan dan akibat hukum yang sama dengan tanda tangan tulisan tangan.</li>
                                    </ul>
                                </div>
                                <div class="modal-footer p-2">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
                                    <button type="button" onclick="window.location.href='<?= base_url() ?>referral/statistic?act=on'" class="btn btn-primary"><i class="fas fa-thumbs-up fs-6 me-2"></i>Setuju &amp; Aktifkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card-body pb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-primary">
                                <div class="alert-body">
                                    <b>SILVER: <?= website_config('referral_rate_silver') ?>%</b>
                                    <br><b>GOLD: <?= website_config('referral_rate_gold') ?>%</b>
                                    <br><b>PLATINUM: <?= website_config('referral_rate_platinum') ?>%</b>
                                    <br><b>DIAMOND: <?= website_config('referral_rate_diamond') ?>%</b>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered mb-1">
                                <thead>
                                    <tr>
                                        <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
                                            <h5 class="mb-0 text-center text-primary"><b>SALDO KOMISI</b></h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td height="70">
                                            <h5 class="mb-0 text-primary text-center fs-4 fw-bolder">Rp <?= currency(user('referral_saldo')) ?></h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered mb-1">
                                <thead>
                                    <tr>
                                        <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
                                            <h5 class="mb-0 text-center text-primary"><b>CONVERSION RATE</b></h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td height="70">
                                            <h5 class="mb-0 text-primary text-center fs-4 fw-bolder"><?= (user('referral_view') == 0 ? '0' : round($total_data / user('referral_view') * 100)) ?>%</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">
                                            <h5 class="mb-0 text-center text-primary"><b>REFERRAL RATE</b></h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td height="70">
                                            <h5 class="mb-0 text-primary text-center fs-4 fw-bolder"><?= website_config('referral_rate_' . user('benefit') . '') ?>% / Pesanan</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <hr class="d-block d-md-none">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="float-start"><b>Referral</b> Link</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm float-end" value="<?= base_url() ?>auth/register?referral=<?= user('referral_code') ?>" disabled="">
                                                <a href="javascript:;" class="btn btn-primary btn-sm" style="width: 100px; padding-top: 0.3rem;" onclick="copy_text('Referral Link', '<?= base_url() ?>auth/register?referral=<?= user('referral_code') ?>');"><i class="fas fa-copy me-2"></i>Salin</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="float-start"><b>Total</b> Visits</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="float-end btn btn-primary btn-sm round"><b><?= currency(user('referral_view')) ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="float-start"><b>Total</b> Registered</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="float-end btn btn-primary btn-sm round"><b><?= currency($total_user) ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="float-start"><b>Convert</b> Referrals</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="float-end btn btn-primary btn-sm round"><b>Rp <?= number_format($total_convert[0]['rupiah'], 0, ',', '.') ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="float-start"><b>Total</b> Earnings</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="float-end btn btn-primary btn-sm round"><b>Rp <?= number_format($widget_order[0]['rupiah'], 0, ',', '.') ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="payout"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if (user('referral_status') != 0) { ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <h4 class="m-0"><i class="far fa-handshake me-2"></i>Referral Saya</h4>
                </div>
                <div class="card-body">
                    <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter me-2"></i>Filter Data</a>
                    <div class="modal fade filter-data" tabindex="-1" aria-hidden="true">
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
                                                    <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Kolom Sortir</label>
                                            <input type="text" class="form-control" name="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="Cari...">
                                        </div>
                                        <div class="form-group col-md-6 d-grid">
                                            <a href="<?= base_url() ?>referral/statistic" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                                        </div>
                                        <div class="form-group col-md-6 d-grid">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover m-0" id="table-data">
                            <thead>
                                <tr class="">
                                    <th scope="col">NAMA</th>
                                    <th scope="col">TERDAFTAR SEJAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($table as $key => $value) {
                                ?>
                                    <tr>
                                        <td><?= $value['full_name'] ?></td>
                                        <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="align-items-center mt-2 row text-center text-sm-start">
                        <div class="col-sm mb-2">
                            <div class="text-muted">
                                <?= $this->pagination->create_links() ?>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <span class="text-muted">Menampilkan <?= currency($awal) ?> sampai <?php
                                                                                                if ($akhir >= $total_data) {
                                                                                                    $akhir_page = $total_data;
                                                                                                } else {
                                                                                                    $akhir_page = $akhir;
                                                                                                }
                                                                                                ?><?= currency($akhir_page) ?> dari <?= currency($total_data) ?> data.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
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
    $(function() {
        $('#rows').on('change', function() {
            var rows = $('#rows').val();
            var category = $('#category').val();
            var search = $('#search').val();
            window.location = "<?= base_url('referral/statistic') ?>?rows=" + rows + "&search=" + search;
        });
        $('#category').on('change', function() {
            var rows = $('#rows').val();
            var category = $('#category').val();
            var search = $('#search').val();
            window.location = "<?= base_url('referral/statistic') ?>?rows=" + rows + "&search=" + search;
        });
    });
</script>