
                                <?php
                                if ($status == true) {
                                ?>
                                <div class="text-center">
                                    <h4 class="text-logo">Verifikasi Berhasil</h4>
                                    <p>Silahkan login akun anda dengan username dan password yang telah di daftarkan</p>
                                    <div class="text-center mb-4 mt-4">
                                        <a href="<?= base_url('auth/login') ?>" class="btn btn-blue btn-block text-white">Login</a>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <div class="text-center">
                                    <h4 class="text-logo">Verifikasi Gagal</h4>
                                    <div class="text-center mb-4 mt-4">
                                        <a href="<?= base_url('auth/login') ?>" class="btn btn-blue btn-block text-white">Login</a>
                                    </div>
                                </div>
                                <?php } ?>
                            