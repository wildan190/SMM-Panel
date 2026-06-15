<div class="row justify-content-center">
    <div class="col-md-12">
        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="text-center fs-5">
            <span class="fw-semibold text-primary"><?= $target->name ?></span>
            <div class="star mt-1">
                <?php
                $ratings = $this->service_rating_model->get_count(['where' => [['service_id' => $target->id]]]);
                if ($ratings <> 0) {
                ?>
                    <div class="star-section">
                        <?php
                        for ($i = 5; $i >= 1; $i--) {
                            $starClass = ($i <= $rating) ? 'text-warning' : 'text-muted';
                        ?>
                            <i class="fas fa-star <?= $starClass ?>"></i>
                        <?php } ?>

                    </div>
                    (<?= $rating ?>/5 dari <?= currency($this->service_rating_model->get_count(['where' => [['service_id' => $target->id]]])) ?> penilaian)
                <?php } else { ?>
                    <i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i> (0/5 dari 0 penilaian)
                <?php } ?>
            </div>

            <div class="mt-3">
                <span>Berikan penilaian Anda:</span><br class="mb-1">
                <div class="star star-section fs-3" id="star-section"></div>
            </div>

            <div class="row text-start mt-5">
                <div class="col-12">
                    <span>10 Penilaian terakhir:</span>

                    <?php
                    $targetId = $target->id; // Ambil ID dari objek $target

                    // Menggunakan model untuk mendapatkan 10 penilaian terakhir berdasarkan ID
                    $recentRatings = $this->service_rating_model->get_rows([
                        'where' => [['service_id' => $targetId]], // Gunakan array dua dimensi untuk kondisi where
                        'limit' => '10',
                        'order_by' => 'created_at desc' // Mengurutkan berdasarkan waktu secara descending
                    ]);

                    if (empty($recentRatings)) {
                        echo '<div class="card mt-3 mb-3" style="box-shadow: none !important;">
            <div class="card-body text-center">
                Belum ada penilaian.
            </div>
        </div>';
                    } else {
                        foreach ($recentRatings as $row) {
                            $user = $this->user_model->get_by_id($row['user_id']); ?>
                            <div class="card mt-3 mb-3" style="box-shadow: none !important;">
                                <div class="card-body">
                                    <div class="media align-items-start">
                                        <div class="chat-avtar">
                                            <img class="img-radius img-fluid wid-40" src="<?= base_url() ?>uploads/profil/<?= $user->foto ?>" alt="Profil <?= $user->full_name ?>">
                                            <div class="bg-success chat-badge"></div>
                                        </div>
                                        <div class="media-body ms-3">
                                            <h6 class="mb-1"><?= $user->full_name ?></h6>
                                            <p class="text-muted text-sm mb-1"><?= $this->lib->tanggal_indonesia($row['created_at']) ?></p>
                                            <div class="star-section">
                                                <?php
                                                for ($i = 5; $i >= 1; $i--) {
                                                    $starClass = ($i <= $row['rating']) ? 'text-warning' : 'text-muted';
                                                ?>
                                                    <i class="fas fa-star <?= $starClass ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // Menambahkan bintang dinamis ke dalam div star-section
    for (let i = 5; i >= 1; i--) {
        $('#star-section').append(`<i class="fas fa-star star-btn text-muted" onclick="submitStar('<?= $target->id ?>', ${i})"></i>`);
    }

    function submitStar(service, star) {
        return new Promise((resolve, reject) => {
            Swal.fire({
                title: 'Konfirmasi',
                icon: 'question',
                html: `Anda yakin ingin memberikan ${star} rating untuk layanan ini?`,
                showCancelButton: true,
                confirmButtonText: 'Rating',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false,
            }).then(async (result) => {
                if (result.value) {
                    var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
                    var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                    try {
                        let response = await $.ajax({
                            url: "<?= base_url() ?>ajax/giverating",
                            method: "POST",
                            data: {
                                service: service,
                                star: star,
                                [csrfName]: csrfHash
                            },
                        });

                        $.unblockUI();

                        if (response.status == 1) {
                            await Swal.fire({
                                title: 'Berhasil',
                                icon: 'success',
                                html: response.text,
                                confirmButtonText: 'Okay',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                                buttonsStyling: false,
                            });
                            resolve();
                            location.reload();
                        } else {
                            await Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                html: response.text || 'Terjadi kesalahan saat memberikan rating. Harap coba lagi.',
                                confirmButtonText: 'Okay',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                                buttonsStyling: false,
                            });
                            reject(new Error('Gagal memberikan rating'));
                        }
                    } catch (error) {
                        console.error('Kesalahan dalam memberikan rating:', error);
                        Swal.fire({
                            title: 'Gagal',
                            icon: 'error',
                            html: 'Terjadi kesalahan saat memberikan rating. Harap coba lagi.',
                            confirmButtonText: 'Okay',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                            buttonsStyling: false,
                        });
                        reject(error);
                    }
                }
            });
        });
    }
</script>