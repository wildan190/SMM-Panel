<?php
/**
 * @var object $target
 * @var object $deposit_method
 * @var Midtrans $midtrans
 */
?>
<div class="row">
                        <div class="col-md-12">
		<div class="text-left mb-2">
		<a href="<?= base_url('deposit/history') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		</div>
                            <div class="card" id="demo">
                                <div class="card-header">
                                    <div class="d-sm-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="b-brand text-primary"><?= website_config('title') ?></h4>
                                                <p class="text-muted mb-1" id="address-details">Medan, Sumatera Utara, Indonesia</p>
                                        </div>
                                     
                                    </div>
                                </div>
                                <!--end card-header-->
                                <div class="card-body p-4">
                                    <div class="row justify-content-center text-center">
                                        <div class="col-lg-12">
                                            <div class="alert alert-primary">Deposit akan sukses dalam waktu 1-10 Menit</div>
                                        </div>
                                        <div class="col-md-4 col-4 mb-3">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Deposit ID</p>
                                            <h5 class="fs-14 mb-0">#<span id="invoice-no"><?= $target->id ?></span></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 col-4 mb-3">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Tanggal</p>
                                            <h5 class="fs-14 mb-0"><span id="invoice-date"><?= $this->lib->format_date($target->created_at) ?>  </span></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4 col-4 mb-3">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Payment Status</p>
                                            <?= $this->lib->status_deposit($target->status) ?>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                                <div class="card-body p-4">
                                    <div class="row mb-3">
                                        <div class="col-6">Pembayaran</div>
                                        <div class="col-6 text-end"><img src="<?= base_url() ?>uploads/<?= $deposit_method->thumbnail_payment ?>" alt="" height="20px"></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">Saldo Didapat</div>
                                        <div class="col-6 text-end">Rp <?= currency($target->balance) ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">Jumlah Deposit</div>
                                        <div class="col-6 text-end">Rp <?= currency($target->balance - ($target->balance - ($target->balance / $deposit_method->rate))) ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">Kode Unik</div>
                                        <div class="col-6 text-end">Rp <?= currency($target->amount - ($target->balance - ($target->balance - ($target->balance / $deposit_method->rate)))) ?></div>
                                    </div>
                                    
                                    <div class="row justify-content-end">
                                        <div class="col-6 text-end">
                                            <div class="row justify-content-end">
                                                <div class="col-md-2 col-5 text-end"><hr /></div>
                                            </div>
                                            <h4>Total Transfer</h4>
                                            <h4>Rp <?= currency($target->amount) ?></h4>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-6">
                                                <div class="clearfix pt-5 <?= $deposit_method->category == 'ewallet' ? 'text-center' : '' ?>">
                                                    <hr>
                                                    <?php if ($deposit_method->type == 'midtrans') { ?>
                                                        <p class="text-center">Silahkan klik tombol di bawah untuk melakukan pembayaran.</p>
                                                        <?php if (empty($target->additional_data)) { ?>
                                                            <div class="alert alert-danger text-center">Token pembayaran tidak ditemukan. Silahkan hubungi Admin.</div>
                                                        <?php } else { ?>
                                                            <button id="pay-button" class="btn btn-primary bg-gradient w-100 mb-2">Bayar Sekarang</button>
                                                             <script src="<?= $midtrans->isProduction() ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' ?>" data-client-key="<?= $midtrans->getClientKey() ?>"></script>
                                                             <script type="text/javascript">
                                                                 var payButton = document.getElementById('pay-button');
                                                                 
                                                                 function triggerSnap() {
                                                                     if (typeof window.snap === 'undefined') {
                                                                         console.log('Snap not ready, retrying in 500ms...');
                                                                         setTimeout(triggerSnap, 500);
                                                                         return;
                                                                     }
                                                                     window.snap.pay('<?= $target->additional_data ?>', {
                                                                         onSuccess: function(result) {
                                                                             console.log(result);
                                                                             location.reload();
                                                                         },
                                                                         onPending: function(result) {
                                                                             console.log(result);
                                                                             location.reload();
                                                                         },
                                                                         onError: function(result) {
                                                                             console.error(result);
                                                                             alert('Pembayaran gagal!');
                                                                         },
                                                                         onClose: function() {
                                                                             alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                                                                         }
                                                                     });
                                                                 }

                                                                 payButton.addEventListener('click', function() {
                                                                     triggerSnap();
                                                                 });

                                                                 // Auto trigger if status is Pending
                                                                 <?php if ($target->status == 'Pending') { ?>
                                                                     window.onload = function() {
                                                                         triggerSnap();
                                                                     };
                                                                 <?php } ?>
                                                             </script>
                                                        <?php } ?>
                                                    <?php } else if ($target->reference <> NULL) { ?>
                                                        <?php if (preg_match("/QRIS/i", $deposit_method->name)) { ?>
                                                            <p class="text-center">Silahkan lakukan pembayaran dengan meng-scan QR Code dibawah ini</p>
                                                            <img style="display: block; margin: auto;" src="<?= $target->additional_data ?>" alt="<?= $deposit_method->name ?>" height="250" />
                                                        <?php } else if (in_array($deposit_method->tripay_code, ['INDOMARET', 'ALFAMART', 'ALFAMIDI']) == true) { ?>
                                                            <p class="text-center">Silahkan salin Kode Pembayaran ini dan tunjukan ke kasir:</p>
                                                            <h2 class="text-center text-primary"><b><?= $target->additional_data ?></b> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $target->additional_data ?>', this)" class="fas fa-copy"></i></h2>
                                                        <?php } else if (in_array($deposit_method->tripay_code, ['OVO', 'SHOPEEPAY']) == true) { ?>
                                                            <p class="text-center">Silahkan klik <b>Link Pembayaran</b> diatas untuk melanjutkan Pembayaran.</p>
                                                        <?php } else if ($deposit_method->category == "ewallet") { ?>
                                                            <p class="text-center">Silahkan melakukan pembayaran melalui link berikut.</p>
                                                            <a href="<?= $target->checkout_url ?>" target="_blank" class="btn btn-primary btn-xl round text-center">Link Pembayaran</a>
                                                        <?php } else { ?>
                                                            <p class="text-center">Silahkan lakukan pembayaran dengan menyalin kode VA</p>
                                                            <center>
                                                                <h2 class="text-center text-primary"><b><?= $target->additional_data ?></b> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $target->additional_data ?>', this)" class="fas fa-copy"></i></h2>
                                                            </center>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if (preg_match("/QRIS/i", $deposit_method->name)) { ?>
                                                            <p class="text-center">Silahkan lakukan pembayaran dengan meng-scan QR Code dibawah ini</p>
                                                            <img style="display: block; margin: auto;" src="<?= base_url("qris.png") ?>" alt="<?= $deposit_method->name ?>" height="250" />
                                                        <?php } else { ?>
                                                            <h4 class="text-center">Detail Pembayaran:</h4>
                                                            <div class="table-responsive">
                                                                <table class="table table-colored-bordered table-bordered-dark table-hover">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Nama Bank:</td>
                                                                            <td><b><?= $deposit_method->name ?></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Nomor Rekening:</td>
                                                                            <td><?= $deposit_method->number_account ?> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $deposit_method->number_account ?>', this)" class="fas fa-copy"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Atas Nama:</td>
                                                                            <td><?= $deposit_method->name_account ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="hstack gap-2 justify-content-center  mt-4">
                                                    <?php if ($deposit_method->type <> 'manual' && $deposit_method->category !== 'ewallet') { ?>
                                                        <a href="<?= $target->checkout_url ?>" target="_blank" class="btn btn-primary btn-sm round">Link Pembayaran</a>
                                                    <?php } ?>
                                                    <a href="javascript:;" onclick="modal_open('Batalkan Deposit', '<?= base_url('deposit/cancel/'.$target->id) ?>')" class="btn btn-danger btn-sm round <?= ($target->status <> 'Pending') ? 'disabled' : '' ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Batalkan"><i class="fas fa-times-circle fs-6 me-2"></i>Batalkan</a>
                                                    <!--<a href="javascript:window.print()" class="btn btn-primary btn-sm round"><i class="fas fa-print fs-6 me-2"></i>Print</a>-->
                                                </div> 
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
<script>

function copy(text, elem) {
        var input = document.createElement('textarea');
        input.innerHTML = text;
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input);

        $(elem).removeClass("uil uil-copy-alt").addClass("uil-file-check-alt").attr("style", "color: <?= website_config('color_theme') ?>;");
        $(elem).attr("title", "Copied!").tooltip("_fixTitle").tooltip("show").attr("title", "Copy to clipboard").tooltip("_fixTitle");

        setTimeout(() => {
            $(elem).removeClass("uil-file-check-alt").addClass("uil uil-copy-alt").removeAttr("style");
        }, 3000);
        // return result;
    }
</script>