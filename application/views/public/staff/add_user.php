<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-list-ul fs-4 me-2"></i> Harga Pendaftaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-colored-bordered table-bordered-dark">
                        <tr>
                            <th>Hak Akses</th>
                            <th>Harga Pendaftaran</th>
                            <th>Bonus Saldo Pengguna Baru</th>
                        </tr>
                        <?php
                        foreach ($price_bonus as $key => $value) {
                            ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td>Rp <?= number_format($value['price'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($value['bonus'], 0, ',', '.') ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-users"></i> Tambah Pengguna</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group mb-2">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" value="<?= set_value('email') ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama Lengkap *</label>
                        <input type="text" class="form-control" name="full_name" value="<?= set_value('full_name') ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label>Username *</label>
                        <input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group mb-2">
                        <label>Hak Akses *</label>
                        <select class="select2 form-control" name="level">
                            <?php
                            foreach ($list_level as $key => $value) {
                                ?>
                                <option value="<?= $value ?>"><?= $value ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane fs-6 me-2"></i>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>