<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-primary">
                                    <h5 class="text-center mb-0"><b>Benefit Silver</b></h5>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Transaksi User</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" value="<?= benefit('trx', 'Silver') ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Minimum Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="min_payout_silver" value="<?= benefit('min_payout', 'Silver') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Rate Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="rate_payout_silver" value="<?= benefit('rate_payout', 'Silver') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-primary">
                                    <h5 class="text-center mb-0"><b>Benefit Gold</b></h5>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Transaksi User</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="trx_gold" value="<?= benefit('trx', 'Gold') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Minimum Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="min_payout_gold" value="<?= benefit('min_payout', 'Gold') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Rate Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="rate_payout_gold" value="<?= benefit('rate_payout', 'Gold') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-primary">
                                    <h5 class="text-center mb-0"><b>Benefit Platinum</b></h5>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Transaksi User</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="trx_platinum" value="<?= benefit('trx', 'Platinum') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Minimum Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="min_payout_platinum" value="<?= benefit('min_payout', 'Platinum') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Rate Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="rate_payout_platinum" value="<?= benefit('rate_payout', 'Platinum') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-primary">
                                    <h5 class="text-center mb-0"><b>Benefit Diamond</b></h5>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Transaksi User</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="trx_diamond" value="<?= benefit('trx', 'Diamond') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Minimum Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="min_payout_diamond" value="<?= benefit('min_payout', 'Diamond') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Rate Payout</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="rate_payout_diamond" value="<?= benefit('rate_payout', 'Diamond') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Total Transaksi = 1 Point</label>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="number" class="form-control" name="benefit_trx" value="<?= website_config('benefit_trx') ?>">
                        </div>
                    </div>
                    <hr class="d-block d-md-none">
                    <div class="mb-0 float-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-cogs me-2"></i>Referral</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/web_settings/referral') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="form-label">Rate Komisi Silver <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="referral_rate_silver" placeholder="0.02" value="<?= (website_config('referral_rate_silver') <> '') ? website_config('referral_rate_silver') : null ?>">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label">Rate Komisi Gold <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="referral_rate_gold" placeholder="0.04" value="<?= (website_config('referral_rate_gold') <> '') ? website_config('referral_rate_gold') : null ?>">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label">Rate Komisi Platinum <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="referral_rate_platinum" placeholder="0.06" value="<?= (website_config('referral_rate_platinum') <> '') ? website_config('referral_rate_platinum') : null ?>">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label">Rate Komisi Diamond <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="referral_rate_diamond" placeholder="0.08" value="<?= (website_config('referral_rate_diamond') <> '') ? website_config('referral_rate_diamond') : null ?>">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Minimum Convert Komisi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="text" class="form-control" name="referral_minimun_convert" placeholder="1000" value="<?= (website_config('referral_minimun_convert') <> '') ? website_config('referral_minimun_convert') : null ?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-0 float-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>