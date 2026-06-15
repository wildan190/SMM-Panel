<div class="row">
<?php
if (website_config('order_info') <> '') {
?>
	<div class="col-lg-12 text-center">
		<div class="alert alert-light alert-side-web"><i class="fa fa-info-circle"></i> <b class="text-uppercase">Penting!</b><br />
        Halo! sebelum membuat pesanan disarankan untuk membaca <b>Informasi</b> terlebih dahulu. <b>Informasi</b> terletak dibagian bawah form pesanan.
        </div>
	</div>
<?php
}
?>
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-cart mr-2"></i> Pesanan Baru</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url() ?>transaction/submit">
                    <input type="hidden" name="type" value="<?= @$type->type ?>" id="type">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label class="control-label">Data</label>
                        <input type="text" id="nomorhp" class="form-control" minlength="8" name="target" placeholder="No HP / Target" />
                    </div>
                    <?php if (@$type->type == 'TokenListrik') { ?>
                    <div class="form-group">
                        <label class="control-label">No Meter</label>
                        <input type="text" class="form-control" minlength="8" name="no_meter" placeholder="No Meter untuk Token Listrik" />
                    </div>
                    <?php } ?>
                    <?php if (@$type->type <> 'Pulsa' AND @$type->type <> 'PaketInternet' AND @$type->type <> 'PaketSMS') { ?>
                    <div class="form-group">
                        <label class="control-label">Kategori</label>
                        <span class="form-control" style="padding: 4px;">
                            <select class="form-control select2" name="category" id="category">
                                <option value="">-- Silahkan Pilih Kategori--</option>
                                <?php foreach ($category as $key => $value) { ?>
                                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Layanan</label>
                                <span class="form-control" style="padding: 4px;">
                                    <select class="form-control select2" name="service" id="service" required>
                                        <option value="">-- Silahkan Isi Nomor HP --</option>
                                    </select>
                                </span>
                                <span class="text-danger" id="description"></span>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <span class="form-control" id="price">0</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Metode Pembayaran</label>
                                <span class="form-control" style="padding: 4px;">
                                    <select class="form-control select2" name="payment_method" id="payment_method" required>
                                        <option value="">-- Silahkan Pilih Pembayaran --</option>
                                        <?php foreach ($payment_method as $key => $value) { ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?> - <?= $value['category'] ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
                    </div>
                </form>
		    </div>
        </div>
	</div>
	<div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-comment-info mr-2"></i> Cara Pemesanan</h6>
            </div>
            <div class="card-body">
                 <p><?= nl2br(website_config('order_info')) ?></p>
	        </div>
	    </div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#nomorhp").keyup(function(){
            const nope = $('#nomorhp').val();
            const type = $('#type').val();
            const operator = nope.substring(0,4);
            if (operator === '0811' || operator === '0812' || operator === '0813' || operator === '0821' || operator === '0822' || operator === '0852' || operator === '0853' || operator === '0823' || operator === '0851') {
                $("#nomorhp").addClass('telkomsel');
                var kartu = 'TELKOMSEL';
            } else if(operator === '0814' || operator === '0815' || operator === '0816' || operator === '0855' || operator === '0856' || operator === '0857' || operator === '0858'){
                $("#nomorhp").addClass('indosat');
                var kartu = 'INDOSAT';
            } else if(operator === '0817' || operator === '0818' || operator === '0819' || operator === '0859' || operator === '0877' || operator === '0878') {
                $("#nomorhp").addClass('xl');
                var kartu = 'XL';
            } else if(operator === '0838' || operator === '0831' || operator === '0832' || operator === '0833'){
                $('#nomorhp').addClass('axis');
                var kartu = 'AXIS';
            } else if(operator === '0895' || operator === '0896' || operator === '0897' || operator === '0899'){
                $('#nomorhp').addClass('three');
                var kartu = 'TRI';
            } else if(operator === '0881' || operator === '0882' || operator === '0883' || operator === '0884' || operator === '0885' || operator === '0886' || operator === '0887' || operator === '0888' || operator === '0889'){
                $('#nomorhp').addClass('smartfren');
                var kartu = 'SMARTFREN';
            } else if(operator === '0828'){
                $('#nomorhp').addClass('ceria');
                var kartu = 'CERIA';
            } else if(nope.length < 4){
                var kartu = null;
                $("#nomorhp").removeClass('telkomsel');
                $("#nomorhp").removeClass('indosat');
                $("#nomorhp").removeClass('xl');
                $("#nomorhp").removeClass('axis');
                $("#nomorhp").removeClass('three');
                $("#nomorhp").removeClass('smartfren');
                $("#nomorhp").removeClass('ceria');
            }
            $.ajax({
                type: "GET",
                url: "<?= base_url('transaction/ajax_order/') ?>" + kartu + "?type=" + type,
                dataType: "html",
                success: function (data) {
                    $("#service").html(data);
                    $("#note").html("");
                    $("#price").val("0");
                },
                error: function () {
                    $("#ajax-result").html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
                },
            });    
        });
        $('#category').on('change', function() {
                var category = $('#category').val();
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('ajax/service_pulsa_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                    dataType: "json",
                    success: function(data) {
                        $('#service').html(data.msg);
                    }, error: function() {
                        alert('Terjadi kesalahan, silakan refresh halaman ini.');
                    }
                });
            });
            $('#service').on('change', function() {
                var service = $('#service').val();
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('ajax/service_pulsa_detail/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                    dataType: "json",
                    success: function(data) {
                        if (data.msg.is_custom_price == 1) {
                            $('#txt_custom_price').removeClass('hide');
                        } else {
                            $('#txt_custom_price').addClass('hide');
                        }
                        $('#price').html(data.msg.price);
                        $('#description').html(data.msg.description);
                            
                    }, error: function() {
                        alert('Terjadi kesalahan, silakan refresh halaman ini.');
                    }
                });
            });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>