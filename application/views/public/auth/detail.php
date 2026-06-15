<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body position-relative">
                <div class="position-absolute end-0 top-0 p-3">
                    <span class="badge bg-primary"><?= $target->level ?></span>
                </div>
                <div class="text-center mt-3">
                    <div class="chat-avtar d-inline-flex mx-auto">
                        <img class="rounded-circle img-fluid wid-60" src="<?= base_url() ?>uploads/profil/<?= $target->foto ?>" alt="<?= $target->full_name ?>">
                    </div>
                    <h5 class="mb-0"><?= $target->full_name ?></h5>
                    <p class="text-muted text-sm"><?= $target->username ?></p>
                    <hr class="my-3 border border-dark-subtle">
                    <div class="row g-3">
                        <div class="col-4">
                            <h5 class="mb-0"><?= currency($total_referral) ?></h5>
                            <small class="text-muted">Referral</small>
                        </div>
                        <div class="col-4 border border-top-0 border-bottom-0">
                            <h5 class="mb-0"><?= currency(user('point')) ?></h5>
                            <small class="text-muted">Point</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0"><?= currency(user('refferal_view')) ?></h5>
                            <small class="text-muted">Total Visit</small>
                        </div>
                    </div>
                    <hr class="my-3 border border-dark-subtle">
                    <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                        <i class="ti ti-mail"></i>
                        <p class="mb-0"><?= $target->email ?></p>
                    </div>
                    <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                        <i class="ti ti-phone"></i>
                        <p class="mb-0"><?= $target->whatsapp ?></p>
                    </div>
                    <div class="d-inline-flex align-items-center justify-content-between w-100">
                        <i class="ti ti-link me-2"></i>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="copy_target_input" value="<?= base_url() ?>auth/register?referral=<?= $target->refferal_code ?>" disabled>
                            <a href="javascript:;" class="btn btn-primary btn-sm" onclick="copy_text('Link Referral');"><i class="fas fa-copy me-2"></i></a>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user me-2"></i>Detail Pribadi</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Nama Lengkap</p>
                                <h6 class="mb-2"><?= $target->full_name ?></h6>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Username</p>
                                <h6 class="mb-0"><?= $target->username ?></h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Jenis Kelamin</p>
                                <h6 class="mb-2">
                                    <?php
                                    if ($target->gender == 'male') {
                                        echo 'Laki-laki';
                                    } elseif ($target->gender == 'female') {
                                        echo 'Perempuan';
                                    } else {
                                        echo 'Tidak diketahui';
                                    }
                                    ?>
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Telegram</p>
                                <h6 class="mb-0"><?= $target->telegram ?></h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Pesanan Bulan Ini</p>
                                <h6 class="mb-2">Rp
                                    <?= currency($total_order[0]['rupiah']) ?> (<?= currency($total_order[0]['total']) ?>)</h6>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Deposit Bulan Ini</p>
                                <h6 class="mb-0">Rp
                                    <?= currency($total_deposit[0]['rupiah']) ?> (<?= currency($total_deposit[0]['total']) ?>)</h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                        <p class="mb-1 text-muted">Terdaftar Sejak</p>
                        <h6 class="mb-0"><?= $this->lib->tanggal_indonesia($target->created_at) ?></h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function copy_text(title) {
        var inputElement = document.getElementById('copy_target_input');
        inputElement.removeAttribute("disabled");
        inputElement.select();
        document.execCommand("copy");
        inputElement.setAttribute("disabled", "true");

        Swal.fire({
            title: 'Yeay!',
            icon: 'success',
            html: title + ' berhasil disalin.',
            confirmButtonText: 'Okay',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            buttonsStyling: false,
        });
    }
</script>