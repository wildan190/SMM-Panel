<div class="row">
			<div class="col-md-5">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0"><i class="fas fa-tags me-2"></i>Ambil Layanan Provider</h4>
					</div>
					<div class="card-body">
						<form method="post" action="<?= base_url('admin/fetch_service/api') ?>">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
							<div class="form-group mb-2">
								<label class="form-label">Nama Provider *</label>
								<select class="form-control select2-data" name="api" id="api">
								<?php foreach ($api as $key => $value) { ?>
									<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="form-group mb-2">
								<label class="form-label">Mata Uang *</label>
								<select class="form-control select2-data" name="currency" id="currency">
									<option value="">Pilih salah satu ...</option>
									<option value="idr">IDR</option>
									<option value="dollar_us">DOLLAR AMERIKA</option>
								</select>
							</div>
							<div class="form-group mb-2 d-none" id="form-kurs">
								<label class="form-label">Kurs *</label>
								<input type="text" class="form-control" name="kurs" id="kurs">
							</div>
							<div class="form-group mb-2">
								<label class="form-label">Tipe Keuntungan *</label>
								<select class="form-control select2-data" name="profit_type" id="profit_type">
									<option value="">Pilih salah satu ...</option>
									<option value="biasa">BIASA</option>
									<option value="persen">PERSEN</option>
								</select>
							</div>
							<div class="form-group mb-2">
								<label class="form-label">Jumlah Keuntungan *</label>
								<input type="number" class="form-control" name="profit" id="profit">
								<p class="text-danger">Jika tipe keuntungan persen harap isi input tanpa operator % example : 12</p>
							</div><hr>
							<div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plane fs-6 me-2"></i>Ambil</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0"><i class="fas fa-file me-2"></i>Result Box</h4>
					</div>
					<div class="card-body">
						<div id="show-fetch-service"></div>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">
$(function() {
	$('#currency').on('change', function() {
		var currency = $('#currency').val();
		console.log(currency);
		if (currency == 'dollar_us') {
			$('#form-kurs').removeClass('d-none');
		} else {
			$('#form-kurs').addClass('d-none');
		}	
	});
	$("form").submit(function(){
        $.ajax({
            url:$(this).attr("action"),
            data:$(this).serialize(),
            type:$(this).attr("method"),
            dataType: 'html',
            beforeSend: function() {
                $("button").attr("disabled",true);
                $("#show-fetch-service").html('<div class="alert alert-primary">Tunggu ya...</div>');	
            },
            complete:function() {
                $("button").attr("disabled",false);								
            },
            success:function(result) {
                $("#show-fetch-service").html(result);	
            }, 
            error: function() {
                $("#show-fetch-service").html("gagal");	
            }
        })
        return false;
	});
});
$('form').submit(function(){
    $(this).children('button[type=submit]').prop('disabled', true);
});
</script>