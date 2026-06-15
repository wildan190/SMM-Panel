<div class="row">
    <div class="col-sm-12 mb-3">
        <div class="card shadow">
            <div class="card-header bg-primary-rgba py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"></i> <?= $page ?></h6>
            </div>
            <div class="card-body">
                <form method="post" class="form-horizontal mt-3" id="main-form" action="<?= base_url('admin/'.$this->uri->segment(2).'/borneo_gateway') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-12 mb-1 mt-1">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h4 class="text-center"> Borneo Gateway </h4>
                                    <hr>
                                    <div class="form-group">
                                      <label for="">Borneo Gateway Token Kunci Berlangganan</label>
                                      <input type="text" name="borneo_gateway_token" class="form-control" value="<?= website_config('borneo_gateway_token') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($borneo_gateway['bank_account'] as $key => $value) { ?>
                        <div class="col-md-6 mb-1 mt-1">
                                <div class="card shadow">
                                <div class="card-body">
                                    <div class="form-group">
                                      <label for="">Token Akses <?= strtoupper($value['name']) ?> </label>
                                      <input type="text" name="borneo_gateway_<?= $value['name'] ?>" class="form-control" value="<?= $value['access_token'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <button class="btn btn-primary mt-3">
                        <i class="fa fa-check"></i>
                        Submit
                    </button>
                </form>            
                <form method="post" class="form-horizontal mt-3" id="cekmutasi-form" action="<?= base_url('admin/'.$this->uri->segment(2).'/cek_mutasi') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-12 mb-1 mt-1">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h4 class="text-center"> Cek Mutasi </h4>
                                    <hr>
                                    <div class="form-group">
                                      <label for="">API Signature </label>
                                      <input type="text" name="cekmutasi_token" class="form-control" value="<?= website_config('cekmutasi_token') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($cekmutasi['bank_account'] as $key => $value) { ?>
                        <div class="col-md-6 mb-1 mt-1">
                                <div class="card shadow">
                                <div class="card-body">
                                    <div class="form-group">
                                      <label for="">Token Akses <?= strtoupper($value['name']) ?> </label>
                                      <input type="text" name="cekmutasi_<?= $value['name'] ?>" class="form-control" value="<?= $value['username'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <button class="btn btn-primary mt-3">
                        <i class="fa fa-check"></i>
                        Submit
                    </button>
                </form>                       
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    // $(".dropify").dropify({
    //     messages: {
    //         default: "Seret atau jatuhkan file disini atau klik",
    //         replace: "Seret atau jatuhkan atau klik untuk menggantikan",
    //         remove: 'Hapus',
    //         error: "Ooops, terjadi kesalahan."
    //     },
    //     error: {
    //         fileSize: "Ukuran File terlalu besar (Maksimal 10MB)."
    //     }
    // });
    $("#cekmutasi-form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                reset_button(0);
                $(document).find('input').removeClass('is-invalid');
                $(document).find('select').removeClass('is-invalid');
                $(document).find('textarea').removeClass('is-invalid');
                $(document).find('b.text-danger').text('');
                
            },
            success: function(data) {
                reset_button(1);
                if (data.result == false) {
                    if (data.type == 'form-validation') {
                        $.each(data.msg, function(key, val) {
                            $("input[name=" + key + "]").addClass('is-invalid').focus();
                            $("select[name=" + key + "]").addClass('is-invalid').focus();
                            $("textarea[name=" + key + "]").addClass('is-invalid').focus();
                            $('b.' + key +'-invalid').html(val)
                        });
                    }
                    if (data.type == 'alert') {
                        swal.fire("Gagal!", data.msg, "error");
                    }
                } else {
                    reset_button(1);
                    $("#modal-form").modal('hide');
                    if (!data.redirect_url) {
                        swal.fire("Berhasil!", data.msg, "success")
                    } else {
                        swal.fire("Berhasil!", data.msg, "success").then(function() {
                            window.location = data.redirect_url;
                        });
                    }
                }
            },
            error:function() {
                reset_button(1);
                $(document).find('b.text-danger').text('');
                $(document).find('input').removeClass('is-invalid');
                $(document).find('select').removeClass('is-invalid');
                $(document).find('textarea').removeClass('is-invalid');
                swal.fire("Gagal!", "Terjadi kesalahan.", "error");
            },
        });
    });
});
</script>