<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
            </div>
            <div class="card-body pb-3">
                <form method="post" role="form" enctype="multipart/form-data" id="main-form">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-tripay-tab" data-bs-toggle="pill" href="#pills-tripay" role="tab" aria-controls="pills-tripay" aria-selected="false">TRIPAY</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-paydisini-tab" data-bs-toggle="pill" href="#pills-paydisini" role="tab" aria-controls="pills-paydisini" aria-selected="false">PAYDISINI</a>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-tripay" role="tabpanel" aria-labelledby="pills-tripay-tab">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label">Merchant Code</label>
                                    <input type="text" class="form-control" name="tripay_merchant_code" placeholder="MERCHANT_CODE" value="<?= (website_config('tripay_merchant_code') <> '') ? website_config('tripay_merchant_code') : null ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">API Key</label>
                                    <input type="text" class="form-control" name="tripay_api_key" placeholder="API_KEY" value="<?= (website_config('tripay_api_key') <> '') ? website_config('tripay_api_key') : null ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">Private Key</label>
                                    <input type="text" class="form-control" name="tripay_private_key" placeholder="PRIVATE_KEY" value="<?= (website_config('tripay_private_key') <> '') ? website_config('tripay_private_key') : null ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-paydisini" role="tabpanel" aria-labelledby="pills-paydisini-tab">
                            <div class="form-group">
                                <label class="form-label">API Key</label>
                                <input type="text" class="form-control" name="paydisini_api_key" placeholder="API_KEY" value="<?= (website_config('paydisini_api_key') <> '') ? website_config('paydisini_api_key') : null ?>">
                        </div>
                    </div>

                    <div class="mb-0 float-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>