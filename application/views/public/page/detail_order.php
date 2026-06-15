<div class="row">
	<div class="col-lg-<?= ($data_invoice->status == 'Paid' ? '6' : '12') ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-search-alt mr-2"></i> Order Invoice #<?= $data_invoice->id ?></h6>
            </div>
            <div class="card-body text-center">
            <?php if ($data_invoice->status == 'Paid') { ?>
            <h5>Terimakasih atas pembayaran anda, pesanan anda sudah masuk ke dalam system</h5>
            <?php } else { ?>
                <p class="">Untuk menyelesaikan proses transaksi, silahkan lakukan pembayaran sejumlah</p>
                <h2 class="text-logo">Rp <?= currency($data_order->price) ?></h2>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="alert alert-light alert-side-web" style="box-shadow: 100px !important;">
                            <h3 class="mt-4"><b><i class="uil uil-comment-info"></i> PENTING:</b> Harap bayar sesuai dengan sampai ke 3 digit terakhir</h3>
                        </div><br />
                        <?php if ($data_invoice->payment_gateway == 1) { ?>
                        <?php if ($payment->tripay_code == 'QRISC' OR $payment->tripay_code == 'QRISC') { ?>
                        <p>Silahkan lakukan pembayaran dengan meng-scan QR Code dibawah ini</p>
                        <a href="#"><img src="https://tripay.co.id/qr/<?= $data_invoice->reference ?>" alt="" height="150" />
                        </a>
                        <?php } else { ?>
                        <p>Silahkan lakukan pembayaran dengan menyalin kode VA (Jika Melalui Virtual Account) / kode bayar (Jika Melalui Alfamart/Indomaret/Alfamidi)</p>
                        <h2 class="text-logo"><b><?= $data_invoice->additional_data ?></b> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $data_invoice->additional_data ?>', this)" class="uil uil-copy-alt"></i></h2>
                        <?php } } ?>
                    </div>
                </div>
            <?php } ?>
			</div>
		</div>
	</div>

    <?php if ($data_invoice->status == 'Unpaid') { ?>
	<div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-wallet mr-2"></i> Konfirmasi Pembayaran</h6>
            </div>
            <div class="card-body text-center">
                <div class="text-center">
                    <h5>Nominal Pembayaran</h5>
                    <h2><b>Rp <?= currency($data_order->price) ?></b> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $data_order->id ?>', this)" class="uil uil-copy-alt"></i></h2> <br>
                </div>
                <div class="text-center">
                    <h5>Batas Waktu Pembayaran</h5>
                                
                    <h2><b class="batas-pembayaran">--</b><h2><br>
                </div>
                <?php if ($data_invoice->payment_gateway == 1) { ?>
                <?php if ($payment->tripay_code == 'QRISC' OR $payment->tripay_code == 'QRISC') { ?>
                <p>Silahkan lakukan pembayaran dengan meng-scan QR Code dibawah ini</p>
                <a href="#"><img src="https://tripay.co.id/qr/<?= $data_invoice->reference ?>" alt="" height="150" />
                </a>
                <?php } else { ?>
                <div class="text-center">
                    <p>Silahkan lakukan pembayaran dengan menyalin kode VA (Jika Melalui Virtual Account) / kode bayar (Jika Melalui Alfamart/Indomaret/Alfamidi)</p>
                    <h2 class="text-logo"><b><?= $data_invoice->additional_data ?></b> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $data_invoice->additional_data ?>', this)" class="uil uil-copy-alt"></i></h2>
                </div>
                <?php } } else { ?>
                <h4 class="text-center">Detail Pembayaran:</h4>
                <div class="table-responsive">
                    <table class="table table-colored-bordered table-bordered-dark table-hover">
                        <tbody>
                            <tr>
                                <td>Nama Bank:</td>
                                <td><b><?= $payment->name ?></b></td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening:</td>
                                <td><?= $payment->number_account ?> <i data-toggle="tooltip" data-placement="bottom" title="Copy to clipboard" data-container="body" onclick="copy('<?= $payment->number_account ?>', this)" class="fas fa-copy"></i></td>
                            </tr>
                            <tr>
                                <td>Atas Nama:</td>
                                <td><?= $payment->name_account ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
		</div>
	</div>
	<?php } ?>
    <div class="col-lg-<?= ($data_invoice->status == 'Paid' ? '6' : '6') ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-cart mr-2"></i> Detail Pesanan</h6>
            </div>
            <div class="card-body">
			    <div class="table-responsive">
                    <table class="table table-colored-bordered table-bordered-dark table-hover m-0" id="table-data">
                        <tbody>
                            <tr>
                                <td>Nama Produk</td>
                                <th><?= $data_order->service ?></th>
                            </tr>
                            <tr>
                                <td>Data / Target</td>
                                    <th><?= $data_order->target ?></th>
                                </tr>
                                <?php if ($data_invoice->type == 'SosialMedia') { ?>
                                <tr>
                                    <td>Jumlah</td>
                                    <th><?= $data_order->quantity ?></th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>Harga</td>
                                    <th>Rp <?= $data_order->price - $data_invoice->unique_code ?></th>
                                </tr>
                                <tr>
                                    <td>Kode Unik</td>
                                    <th><?= $data_invoice->unique_code ?></th>
                                </tr>
                                <tr>
                                    <td>Total Pembayaran</td>
                                    <th>Rp <?= currency($data_order->price) ?></th>
                                </tr>
                                <tr>
                                    <td>Waktu Pesanan</td>
                                    <th><?= $data_order->created_at ?></th>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <th>
                                        <?= $this->lib->status_order($data_order->status) ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    		</div>
    	</div>
    
</div>
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

    function CountDownDewek(){
        var endDate = moment('<?= $data_invoice->payment_expired ?>', 'YYYY-MM-DD HH:mm:ss').toDate();
        var countDownDate = endDate.getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            $('.batas-pembayaran').html(('0' + hours).slice(-2) + " jam " +('0' + minutes).slice(-2) + " menit " + ('0' + seconds).slice(-2) + " detik");

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                $('.batas-pembayaran').html("EXPIRED");
            }
        }, 1000);
    }

    $(document).ready(function(){
        CountDownDewek();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
