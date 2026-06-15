<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-circle-dollar-to-slot me-2"></i>Convert Komisi</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Saldo Komisi Anda</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" value="<?= currency(user('referral_saldo')) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Saldo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount" id="amount">
                                    <button type="button" class="btn btn-primary" onclick="convert_all();">Semua</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Minimum Convert</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" value="<?= website_config('referral_minimun_convert') ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-random fs-6 me-2"></i>Convert</button>
                        <button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-info-circle me-1"></i>Informasi</h4>
            </div>
            <div class="card-body pb-3">
                <?= nl2br(website_config('convert_info')) ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function get_amount() {
        HoldOn.open({
            theme: "sk-rect",
            message: "Please wait...",
            textColor: "white"
        });
        var amount = $('#amount').val();
        amount = parseInt(amount); // Konversi ke bilangan bulat
        $('#amount').val(amount);
        $('#total').val(amount);
        HoldOn.close();
    }

    function convert_all() {
        var currentBalance = '<?= user('referral_saldo') ?>';
        $('#amount').val(currentBalance);
        get_amount();
    }

    $('#amount').keyup(function() {
        get_amount();
    });
</script>