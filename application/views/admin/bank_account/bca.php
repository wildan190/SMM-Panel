<div class="row">
	<div class="col-sm-6 mb-3">
		<div class="card shadow">
            <div class="card-header bg-primary-rgba py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"></i> <?= $page ?></h6>
            </div>
            <div class="card-body">
                <form method="post" class="form-horizontal" action="<?= base_url('admin/'.$this->uri->segment(2).'/bca/1') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group mb-3">            
                            <input type="text" class="form-control" placeholder="Nomor bca" name="username" value="<?= ($bca->username) ? $bca->username : '' ?>">
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label>Pin</label>
                        <div class="input-group mb-3">            
                            <input type="password" class="form-control" placeholder="Pin" name="pin" value="<?= ($bca->pin) ? $bca->pin : '' ?>">
                        </div>                        
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" type="submit"><?=  ($bca->username) ? 'Update' : 'Login' ; ?></button>                     
                    </div>
                </form>
                <hr>
                <form method="post" class="form-horizontal">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="get-mutasi" onclick="getMutasi()" type="button">Cek Mutasi</button>
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
                <pre id="result">
                    
                </pre>              
            </div>  
        </div>
    </div>    
</div>

<script type="text/javascript">
function getMutasi(){
    $.ajax({
            type: 'GET',
            url: '<?= base_url('admin/'.$this->uri->segment(2).'/bca/2') ?>',
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