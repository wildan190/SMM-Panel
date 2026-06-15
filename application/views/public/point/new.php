<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-coins me-2"></i>Payout Point</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Point Anda</label>
                                <input type="text" class="form-control" value="<?= currency(user('benefit_point')) ?> Point" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Point <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount" id="amount">
                                    <button type="button" class="btn btn-primary" onclick="payout_all();">Semua</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Minimum Payout</label>
                                <input type="text" class="form-control" value="<?= currency(benefit('min_payout', user('benefit'))) ?> Point" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Rate 1 Point</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" value="<?= currency(benefit('rate_payout', user('benefit'))) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Saldo Diterima</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" id="total" value="0" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-random fs-6 me-2"></i>Payout</button>
                        <button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h4>
            </div>
            <div class="card-body pb-3">
                <?= nl2br(website_config('payout_info')) ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function get_amount() {
        var amount = $('#amount').val();
        if (Number.isInteger(amount) == false) {
            $('#amount').val(Math.round(amount));
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('ajax/get_rate/') ?>" + amount + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
            dataType: "json",
            success: function(data) {
                HoldOn.close();
                $('#total').val(data.msg);
            },
            error: function(error) {
                HoldOn.close();
                $('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                HoldOn.open({
                    theme: "sk-rect",
                    message: "Please wait...",
                    textColor: "white"
                });
            }
        });
    }

    function payout_all() {
        var currentPoints = '<?= user('benefit_point') ?>';
        $('#amount').val(currentPoints);
        get_amount();
    }
    $('#amount').keyup(function() {
        get_amount();
    });
</script>