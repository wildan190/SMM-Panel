<div class="row">
    <div class="col-md-12">
<a class="btn mb-3 btn-primary" data-bs-toggle="collapse" href="#filterCategory">
<i class="fas fa-filter fs-6 me-2"></i>Filter Kategori
</a>
</div>
        <div class="collapse multi-collapse" id="filterCategory">
	<div class="col-md-12">
        <div class="card">
            <div class="card-body p-2" style="margin-bottom: -4px;">
                <div class="row gx-1">
                    <div class="col-6 col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnAll active" id="resetFC1" onclick="filterCategory('btnAll', '0');"><span class="d-flex align-items-center"><i class="fas fa-adjust fs-4 me-2" style="margin-top: 1px;"></i>Semua</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnInstagram" id="resetFC2" onclick="filterCategory('btnInstagram', 'Instagram');"><span class="d-flex align-items-center"><i class="fab fa-instagram fs-4 me-2" style="margin-top: 1px;"></i>Instagram</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnFacebook" id="resetFC3" onclick="filterCategory('btnFacebook', 'Facebook');"><span class="d-flex align-items-center"><i class="fab fa-facebook fs-4 me-2" style="margin-top: 1px;"></i>Facebook</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnYoutube" id="resetFC4" onclick="filterCategory('btnYoutube', 'Youtube');"><span class="d-flex align-items-center"><i class="fab fa-youtube fs-4 me-2" style="margin-top: 1px;"></i>Youtube</span></span></button>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnTwitter" id="resetFC5" onclick="filterCategory('btnTwitter', 'Twitter');"><span class="d-flex align-items-center"><i class="fab fa-twitter fs-4 me-2" style="margin-top: 1px;"></i>Twitter</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnSpotify" id="resetFC6" onclick="filterCategory('btnSpotify', 'Spotify');"><span class="d-flex align-items-center"><i class="fab fa-spotify fs-4 me-2" style="margin-top: 1px;"></i>Spotify</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnTiktok" id="resetFC7" onclick="filterCategory('btnTiktok', 'Tiktok', 'Tik tok');"><span class="d-flex align-items-center"><i class="fab fa-tiktok fs-4 me-2" style="margin-top: 1px;"></i>Tiktok</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnLinkedin" id="resetFC8" onclick="filterCategory('btnLinkedin', 'Linkedin');"><span class="d-flex align-items-center"><i class="fa-brands fa-linkedin fs-4 me-2"></i> LinkedIn</span></span></button>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnThreads" id="resetFC9" onclick="filterCategory('btnThreads', 'Threads');"><span class="d-flex align-items-center"><i class="fa-brands fa-at fs-4 me-2"></i>Threads</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnTelegram" id="resetFC10" onclick="filterCategory('btnTelegram', 'Telegram');"><span class="d-flex align-items-center"><i class="fab fa-telegram fs-4 me-2" style="margin-top: 1px;"></i>Telegram</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnDiscord" id="resetFC11" onclick="filterCategory('btnDiscord', 'Discord');"><span class="d-flex align-items-center"><i class="fab fa-discord fs-4 me-2" style="margin-top: 1px;"></i>Discord</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnSoundCloud" id="resetFC12" onclick="filterCategory('btnSoundCloud', 'SoundCloud');"><span class="d-flex align-items-center"><i class="fa-brands fa-soundcloud fs-4 me-2"></i>SoundCloud</span></span></button>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnTwitch" id="resetFC13" onclick="filterCategory('btnTwitch', 'Twitch');"><span class="d-flex align-items-center"><i class="fab fa-twitch fs-4 me-2" style="margin-top: 1px;"></i>Twitch</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnWebsite" id="resetFC14" onclick="filterCategory('btnWebsite', 'Website');"><span class="d-flex align-items-center"><i class="fas fa-globe fs-4 me-2" style="margin-top: 1px;"></i>Web Traffic</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnPromo" id="resetFC15" onclick="filterCategory('btnPromo', 'Promo');"><span class="d-flex align-items-center"><i class="fa-solid fa-heart fs-4 me-2" style="margin-top: 1px;"></i>Promo</span></span></button>
                        <button type="button" class="btn btn-outline-primary w-100 mb-1 btnOther" id="resetFC16" onclick="filterCategory('btnOther', 'Other');"><span class="d-flex align-items-center"><i class="fa-solid fa-shuffle fs-4 me-2"></i>Other</span></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i>Pesanan Baru</h4>
            </div>
            <div class="card-body pb-3">
                                <form method="POST">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="category">
                                    <option value="0">Pilih...</option>
									<?php
						foreach ($service_category as $key => $value) {
						?>
						<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
						<?php
						}
						?>
                                                                    </select>
                            </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Layanan <span class="text-danger">*</span></label>
                            <span class="fw-bolder text-danger small mt-1 d-none" id="refill_false"><i class="fas fa-times-circle"></i> Tombol Refill</span>
                            <span class="fw-bolder text-success small mt-1 d-none" id="refill_true"><i class="fas fa-check-circle"></i> Tombol Refill</span>
                            <span class="fw-bolder text-secondary small mt-1" id="refill_reset"><i class="fas fa-question-circle"></i> Tombol Refill</span>
                        </div>
                        <select class="select2 form-control" name="service" id="service">
                            <option value="0">Pilih Kategori</option>
                        </select>
                        <div id="service-search"></div>
                    </div>
                    <div class="form-group" id="form_description">
                        <label class="form-label">Deskripsi</label>
                        <span class="form-control text-break" style="height: auto;" id="description" disabled>-</span>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="form-label">Minimal Pesanan</label>
                            <input type="text" class="form-control" value="0" id="min" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">Maksimal Pesanan</label>
                            <input type="text" class="form-control" value="0" id="max" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="d-flex justify-content-between">
                            <label class="form-label" id="label-price">Harga / 1000</label>
                            <span class="fw-bolder text-success small mt-1 d-none" id="txt_custom_price"><i class="fas fa-check-circle"></i> Harga Khusus!</span>
                            </div>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="text" class="form-control" value="0" id="price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Target <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= (form_error('target') ? 'is-invalid' : '') ?>" name="target" id="target">
                            <?php echo form_error('target', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Jumlah Pesanan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= (form_error('quantity') ? 'is-invalid' : '') ?>" name="quantity" id="quantity">
                            <?php echo form_error('quantity', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="form-group d-none" id="formSEO">
                        <label class="form-label">Keywords <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputSEO" rows="4" placeholder="*Keywords list separated by Enter."></textarea><span class="text-danger" id="inputSEOAlert"></span>
                    </div>
                    <div class="form-group d-none" id="input_custom_comments">
                        <label class="form-label">Kustom Komentar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="custom_comments" name="custom_comments" rows="4" placeholder="Selamat Pagi.
Selamat Siang.
Selamat Malam."></textarea><span class="text-danger" id="custom_comments">*Komentar dipisahkan oleh Enter.</span>
                    </div>
                    <div class="form-group d-none" id="formMentions">
                        <label class="form-label">Usernames<span class="text-danger">*</span></label>
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
                    <div class="form-group d-none" id="formMentionsCustomList">
                        <label class="form-label">Usernames <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputMentionsCustomList" rows="4" placeholder="*Usernames list separated by Enter."></textarea><span class="text-danger" id="inputMentionsCustomListAlert"></span>
                    </div>
                    <div class="form-group d-none" id="formMentionsHashtag">
                        <label class="form-label">Hashtag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsHashtag"><span class="text-danger">*The hashtag you want to send.</span>
                    </div>
                    <div class="form-group d-none" id="formMentionsUserFollowers">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsUserFollowers"><span class="text-danger">*Username of the person you want to mention.</span>
                    </div>
                    <div class="form-group d-none" id="formMentionsMediaLikers">
                        <label class="form-label">Media <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputMentionsMediaLikers"><span class="text-danger">*Media URL you want to send.</span>
                    </div>
                    <div class="form-group d-none" id="formCustomCommentsPackage">
                        <label class="form-label">Comments <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="inputCustomCommentsPackage" rows="4" placeholder="*Comments list separated by Enter."></textarea><span class="text-danger" id="inputCustomCommentsPackageAlert"></span>
                    </div>
                    <div class="form-group d-none" id="formCommentLikes">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputCommentLikes"><span class="text-danger">*Username of the comment owner.</span>
                    </div>
                    <div class="form-group d-none" id="formPoll">
                        <label class="form-label">Answer Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputPoll"><span class="text-danger">*Answer number of the poll.</span>
                    </div>
                    <div class="d-none" id="formCommentReplies">
                        <div class="form-group">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputCommentReplies1"><span class="text-danger">*Username of the comment owner.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Comments <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="inputCommentReplies2" rows="4" placeholder="*Comments list separated by Enter."></textarea><span class="text-danger" id="inputCommentReplies2Alert"></span>
                        </div>
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
                    </div><hr>
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
function formatText (icon) {
    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
};

$('.select2').select2({
    width: "50%",
    templateSelection: formatText,
    templateResult: formatText,
	allowHtml: true
});
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
                $('#category').html(data.msg);
                $('#service').html('<option value="0">Pilih Kategori</option>');
                $('#price').val('0');
				$('#min').val('0');
				$('#max').val('0');
				$('#quantity').val('');
				$('#total-price').val('0');
				$('#description').html('Pilih layanan dahulu.');
				$('#average_time').val('Pilih layanan dahulu.');
            },
            error: function() {
                $('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
            }
        });
    }
</script>
<script type="text/javascript">
$(document).keypress(function(event) {
	if (event.which == '13' && !$(event.target).is('textarea')) {
		event.preventDefault();
	}
});
$(function() {
	$('#category').on('change', function() {
		reset();
		var category = $('#category').val();
		$.ajax({
			type: "GET",
			url: "<?= base_url('ajax/service_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
			dataType: "json",
			success: function(data) {
				$('#service').html(data.msg);
			}, error: function() {
				alert('Terjadi kesalahan, silakan refresh halaman ini.');
			}
		});
	});
	$('#service').on('change', function() {
		var service = $('#service').val();
		$.ajax({
			type: "GET",
			url: "<?= base_url('ajax/service_detail/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
			dataType: "json",
			success: function(data) {
				if (data.msg.type == 'custom_comments') {
					$('#quantity').prop('readonly', true);
					$('#input_custom_comments').removeClass('d-none');
				} else {
					$('#quantity').prop('readonly', false);
					$('#input_custom_comments').addClass('d-none');
				}
				if (data.msg.type == 'custom_link') {
					$('#input_custom_link').removeClass('d-none');
				} else {
					$('#input_custom_link').addClass('d-none');
				}
                if (data.msg.refill == '1') {
                    $('#refill_true').removeClass('d-none');
                    $('#refill_false').addClass('d-none');
                    $('#refill_reset').addClass('d-none');
                } else {
                    $('#refill_false').removeClass('d-none');
                    $('#refill_true').addClass('d-none');
                    $('#refill_reset').addClass('d-none');
                } 
				if (data.msg.is_custom_price == 1) {
					$('#txt_custom_price').removeClass('d-none');
				} else {
					$('#txt_custom_price').addClass('d-none');
				}
				if (data.msg.description == '-') {
					$('#form_description').addClass('d-none');
				} else {
					$('#form_description').removeClass('d-none');
				}
				$('#price').val(data.msg.price);
				$('#min').val(data.msg.min);
				$('#max').val(data.msg.max);
				$('#description').html(data.msg.description);
				$('#average_time').val(data.msg.average_time);

				//var newline = String.fromCharCode(13, 10);
				//var dess = data.msg.description;
				//dess.replace('\r\n', newline);
			//	input.replaceAll('\\n', newline);
				
			}, error: function() {
				alert('Terjadi kesalahan, silakan refresh halaman ini.');
			}
		});
	});
	$('#custom_comments').keyup(function() {
		var service = $('#service').val();
		var area = document.getElementById("custom_comments")
        var text = area.value.replace(/\s+$/g,"")
  	    var split = text.split("\n")
		$('#quantity').val(split.length);
		var quantity = $('#quantity').val();
		total_price(service, quantity);
	});
	$('#quantity').on('keyup', function() {
		var service = $('#service').val();
		var quantity = $('#quantity').val();
		total_price(service, quantity);
	});
	function reset() {
		$('#price').val('0');
		$('#min').val('0');
		$('#max').val('0');
        $('#quantity').attr('disabled', false);
		$('#total-price').val('0');
		$('#description').html('Pilih layanan dahulu.');
		$('#form_description').removeClass('d-none');
		$('#input_custom_comments').addClass('d-none');
		$('#input_custom_link').addClass('d-none');
		$('#txt_custom_price').addClass('d-none');
		$('#average_time').val('Pilih layanan dahulu.');
        $('#refill_true').addClass('d-none');
        $('#refill_false').addClass('d-none');
        $('#refill_reset').removeClass('d-none');
        $('#is_refill').html('<i class="fas fa-question-circle"></i> Refill Button');
        $('#is_refill').removeAttr('class').addClass('fw-bolder text-secondary small mt-1');
	}
	function total_price(service, quantity) {
		$.ajax({
			type: "GET",
			url: "<?= base_url('ajax/service_price/') ?>" + service + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&quantity=" + quantity,
			dataType: "json",
			success: function(data) {
				$('#total-price').val(data.msg);
			}, error: function() {
				$('#total-price').val('0');
			}
		});
	}

});

$('form').submit(function(){
    $(this).children('button[type=submit]').prop('disabled', true);
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>