<?php
$service_category = (isset($service_category)) ? $service_category : [];
$category_favorit = (isset($category_favorit)) ? $category_favorit : [];
$purchases = (isset($purchases)) ? $purchases : [];
$prev_input = $this->session->flashdata('prev_input');
if (!$prev_input) {
    $prev_input = [
        'category_id' => $this->session->userdata('last_category_id'),
        'service' => $this->session->userdata('last_service_id')
    ];
}
?>
<div class="row">
    <div class="col-md-12">
            <div class="alert alert-primary shadow"><i class="fa fa-info-circle fa-fw"></i> <b class="text-uppercase">Infomasi Penting!</b><br><hr>
                Halo <b><?= user('full_name') ?></b>, sebelum membuat pesanan disarankan untuk membaca <b>Informasi</b> terlebih dahulu, jika Anda masuk menggunakan PC maka <b>Informasi</b> terletak disebelah kanan form pesanan, jika Anda masuk menggunakan <i>smartphone / mobile phone</i> maka <b>Informasi</b> terletak dibagian bawah form pesanan.<hr></div>
        </div>
        <div class="col-md-12">
            <span class="badge bg-light-primary mb-2"><b> Live Orders : <?= date('d-m-y') ?></b></span>

            <div class="mb-3 d-flex form-control pt-1 pb-1 ps-3" style="background: rgba(var(--bs-primary-rgb), 0.08); border-radius:0.8rem; border-color: var(--bs-primary) !important">
                <div class="icons">
                    <i class="ph-duotone ph-shopping-cart-simple fs-3 me-2"></i>
                </div>
                <marquee style="position: relative;top: 1px;">
                    <?php if (!empty($purchases)): ?>
                        <?php foreach ($purchases as $purchase): ?>
                            <b> <?= htmlspecialchars($purchase['user_checkout']) ?> </b> - Telah melakukan pembelian dengan jumlah [ <b><?= htmlspecialchars($purchase['qty']) ?></b> ] <?= htmlspecialchars($purchase['product']) ?> - seharga : <b>Rp. <?= htmlspecialchars($purchase['price']) ?></b> &nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-primary">Tidak ada pembelian hari ini</div>
                    <?php endif; ?>
                </marquee>
            </div>
            
    <div class="row">
    <div class="col-md-12">
        <a class="btn mb-3 btn-primary" data-bs-toggle="collapse" href="#filterCategory">
            <i class="fas fa-filter fs-6 me-2"></i>Filter Kategori
        </a>
    </div>
    <div class="collapse multi-collapse collapse show" id="filterCategory">
        <div class="col-md-12">
            <div class="row gx-1 mb-4">
                <div class="col-6 col-lg-4 col-xl-3 d-grid">
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnAll active" id="resetFC1" onclick="filterCategory('btnAll', '0');"><span class="d-flex align-items-center"><i class="fas fa-adjust fs-4 me-2" style="margin-top: 1px;"></i>Semua</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnInstagram" id="resetFC2" onclick="filterCategory('btnInstagram', 'Instagram');"><span class="d-flex align-items-center"><i class="fab fa-instagram fs-4 me-2" style="margin-top: 1px;"></i>Instagram</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnFacebook" id="resetFC3" onclick="filterCategory('btnFacebook', 'Facebook');"><span class="d-flex align-items-center"><i class="fab fa-facebook fs-4 me-2" style="margin-top: 1px;"></i>Facebook</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnYoutube" id="resetFC4" onclick="filterCategory('btnYoutube', 'Youtube');"><span class="d-flex align-items-center"><i class="fab fa-youtube fs-4 me-2" style="margin-top: 1px;"></i>Youtube</span></span></button>
                </div>
                <div class="col-6 col-lg-4 col-xl-3 d-grid">
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnTwitter" id="resetFC5" onclick="filterCategory('btnTwitter', 'Twitter');"><span class="d-flex align-items-center"><i class="fab fa-twitter fs-4 me-2" style="margin-top: 1px;"></i>Twitter</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnSpotify" id="resetFC6" onclick="filterCategory('btnSpotify', 'Spotify');"><span class="d-flex align-items-center"><i class="fab fa-spotify fs-4 me-2" style="margin-top: 1px;"></i>Spotify</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnTiktok" id="resetFC7" onclick="filterCategory('btnTiktok', 'Tiktok', 'Tik tok');"><span class="d-flex align-items-center"><i class="fab fa-tiktok fs-4 me-2" style="margin-top: 1px;"></i>Tiktok</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnGoogle" id="resetFC8" onclick="filterCategory('btnGoogle', 'Google');"><span class="d-flex align-items-center"><i class="fab fa-google fs-4 me-2"></i>Google</span></span></button>
                </div>
                <div class="col-6 col-lg-4 col-xl-3 d-grid">
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnThreads" id="resetFC9" onclick="filterCategory('btnThreads', 'Threads');"><span class="d-flex align-items-center"><i class="fa-brands fa-at fs-4 me-2"></i>Threads</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnTelegram" id="resetFC10" onclick="filterCategory('btnTelegram', 'Telegram');"><span class="d-flex align-items-center"><i class="fab fa-telegram fs-4 me-2" style="margin-top: 1px;"></i>Telegram</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnDiscord" id="resetFC11" onclick="filterCategory('btnDiscord', 'Discord');"><span class="d-flex align-items-center"><i class="fab fa-discord fs-4 me-2" style="margin-top: 1px;"></i>Discord</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnSoundCloud" id="resetFC12" onclick="filterCategory('btnSoundCloud', 'SoundCloud');"><span class="d-flex align-items-center"><i class="fa-brands fa-soundcloud fs-4 me-2"></i>SoundCloud</span></span></button>
                </div>
                <div class="col-6 col-lg-4 col-xl-3 d-grid">
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnTwitch" id="resetFC13" onclick="filterCategory('btnTwitch', 'Twitch');"><span class="d-flex align-items-center"><i class="fab fa-twitch fs-4 me-2" style="margin-top: 1px;"></i>Twitch</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnWebsite" id="resetFC14" onclick="filterCategory('btnWebsite', 'Website');"><span class="d-flex align-items-center"><i class="fas fa-globe fs-4 me-2" style="margin-top: 1px;"></i>Web Traffic</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnPromo" id="resetFC15" onclick="filterCategory('btnPromo', 'Promo');"><span class="d-flex align-items-center"><i class="fa-solid fa-heart fs-4 me-2" style="margin-top: 1px;"></i>Promo</span></span></button>
                    <button type="button" class="p-2 btn btn-primary btn-sm d-block text-nowrap mb-1 btn-brand btnOther" id="resetFC16" onclick="filterCategory('btnOther', 'Other');"><span class="d-flex align-items-center"><i class="fa-solid fa-shuffle fs-4 me-2"></i>Other</span></span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i>Pesanan Massal</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <ul class="nav nav-pills" role="tablist" style="margin-bottom:13px;">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link btn-custom-gradient active" data-bs-toggle="tab" href="#general" id="btn-general" role="tab" style="padding:0.785rem 1rem !important;">
                                <i class="fas fa-adjust align-middle fs-6 me-2" style="margin-top: -2px;"></i><span class="d-md-inline-block">Umum</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link btn-custom-gradient" data-bs-toggle="tab" href="#favorite" id="btn-favorite" role="tab" style="padding:0.785rem 1rem !important;">
                                <i class="far fa-star align-middle fs-6 me-2" style="margin-top: -2px;"></i><span class="d-md-inline-block">Favorit</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link btn-custom-gradient" data-bs-toggle="tab" href="#search" id="btn-search" role="tab" style="padding:0.785rem 1rem !important;">
                                <i class="fas fa-search align-middle fs-6 me-2" style="margin-top: -2px;"></i><span class="d-md-inline-block">Cari ID</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="category">
                                    <option value="0">Pilih...</option>
                                    <?php
                                    foreach ($service_category as $key => $value) {
                                    ?>
                                        <option value="<?= $value['id'] ?>" <?= (isset($prev_input['category_id']) && $prev_input['category_id'] == $value['id']) ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="favorite" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="category_fav">
                                    <option value="0">Pilih...</option>
                                    <<?php
                                        foreach ($category_favorit as $key => $value) {
                                        ?> <option value="<?= $value['category_id'] ?>"><?= $value['category_name'] ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="search" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">ID Layanan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="service-id">
                                    <a href="javascript:;" class="btn btn-primary" id="btnSearch" style="padding-top: 0.8rem;">Cari</a>
                                </div>
                            </div>
                            <div class="form-group d-none" id="form-category">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="category-search">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="form-service">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Layanan <span class="text-danger">*</span> <span id="fav_service" style="cursor:pointer;"></span></label>
                            <span class="fw-bolder text-secondary small mt-1" id="is_refill"><i class="fas fa-question-circle"></i> Refill Button</span>
                        </div>
                        <select class="select2 form-control" name="service" id="service">
                            <option value="0">Pilih Kategori</option>
                        </select>
                        <div id="service-search"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <span class="form-control text-break" style="height: auto;" id="description" disabled>-</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rating</label>
                        <span class="form-control text-break" style="height: auto;" id="rating" disabled>-</span>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="form-label">Minimal Pesanan</label>
                            <input type="text" class="form-control" value="0" id="min-amount" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">Maksimal Pesanan</label>
                            <input type="text" class="form-control" value="0" id="max-amount" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" id="label-price">Harga / 1000</label>
                                <span class="fw-bolder text-success small mt-1 d-none" id="txt_custom_price"><i class="fas fa-check-circle"></i> HARGA KHUSUS</span>
                            </div>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="text" class="form-control" value="0" id="price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target|Jumlah <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="data_order" id="target" rows="4" placeholder="Target1|Jumlah1&#10;Target2|Jumlah2"></textarea><span class="text-danger">*Maksimal 10 baris/perintah.</span>
                    </div>
                    <div class="form-group d-none" id="formSEO">
                        <label class="form-label">Keywords <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputSEO" rows="4" placeholder="*Keywords list separated by Enter."></textarea><span class="text-danger" id="inputSEOAlert"></span>
                    </div>
                    <div class="form-group d-none" id="formMentions">
                        <label class="form-label">Usernames <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputMentions" rows="4" placeholder="*Usernames list separated by Enter."></textarea><span class="text-danger" id="inputMentionsAlert"></span>
                    </div>
                    <div class="d-none" id="formMentionsWithHashtags">
                        <div class="form-group">
                            <label class="form-label">Usernames <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="inputMentionsWithHashtags1" rows="4" placeholder="*Usernames list separated by Enter."></textarea><span class="text-danger" id="inputMentionsWithHashtags1Alert"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hashtags <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="inputMentionsWithHashtags2" rows="4" placeholder="*Hashtags list separated by Enter."></textarea><span class="text-danger" id="inputMentionsWithHashtags2Alert"></span>
                        </div>
                    </div>
                    <div class="form-group d-none" id="formMentionsHashtag">
                        <label class="form-label">Hashtag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsHashtag">
                    </div>
                    <div class="form-group d-none" id="formMentionsUserFollowers">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsUserFollowers">
                    </div>
                    <div class="form-group d-none" id="formMentionsMediaLikers">
                        <label class="form-label">Media <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsMediaLikers"><span class="text-danger">*Media URL you want to send.</span>
                    </div>
                    <div class="form-group d-none" id="formCommentLikes">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputCommentLikes"><span class="text-danger">*Username of the comment owner.</span>
                    </div>
                    <div class="form-group d-none" id="formPoll">
                        <label class="form-label">Answer Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputPoll"><span class="text-danger">*Answer number of the poll.</span>
                    </div>
                    <div class="form-group d-none" id="formInvitesFromGroups">
                        <label class="form-label">Groups <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputInvitesFromGroups" rows="4" placeholder=""></textarea><span class="text-danger" id="inputInvitesFromGroupsAlert"></span>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Waktu Rata-Rata <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="<em>Waktu rata-rata</em> didasarkan pada 10 pesanan terakhir dengan status pesanan <em>Success</em>."><i class="fas fa-exclamation-circle"></i></a></label>
                            <input type="text" class="form-control" id="average_time" value="-" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Total Harga</label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="text" class="form-control" value="0" id="total-price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-cart-plus fs-6 me-2"></i>Pesan</button>
                        <button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
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
                <p><?= nl2br(website_config('order_info')) ?></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('.select2').select2({
        width: "50%",
        templateSelection: formatText,
        templateResult: formatText,
        allowHtml: true
    });

    $(document).ready(function() {
        // Logika restore dari sessionStorage (agar antar tab tidak saling timpa)
        var savedCategory = sessionStorage.getItem('last_category');
        var savedService = sessionStorage.getItem('last_service');

        if (savedCategory && savedCategory !== '0') {
            setTimeout(function() {
                $('#category').val(savedCategory).trigger('change');
            }, 500);
            
            // Tunggu AJAX service_list selesai sebelum restore service
            $(document).ajaxComplete(function(event, xhr, settings) {
                if (settings.url.indexOf('ajax/service_list/') !== -1) {
                    if (savedService && savedService !== '0') {
                        setTimeout(function() {
                            $('#service').val(savedService).trigger('change');
                        }, 500);
                    }
                }
            });
        }

        $('#btn-general').on('click', function() {
            reset();
            $('#form-category').addClass('d-none');
            $('#form-service').removeClass('d-none');
            $('#service-id').val('');
            $('#category').val('0').trigger('change.select2');
            $('#category_fav').val('0').trigger('change.select2');
            $('#service').html('<option value="0">Pilih Kategori</option>');
            sessionStorage.removeItem('last_category');
            sessionStorage.removeItem('last_service');
        });
        $('#btn-favorite').on('click', function() {
            reset();
            $('#form-category').addClass('d-none');
            $('#form-service').removeClass('d-none');
            $('#service-id').val('');
            $('#category').val('0').trigger('change.select2');
            $('#category_fav').val('0').trigger('change.select2');
            $('#service').html('<option value="0">Pilih Kategori</option>');
            sessionStorage.removeItem('last_category');
            sessionStorage.removeItem('last_service');
        });
        $('#btn-search').on('click', function() {
            reset();
            $('#form-service').addClass('d-none');
            sessionStorage.removeItem('last_category');
            sessionStorage.removeItem('last_service');
        });
        $('#category').change(function() {
            var category = $('#category').val();
            sessionStorage.setItem('last_category', category); // Simpan kategori ke sessionStorage
            $.ajax({
                type: "GET",
                url: "<?= base_url('ajax/service_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                dataType: "json",
                success: function(data) {
                    HoldOn.close();
                    $('#service').html(data.msg);
                    reset();
                },
                error: function() {
                    HoldOn.close();
                    $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
                },
                beforeSend: function() {
                    HoldOn.open({
                        theme: "sk-rect",
                        message: "Please wait...",
                        textColor: "white"
                    });
                }
            });
        });
        $('#category_fav').change(function() {
            var category = $('#category_fav').val();
            $.ajax({
                type: "GET",
                url: "<?= base_url('ajax/service_favorit_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                dataType: "json",
                success: function(data) {
                    HoldOn.close();
                    $('#service').html(data.msg);
                    reset();
                },
                error: function() {
                    HoldOn.close();
                    $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
                },
                beforeSend: function() {
                    HoldOn.open({
                        theme: "sk-rect",
                        message: "Please wait...",
                        textColor: "white"
                    });
                }
            });
        });

        function doSearch(serviceId) {
            $.ajax({
                type: "GET",
                url: "<?= base_url('ajax/service_detail/') ?>" + serviceId + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                dataType: "json",
                success: function(data) {
                    HoldOn.close();
                    reset();
                    if (data.status == false) {
                        $('#form-category').addClass('d-none');
                        $('#form-service').addClass('d-none');
                        $('#service-id').val('');
                        $('#service').html('<option value="0">Pilih Kategori</option>');
                        Swal.fire({
                            title: 'Ups!',
                            icon: 'error',
                            html: 'Layanan #' + serviceId + ' tidak ditemukan.',
                            confirmButtonText: 'Okay',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                            buttonsStyling: false,
                        });
                    } else {
                        $('#category-search').html('<option>' + data.msg.category + '</option>');
                        $('#form-category').removeClass('d-none');
                        $('#service').html('<option value="' + data.msg.id + '">' + data.msg.name + '</option>');
                        $('#form-service').removeClass('d-none');
                        $('#service-search').html('<input type="hidden" name="service" value="' + data.msg.id + '">');
                        $('#description').html(data.msg.description);
                        $('#rating').html(data.msg.rating);
                        if (data.msg.refill == '1') {
                            $('#is_refill').html('<i class="fas fa-check-circle"></i> Refill Button');
                            $('#is_refill').addClass('fw-bolder text-success small mt-1');
                        } else if (data.msg.refill == '0') {
                            $('#is_refill').html('<i class="fas fa-times-circle"></i> Refill Button');
                            $('#is_refill').addClass('fw-bolder text-danger small mt-1');
                        } else {
                            $('#is_refill').html('');
                            $('#is_refill').removeAttr('class');
                        }
                        if (data.msg.favorite == '1') {
                            $('#fav_service').addClass('fas fa-star text-primary');
                            $('#fav_service').attr('onclick', "unfav('" + serviceId + "');");
                        } else {
                            $('#fav_service').addClass('far fa-star text-primary');
                            $('#fav_service').attr('onclick', "fav('" + serviceId + "');");
                        }
                        $('#min-amount').val(data.msg.min);
                        $('#max-amount').val(data.msg.max);
                        $('#price').val(data.msg.price);
                        $('#average_time').val(data.msg.average_time);
                        if (data.msg.is_custom_price == '1') {
                            $('#txt_custom_price').removeClass('d-none');
                        } else {
                            $('#txt_custom_price').addClass('d-none');
                        }
                        if (data.msg.type == 'SEO') {
                            $('#formSEO').removeClass('d-none');
                            $('#inputSEO').attr('name', 'keywords');
                        } else if (data.msg.type == 'Mentions') {
                            $('#formMentions').removeClass('d-none');
                            $('#inputMentions').attr('name', 'usernames');
                        } else if (data.msg.type == 'Mentions with Hashtags') {
                            $('#formMentionsWithHashtags').removeClass('d-none');
                            $('#inputMentionsWithHashtags1').attr('name', 'usernames');
                            $('#inputMentionsWithHashtags2').attr('name', 'hashtags');
                        } else if (data.msg.type == 'Mentions Hashtag') {
                            $('#formMentionsHashtag').removeClass('d-none');
                            $('#inputMentionsHashtag').attr('name', 'hashtag');
                        } else if (data.msg.type == 'Mentions User Followers') {
                            $('#formMentionsUserFollowers').removeClass('d-none');
                            $('#inputMentionsUserFollowers').attr('name', 'username');
                        } else if (data.msg.type == 'Mentions Media Likers') {
                            $('#formMentionsMediaLikers').removeClass('d-none');
                            $('#inputMentionsMediaLikers').attr('name', 'username');
                        } else if (data.msg.type == 'Comment Likes') {
                            $('#formCommentLikes').removeClass('d-none');
                            $('#inputCommentLikes').attr('name', 'username');
                        } else if (data.msg.type == 'Poll') {
                            $('#formPoll').removeClass('d-none');
                            $('#inputPoll').attr('name', 'answer_number');
                            $('#quantity').attr('disabled', true);
                        } else if (data.msg.type == 'Invites from Groups') {
                            $('#formInvitesFromGroups').removeClass('d-none');
                            $('#inputInvitesFromGroups').attr('name', 'groups');
                        }
                    }
                },
                error: function() {
                    HoldOn.close();
                    $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
                },
                beforeSend: function() {
                    HoldOn.open({
                        theme: "sk-rect",
                        message: "Please wait...",
                        textColor: "white"
                    });
                }
            }).done(function() {
                $('#target').on('input', function() {
                    var serviceId = $('#service').val();
                    var target = $('#target').val();
                    total_price(serviceId, target);
                });
            });
        }
        // Event listener untuk tombol pencarian
        $('#btnSearch').on('click', function() {
            var serviceId = $('#service-id').val();
            doSearch(serviceId);
        });

        // Ambil parameter idpesanan dari URL
        var urlParams = new URLSearchParams(window.location.search);
        var idPesanan = urlParams.get("id");

        // Cek apakah ada idpesanan dalam URL, dan lakukan pencarian jika ada serta aktifkan tombol search
        if (idPesanan) {
            $('#btn-search').tab('show');
            $('#service-id').val(idPesanan);
            doSearch(idPesanan);
        }

        $('#service').change(function() {
            var service = $('#service').val();
            sessionStorage.setItem('last_service', service); // Simpan layanan ke sessionStorage
            $.ajax({
                type: "GET",
                url: "<?= base_url('ajax/service_detail/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                dataType: "json",
                success: function(data) {
                    HoldOn.close();
                    reset();
                    $('#description').html(data.msg.description);
                    $('#rating').html(data.msg.rating);
                    if (data.msg.refill == '1') {
                        $('#is_refill').html('<i class="fas fa-check-circle"></i> Refill Button');
                        $('#is_refill').addClass('fw-bolder text-success small mt-1');
                    } else if (data.msg.refill == '0') {
                        $('#is_refill').html('<i class="fas fa-times-circle"></i> Refill Button');
                        $('#is_refill').addClass('fw-bolder text-danger small mt-1');
                    } else {
                        $('#is_refill').html('');
                        $('#is_refill').removeAttr('class');
                    }
                    if (data.msg.favorite == '1') {
                        $('#fav_service').addClass('fas fa-star text-primary');
                        $('#fav_service').attr('onclick', "unfav('" + service + "');");
                    } else {
                        $('#fav_service').addClass('far fa-star text-primary');
                        $('#fav_service').attr('onclick', "fav('" + service + "');");
                    }
                    $('#min-amount').val(data.msg.min);
                    $('#max-amount').val(data.msg.max);
                    $('#price').val(data.msg.price);
                    $('#average_time').val(data.msg.average_time);
                    if (data.msg.is_custom_price == '1') {
                        $('#txt_custom_price').removeClass('d-none');
                    } else {
                        $('#txt_custom_price').addClass('d-none');
                    }
                    if (data.msg.type == 'SEO') {
                        $('#formSEO').removeClass('d-none');
                        $('#inputSEO').attr('name', 'keywords');
                    } else if (data.msg.type == 'Mentions') {
                        $('#formMentions').removeClass('d-none');
                        $('#inputMentions').attr('name', 'usernames');
                    } else if (data.msg.type == 'Mentions with Hashtags') {
                        $('#formMentionsWithHashtags').removeClass('d-none');
                        $('#inputMentionsWithHashtags1').attr('name', 'usernames');
                        $('#inputMentionsWithHashtags2').attr('name', 'hashtags');
                    } else if (data.msg.type == 'Mentions Hashtag') {
                        $('#formMentionsHashtag').removeClass('d-none');
                        $('#inputMentionsHashtag').attr('name', 'hashtag');
                    } else if (data.msg.type == 'Mentions User Followers') {
                        $('#formMentionsUserFollowers').removeClass('d-none');
                        $('#inputMentionsUserFollowers').attr('name', 'username');
                    } else if (data.msg.type == 'Mentions Media Likers') {
                        $('#formMentionsMediaLikers').removeClass('d-none');
                        $('#inputMentionsMediaLikers').attr('name', 'username');
                    } else if (data.msg.type == 'Comment Likes') {
                        $('#formCommentLikes').removeClass('d-none');
                        $('#inputCommentLikes').attr('name', 'username');
                    } else if (data.msg.type == 'Poll') {
                        $('#formPoll').removeClass('d-none');
                        $('#inputPoll').attr('name', 'answer_number');
                    } else if (data.msg.type == 'Invites from Groups') {
                        $('#formInvitesFromGroups').removeClass('d-none');
                        $('#inputInvitesFromGroups').attr('name', 'groups');
                    }
                },
                error: function() {
                    HoldOn.close();
                    $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
                },
                beforeSend: function() {
                    HoldOn.open({
                        theme: "sk-rect",
                        message: "Please wait...",
                        textColor: "white"
                    });
                }
            }).done(function() {
                $('#target').on('input', function() {
                    var service = $('#service').val();
                    var target = $('#target').val();
                    total_price(service, target);
                });
            });
        });
    });

    function reset() {
        $('#category-search').html('');
        $('#service-search').html('');
        $('#fav_service').removeAttr('class');
        $('#fav_service').removeAttr('onclick');
        $('#quantity').attr('disabled', false);
        // SEO
        $('#formSEO').addClass('d-none');
        $('#inputSEO').removeAttr('name');
        $('#inputSEO').val('');
        $('#inputSEOAlert').html('');
        // Mentions
        $('#formMentions').addClass('d-none');
        $('#inputMentions').removeAttr('name');
        $('#inputMentions').val('');
        $('#inputMentionsAlert').html('');
        // Mentions with Hashtags
        $('#formMentionsWithHashtags').addClass('d-none');
        $('#inputMentionsWithHashtags1').removeAttr('name');
        $('#inputMentionsWithHashtags1').val('');
        $('#inputMentionsWithHashtags1Alert').html('');
        $('#inputMentionsWithHashtags2').removeAttr('name');
        $('#inputMentionsWithHashtags2').val('');
        $('#inputMentionsWithHashtags2Alert').html('');
        // Mentions Hashtag
        $('#formMentionsHashtag').addClass('d-none');
        $('#inputMentionsHashtag').removeAttr('name');
        $('#inputMentionsHashtag').val('');
        // Mentions User Followers
        $('#formMentionsUserFollowers').addClass('d-none');
        $('#inputMentionsUserFollowers').removeAttr('name');
        $('#inputMentionsUserFollowers').val('');
        // Mentions Media Likers
        $('#formMentionsMediaLikers').addClass('d-none');
        $('#inputMentionsMediaLikers').removeAttr('name');
        $('#inputMentionsMediaLikers').val('');
        // Comment Likes
        $('#formCommentLikes').addClass('d-none');
        $('#inputCommentLikes').removeAttr('name');
        $('#inputCommentLikes').val('');
        // Poll
        $('#formPoll').addClass('d-none');
        $('#inputPoll').removeAttr('name');
        $('#inputPoll').val('');
        // Invites from Groups
        $('#formInvitesFromGroups').addClass('d-none');
        $('#inputInvitesFromGroups').removeAttr('name');
        $('#inputInvitesFromGroups').val('');
        $('#inputInvitesFromGroupsAlert').html('');
        $('#description').html('-');
        $('#rating').html('-');
        $('#average_time').val('-');
        $('#is_refill').html('<i class="fas fa-question-circle"></i> Refill Button');
        $('#is_refill').removeAttr('class').addClass('fw-bolder text-secondary small mt-1');
        $('#min-amount').val(0);
        $('#max-amount').val(0);
        $('#label-price').html('Harga / 1000');
        $('#price').val(0);
        $('#quantity').val('');
        $('#target').val('');
        $('#total-price').val(0);
        $('#txt_custom_price').addClass('d-none');
    }

    function total_price(service, target) {
        $.ajax({
            type: "GET",
            url: "<?= base_url('ajax/service_price_mass/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&target=" + target,
            dataType: "json",
            success: function(data) {
                HoldOn.close();
                $('#total-price').val(data.msg);
            },
            error: function() {
                HoldOn.close();
                $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
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


    function filterCategory(btn, category) {
        for (let i = 0; i <= 16; i++) {
            $('#resetFC' + i).removeClass('active');
        }
        $('.' + btn).addClass('active');
        $.ajax({
            type: "GET",
            url: "<?= base_url('ajax/category_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
            dataType: "json",
            success: function(data) {
                HoldOn.close();
                $('#category').html(data.msg);
                $('#service').html('<option value="0">Pilih Kategori</option>');
                reset();
            },
            error: function() {
                HoldOn.close();
                $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
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

    function fav(id) {
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>ajax/fav_service",
            data: {
                "id": id,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function(data) {
                HoldOn.close();
                if (data.result) {
                    $('#fav_service').removeAttr('class');
                    $('#fav_service').removeAttr('onclick');
                    $('#fav_service').addClass('fas fa-star text-primary');
                    $('#fav_service').attr('onclick', "unfav('" + id + "');");
                    Swal.fire({
                        title: 'Yeay!',
                        icon: 'success',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                } else {
                    Swal.fire({
                        title: 'Ups!',
                        icon: 'error',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                }
            },
            error: function() {
                HoldOn.close();
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

    function unfav(id) {
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>ajax/unfav_service",
            data: {
                "id": id,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function(data) {
                HoldOn.close();
                if (data.result) {
                    $('#fav_service').removeAttr('class');
                    $('#fav_service').removeAttr('onclick');
                    $('#fav_service').addClass('far fa-star text-primary');
                    $('#fav_service').attr('onclick', "fav('" + id + "');");
                    Swal.fire({
                        title: 'Yeay!',
                        icon: 'success',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                } else {
                    Swal.fire({
                        title: 'Ups!',
                        icon: 'error',
                        html: data.msg,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                }
            },
            error: function() {
                HoldOn.close();
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
</script>