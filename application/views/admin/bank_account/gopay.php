<div class="row">
	<div class="col-sm-6 mb-3">
		<div class="card shadow">
            <div class="card-header bg-primary-rgba py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"></i> <?= $page ?></h6>
            </div>
            <div class="card-body">
                <form method="post" class="form-horizontal" action="<?= base_url('admin/'.$this->uri->segment(2).'/gopay/1') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label>Nomor Gopay</label>
                        <div class="input-group mb-3">            
                            <input type="text" class="form-control" placeholder="Nomor gopay" name="nomor" value="<?= ($gopay->username) ? $gopay->username : '' ?>">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary" type="submit">Kirim OTP</button>
                            </div>
                        </div>                        
                    </div>
                </form>
                <form method="post" class="form-horizontal" action="<?= base_url('admin/'.$this->uri->segment(2).'/gopay/2') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label>Verifikasi SMS</label>
                        <div class="input-group mb-3">            
                            <input type="text" class="form-control" placeholder="Kode OTP" name="otp" value="<?= (isset($gopay->otp)) ? $gopay->otp : '' ?>">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary" type="submit">Verifikasi SMS</button>
                            </div>
                        </div>                        
                    </div>
                </form>
                <form method="post" class="form-horizontal">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="get-mutasi" onclick="getMutasi()" type="button">Cek Mutasi</button>
                    </div>
                </form>  
                <form method="post" class="form-horizontal" action="<?= base_url('admin/'.$this->uri->segment(2).'/gopay/4') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <button class="btn btn-danger btn-block" type="submit">Reset</button>                     
                    </div>
                </form>                                
		    </div>
        </div>
	</div>
    <div class="col-sm-6">
        <div class="card shadow">
            <div class="card-header bg-primary-rgba py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"></i> Result Mutasi</h6>
            </div>
            <div class="card-body">
                <div id="result">
                    
                </div>              
            </div>  
        </div>
    </div>    
</div>

<script type="text/javascript">
function getMutasi(){
    $.ajax({
            type: 'GET',
            url: '<?= base_url('admin/'.$this->uri->segment(2).'/gopay/3') ?>',
            dataType: 'html',
             beforeSend: function() {
                $("#get-mutasi").attr("disabled",true);
                $("#result").html('Tunggu sebentar...');    
            },
            complete:function() {
                $("button").attr("disabled",false);                             
            },
            success:function(result) {
                $("#result").html(result);  
            }, 
            error: function() {
                $("#result").html("gagal"); 
            }
        });
}

</script>