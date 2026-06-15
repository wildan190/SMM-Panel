<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="uil uil-shopping-cart-alt"></i> Pesanan Baru</h5>
			</div>
			<div class="card-body">
<form method="post" action="<?= base_url() ?>transaction/submit_order">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="form-row">
		<div class="form-group col-md-6">		
			<label>Kategori *</label>
			<span class="form-control" style="padding: 4px;">
				<select class="form-control select2" id="category">
					<option value="">Pilih...</option>
		<?php
		foreach ($service_category as $key => $value) {
		?>
		<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
		<?php
		}
		?>
				</select>
		</span>
		</div>
		<div class="form-group col-md-6">
			<label>Layanan *</label>
			<span class="form-control" style="padding: 4px;">
				<select class="form-control select2" name="service" id="service">
					<option value="">Pilih kategori dahulu...</option>
				</select>
			</span>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<label>Harga/K <span class="text-danger hide" id="txt_custom_price">(HARGA KHUSUS)</span></label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="input-group-text">Rp</span>
				</div>
				<span class="form-control" id="price">0</span>
			</div>
		</div>
		<div class="form-group col-md-4">
			<label>Min. Pesan</label>
			<span class="form-control" id="min">0</span>
		</div>
		<div class="form-group col-md-4">
			<label>Maks. Pesan</label>
			<span class="form-control" id="max">0</span>
		</div>
	</div>
	<div class="form-group" id="form_description">
		<label>Deskripsi</label>
		<textarea class="form-control" id="description" style="height: 100px" readonly>Deskripsi layanan.</textarea>
	</div>
	<div class="form-group">
		<label>Link Post / Username *</label>
		<input type="text" class="form-control" name="target" value="<?= set_value('target') ?>">
	</div>
	<div class="form-group hide" id="input_custom_comments">
		<label>Komentar *</label>
		<textarea class="form-control" name="custom_comments" rows="5" id="custom_comments"><?= set_value('custom_comments') ?></textarea>
	</div>
	<div class="form-group hide" id="input_custom_link">
		<label>Target (Custom Link) *</label>
		<input type="text" class="form-control" name="custom_link" value="<?= set_value('custom_link') ?>">
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label>Jumlah Pesan *</label>
			<input type="number" class="form-control" name="quantity" id="quantity">
		</div>
		<div class="form-group col-md-6">
			<label>Total Harga</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="input-group-text">Rp</span>
				</div>
				<span class="form-control" id="total-price">0</span>
			</div>
		</div>
		<div class="form-group col-md-12">
            <label class="control-label">Metode Pembayaran</label>
            <span class="form-control" style="padding: 4px;">
                <select class="form-control select2" name="payment_method" id="payment_method" required>
                    <option value="">-- Silahkan Pilih Pembayaran --</option>
                    <?php foreach ($payment_method as $key => $value) { ?>
                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?> - <?= $value['category'] ?></option>
                    <?php } ?>
                </select>
            </span>
            <span class="text-danger" id="description"></span>
        </div>
	</div>
	
	<div class="text-right">
		<button type="reset" class="btn btn-secondary">Reset</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
	</div>
</form>
		</div></div>
	</div>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="uil uil-bookmark"></i> Cara Pemesanan</h5>
			</div>
			<div class="card-body">
                 <p><?= nl2br(website_config('order_info')) ?></p>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript">
$(document).keypress(function(event) {
	if (event.which == '13' && !$(event.target).is('textarea')) {
		event.preventDefault();
	}
});
$(function() {
	$('#category').on('change', function() {
		reset();
		var category = $('#category').val();
		$.ajax({
			type: "GET",
			url: "<?= base_url('ajax/service_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
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
			url: "<?= base_url('ajax/service_detail/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
			dataType: "json",
			success: function(data) {
				if (data.msg.type == 'custom_comments') {
					$('#quantity').prop('readonly', true);
					$('#input_custom_comments').removeClass('hide');
				} else {
					$('#quantity').prop('readonly', false);
					$('#input_custom_comments').addClass('hide');
				}
				if (data.msg.type == 'custom_link') {
					$('#input_custom_link').removeClass('hide');
				} else {
					$('#input_custom_link').addClass('hide');
				}
				if (data.msg.is_custom_price == 1) {
					$('#txt_custom_price').removeClass('hide');
				} else {
					$('#txt_custom_price').addClass('hide');
				}
				if (data.msg.description == '-') {
					$('#form_description').addClass('hide');
				} else {
					$('#form_description').removeClass('hide');
				}
				$('#price').html(data.msg.price);
				$('#min').html(data.msg.min);
				$('#max').html(data.msg.max);
				$('#description').val(data.msg.description);
				//var newline = String.fromCharCode(13, 10);
				//var dess = data.msg.description;
				//dess.replace('\r\n', newline);
			//	input.replaceAll('\\n', newline);
				
			}, error: function() {
				alert('Terjadi kesalahan, silakan refresh halaman ini.');
			}
		});
	});
	$('#custom_comments').keyup(function() {
		var service = $('#service').val();
		var area = document.getElementById("custom_comments")
        	var text = area.value.replace(/\s+$/g,"")
  			var split = text.split("\n")
  			console.log(split)
				$('#quantity').val(split.length);
				var quantity = $('#quantity').val();
		total_price(service, quantity);
	});
	$('#quantity').on('keyup', function() {
		var service = $('#service').val();
		var quantity = $('#quantity').val();
		total_price(service, quantity);
	});
	function reset() {
		$('#price').html('0');
		$('#min').html('0');
		$('#max').html('0');
		$('#quantity').val('');
		$('#total-price').html('0');
		$('#description').html('Deskripsi layanan.');
		$('#form_description').removeClass('hide');
		$('#input_custom_comments').addClass('hide');
		$('#input_custom_link').addClass('hide');
		$('#txt_custom_price').addClass('hide');
	}
	function total_price(service, quantity) {
		$.ajax({
			type: "GET",
			url: "<?= base_url('ajax/service_price/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&quantity=" + quantity,
			dataType: "json",
			success: function(data) {
				$('#total-price').html(data.msg);
			}, error: function() {
				$('#total-price').html('0');
			}
		});
	}

});

$('form').submit(function(){
    $(this).children('button[type=submit]').prop('disabled', true);
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>