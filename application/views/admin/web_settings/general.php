<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-4">
                        <input type="hidden" name="mode_theme" id="theme_mode" value="<?= website_config('mode_theme') ?>">
                        <input type="hidden" name="contrast_theme" id="theme_contrast" value="<?= website_config('contrast_theme') ?>">
                        <input type="hidden" name="color_theme" id="theme_preset" value="<?= website_config('color_theme') ?>">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 pt-0">
                                <div class="pc-dark">
                                    <h6 class="mb-1">Mode Tema</h6>
                                    <p class="text-muted text-sm">Pilih mode terang, gelap atau otomatis</p>
                                    <div class="row theme-layout">
                                        <div class="col-4">
                                            <div class="d-grid">
                                                <button type="button" class="preset-btn btn <?= (website_config('mode_theme') == 'light') ? 'active' : '' ?>" data-value="true" onclick="layout_change('light'); layout_change2('light');">
                                                    <svg class="pc-icon text-warning">
                                                        <use xlink:href="#custom-sun-1"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="d-grid">
                                                <button type="button" class="preset-btn btn <?= (website_config('mode_theme') == 'dark') ? 'active' : '' ?>" data-value="false" onclick="layout_change('dark'); layout_change2('dark');">
                                                    <svg class="pc-icon">
                                                        <use xlink:href="#custom-moon"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="d-grid">
                                                <button type="button" class="preset-btn btn <?= (website_config('mode_theme') == 'default') ? 'active' : '' ?>" data-value="default" onclick="layout_change_default(); layout_change2('default');">
                                                    <svg class="pc-icon">
                                                        <use xlink:href="#custom-setting-2"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <h6 class="mb-1">Kontras Tema</h6>
                                <p class="text-muted text-sm">Pilih kontras tema</p>
                                <div class="row theme-contrast">
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button type="button" class="preset-btn btn <?= (website_config('contrast_theme') == 'true') ? 'active' : '' ?>" data-value="true" onclick="layout_theme_contrast_change('true'); layout_sidebar_change2('true');">
                                                <svg class="pc-icon">
                                                    <use xlink:href="#custom-mask"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button type="button" class="preset-btn btn <?= (website_config('contrast_theme') == 'false') ? 'active' : '' ?>" data-value="false" onclick="layout_theme_contrast_change('false'); layout_sidebar_change2('false');">
                                                <svg class="pc-icon">
                                                    <use xlink:href="#custom-mask-1-outline"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <h6 class="mb-1">Kustom Tema</h6>
                                <p class="text-muted text-sm">Pilih Tema Utama Website</p>
                                <div class="theme-color preset-color">
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-1') ? 'active' : '' ?>" data-value="preset-1" onclick="layout_preset2('preset-1');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-2') ? 'active' : '' ?>" data-value="preset-2" onclick="layout_preset2('preset-2');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-3') ? 'active' : '' ?>" data-value="preset-3" onclick="layout_preset2('preset-3');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-4') ? 'active' : '' ?>" data-value="preset-4" onclick="layout_preset2('preset-4');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-5') ? 'active' : '' ?>" data-value="preset-5" onclick="layout_preset2('preset-5');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-6') ? 'active' : '' ?>" data-value="preset-6" onclick="layout_preset2('preset-6');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-7') ? 'active' : '' ?>" data-value="preset-7" onclick="layout_preset2('preset-7');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-8') ? 'active' : '' ?>" data-value="preset-8" onclick="layout_preset2('preset-8');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-9') ? 'active' : '' ?>" data-value="preset-9" onclick="layout_preset2('preset-9');"><i class="ti ti-check"></i></a>
                                    <a href="#!" class="<?= (website_config('color_theme') == 'preset-10') ? 'active' : '' ?>" data-value="preset-10" onclick="layout_preset2('preset-10');"><i class="ti ti-check"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Full Title</label>
                                <input type="text" class="form-control" name="title" value="<?= website_config('title') ?>" autocomplete="off">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Short Title</label>
                                <input type="text" class="form-control" name="short_title" value="<?= website_config('short_title') ?>" autocomplete="off">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-label">Favicon (.jpg, .jpeg, .png, .ico)</label>
                                <input class="form-control" type="file" name="favicon" accept="image/jpg,image/jpeg,image/png,image/ico">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-label">Open Graph Image (.jpg, .jpeg, .png)</label>
                                <input class="form-control" type="file" name="logo" accept="image/jpg,image/jpeg,image/png">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Meta Author</label>
                                <input type="text" class="form-control" name="meta_author" value="<?= website_config('meta_author') ?>" autocomplete="off">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Bar Title</label>
                                <input type="text" class="form-control" name="bartitle" value="<?= website_config('bartitle') ?>" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="5"><?= website_config('meta_description') ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Meta Keywords</label>
                                <textarea class="form-control" name="meta_keywords" rows="5"><?= website_config('meta_keywords') ?></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-label">Custom Tag</label>
                                <textarea class="form-control" name="custom_tag" rows="3" placeholder="<meta..."><?= website_config('custom_tag') ?></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">GTM - Head</label>
                                <textarea class="form-control" name="gtm_head" rows="3" placeholder="<!-- Google Tag Manager -->"><?= website_config('gtm_head') ?></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">GTM - Body</label>
                                <textarea class="form-control" name="gtm_body" rows="3" placeholder="<!-- Google Tag Manager (noscript) -->"><?= website_config('gtm_body') ?></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-label">Footer</label>
                                <textarea class="form-control" name="footer" rows="3"><?= website_config('footer') ?></textarea>
                                <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                                <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label">Top 10 Pesanan</label>
                                <select class="select2-data form-control" name="top_order">
                                    <option value="1" <?= (website_config('top_order') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('top_order') == 1) ? '(Dipilih)' : '' ?></option>
                                    <option value="0" <?= (website_config('top_order') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('top_order') == 0) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Top 10 Deposit</label>
                                <select class="select2-data form-control" name="top_deposit">
                                    <option value="1" <?= (website_config('top_deposit') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('top_deposit') == 1) ? '(Dipilih)' : '' ?></option>
                                    <option value="0" <?= (website_config('top_deposit') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('top_deposit') == 0) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Top 10 Layanan</label>
                                <select class="select2-data form-control" name="top_service">
                                    <option value="1" <?= (website_config('top_service') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('top_service') == 1) ? '(Dipilih)' : '' ?></option>
                                    <option value="0" <?= (website_config('top_service') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('top_service') == 0) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Sistem Referral</label>
                                <select class="select2-data form-control" name="referral_status">
                                    <option value="0" <?= (website_config('referral_status') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('referral_status') == 0) ? '(Dipilih)' : '' ?></option>
                                    <option value="1" <?= (website_config('referral_status') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('referral_status') == 1) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Rating Layanan</label>
                                <select class="select2-data form-control" name="rating_status">
                                    <option value="0" <?= (website_config('rating_status') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('rating_status') == 0) ? '(Dipilih)' : '' ?></option>
                                    <option value="1" <?= (website_config('rating_status') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('rating_status') == 1) ? '(Dipilih)' : '' ?></option>
                                </select>

                                </select>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Register</label>
                                <select class="select2-data form-control" name="page_register">
                                    <option value="0" <?= (website_config('page_register') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('page_register') == 0) ? '(Dipilih)' : '' ?></option>
                                    <option value="1" <?= (website_config('page_register') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('page_register') == 1) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Forgot Password</label>
                                <select class="select2-data form-control" name="page_forgot">
                                    <option value="0" <?= (website_config('page_forgot') == 0) ? 'selected' : '' ?>>Nonaktif <?= (website_config('page_forgot') == 0) ? '(Dipilih)' : '' ?></option>
                                    <option value="1" <?= (website_config('page_forgot') == 1) ? 'selected' : '' ?>>Aktif <?= (website_config('page_forgot') == 1) ? '(Dipilih)' : '' ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i>Informasi</h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST" action="<?= base_url('admin/web_settings/info') ?>" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="limit_order" class="form-label">
                            Limit Pesanan Jika Pending </label>
                        <input type="text" name="limit_order" value="<?= website_config('limit_order') ?>" class="form-control" id="limit_order" placeholder="Limit Pesanan Jika Pending">
                    </div>
                    <div class="col-sm-6">
                        <label for="terms_link" class="form-label">
                            Link Ketentuan Layanan </label>
                        <input type="text" name="terms_link" value="<?= website_config('terms_link') ?>" class="form-control" id="terms_link" placeholder="Link Terms">
                    </div>
                    <div class="col-sm-6">
                        <label for="order_info" class="form-label">
                            Info Cara Pemesanan </label>
                        <textarea class="form-control classic-editor" name="order_info" rows="5" id="order_info" placeholder="Info Cara Pemesanan"><?= website_config('order_info') ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label for="deposit_info" class="form-label">
                            Info Cara Deposit </label>
                        <textarea class="form-control classic-editor" name="deposit_info" rows="5" id="deposit_info" placeholder="Info Cara Deposit"><?= website_config('deposit_info') ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label for="payout_info" class="form-label">
                            Info Cara Payout Point </label>
                        <textarea class="form-control classic-editor" name="payout_info" rows="5" id="payout_info" placeholder="Info Cara Payout Point"><?= website_config('payout_info') ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label for="convert_info" class="form-label">
                            Info Cara Convert Komisi </label>
                        <textarea class="form-control classic-editor" name="convert_info" rows="5" id="convert_info" placeholder="Info Cara Convert Komisi"><?= website_config('convert_info') ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function layout_change2(value) {
        $('#theme_mode').val(value);
        console.log('Client - layout_change2:', value);
    }

    function layout_sidebar_change2(value) {
        $('#theme_contrast').val(value);
        console.log('Client - layout_sidebar_change2:', value);
    }

    function layout_preset2(value) {
        $('#theme_preset').val(value);
        console.log('Client - layout_preset2:', value);
    }
</script>