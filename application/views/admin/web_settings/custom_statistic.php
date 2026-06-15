<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST" action="<?= base_url() ?>admin/web_settings/custom_statistic?act=total" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="alert alert-primary">
                            <div class="alert-body">
                                Fitur ini dapat Anda gunakan untuk memanipulasi statistik pengguna, pesanan, dan deposit pada <em><b>Landing Page.</b></em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Manipulasi Total Pengguna</label>
                        <input type="number" class="form-control" name="total_user" value="<?= custom_statistic('total_user') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Manipulasi Total Deposit</label>
                        <input type="number" class="form-control" name="total_deposit" value="<?= custom_statistic('total_deposit') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">Manipulasi Total Pesanan</label>
                        <input type="number" class="form-control" name="total_order" value="<?= custom_statistic('total_order') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="<?= base_url() ?>admin/web_settings/custom_statistic?act=online" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="alert alert-primary">
                            <div class="alert-body">
                                Fitur ini dapat Anda gunakan untuk memanipulasi statistik Admin Online dan User Online pada <em><b>Dashboard User.</b></em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Manipulasi Admin Online</label>
                        <input type="number" class="form-control" name="total_admin_online" value="<?= custom_statistic('total_admin_online') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Manipulasi User Online</label>
                        <input type="number" class="form-control" name="total_user_online" value="<?= custom_statistic('total_user_online') ?>" autocomplete="off">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="<?= base_url() ?>admin/web_settings/custom_statistic?act=top_order" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="alert alert-primary">
                            <div class="alert-body">
                                Fitur ini dapat Anda gunakan untuk memanipulasi statistik Top 10 Pesanan. Jika Nomor 1-5 diaktifkan maka nomor 6-10 akan menampilkan data statistik yang asli.
                            </div>
                        </div>
                    </div>
                </div>
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="form-label">Manipulasi Top Pesanan #<?= $i ?></label>
                            <select class="select2-data form-control" name="s_top_order_<?= $i ?>" onchange="mTo('<?= $i ?>', this.value);">
                                <option value="0" <?= (custom_statistic("s_top_order_$i") == 0) ? 'selected' : '' ?>>Inactive</option>
                                <option value="1" <?= (custom_statistic("s_top_order_$i") == 1) ? 'selected' : '' ?>>Active</option>
                            </select>
                        </div>
                        <?php $inputs = ['u', 'a', 'c']; ?>
                        <?php foreach ($inputs as $input) : ?>
                            <div class="col-md-3 form-group">
                                <?php
                                $label = '';
                                switch ($input) {
                                    case 'u':
                                        $label = 'Nama Pengguna #';
                                        $inputType = 'text'; // Mengubah tipe input hanya untuk 'sc'
                                        break;
                                    case 'a':
                                        $label = 'Jumlah Pesanan #';
                                        $inputType = 'number';
                                        break;
                                    case 'c':
                                        $label = 'Total Pesanan #';
                                        $inputType = 'number';
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                                <label class="form-label"><?= $label ?><?= $i ?></label>
                                <input type="<?= $inputType ?>" class="form-control" name="<?= "{$input}_top_order_$i" ?>" id="<?= "{$input}_top_order_$i" ?>" value="<?= custom_statistic("{$input}_top_order_$i") ?>" autocomplete="off" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="<?= base_url() ?>admin/web_settings/custom_statistic?act=top_deposit" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="alert alert-primary">
                            <div class="alert-body">
                                Fitur ini dapat Anda gunakan untuk memanipulasi statistik Top 10 Deposit. Jika Nomor 1-5 diaktifkan maka nomor 6-10 akan menampilkan data statistik yang asli.
                            </div>
                        </div>
                    </div>
                </div>
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="form-label">Manipulasi Top Deposit #<?= $i ?></label>
                            <select class="select2-data form-control" name="s_top_deposit_<?= $i ?>" onchange="mTd('<?= $i ?>', this.value);">
                                <option value="0" <?= (custom_statistic("s_top_deposit_$i") == 0) ? 'selected' : '' ?>>Inactive</option>
                                <option value="1" <?= (custom_statistic("s_top_deposit_$i") == 1) ? 'selected' : '' ?>>Active</option>
                            </select>
                        </div>
                        <?php $inputs = ['u', 'a', 'c']; ?>
                        <?php foreach ($inputs as $input) : ?>
                            <div class="col-md-3 form-group">
                                <?php
                                $label = '';
                                switch ($input) {
                                    case 'u':
                                        $label = 'Nama Pengguna #';
                                        $inputType = 'text'; // Mengubah tipe input hanya untuk 'sc'
                                        break;
                                    case 'a':
                                        $label = 'Jumlah Deposit #';
                                        $inputType = 'number';
                                        break;
                                    case 'c':
                                        $label = 'Total Deposit #';
                                        $inputType = 'number';
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                                <label class="form-label"><?= $label ?><?= $i ?></label>
                                <input type="<?= $inputType ?>" class="form-control" name="<?= "{$input}_top_deposit_$i" ?>" id="<?= "{$input}_top_deposit_$i" ?>" value="<?= custom_statistic("{$input}_top_deposit_$i") ?>" autocomplete="off" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="<?= base_url() ?>admin/web_settings/custom_statistic?act=top_service" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <div class="alert alert-primary">
                            <div class="alert-body">
                                Fitur ini dapat Anda gunakan untuk memanipulasi statistik Top 10 Layanan. Jika Nomor 1-5 diaktifkan maka nomor 6-10 akan menampilkan data statistik yang asli.
                            </div>
                        </div>
                    </div>
                </div>
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="form-label">Manipulasi Top Layanan #<?= $i ?></label>
                            <select class="select2-data form-control" name="s_top_service_<?= $i ?>" onchange="mTs('<?= $i ?>', this.value);">
                                <option value="0" <?= (custom_statistic("s_top_service_$i") == 0) ? 'selected' : '' ?>>Inactive</option>
                                <option value="1" <?= (custom_statistic("s_top_service_$i") == 1) ? 'selected' : '' ?>>Active</option>
                            </select>
                        </div>
                        <?php $inputs = ['sc', 'a', 'c']; ?>
                        <?php foreach ($inputs as $input) : ?>
                            <div class="col-md-3 form-group">
                                <?php
                                $label = '';
                                switch ($input) {
                                    case 'sc':
                                        $label = 'Nama Layanan #';
                                        $inputType = 'text'; // Mengubah tipe input hanya untuk 'sc'
                                        break;
                                    case 'a':
                                        $label = 'Jumlah Pesanan #';
                                        $inputType = 'number';
                                        break;
                                    case 'c':
                                        $label = 'Total Pesanan #';
                                        $inputType = 'number';
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                                <label class="form-label"><?= $label ?><?= $i ?></label>
                                <input type="<?= $inputType ?>" class="form-control" name="<?= "{$input}_top_service_$i" ?>" id="<?= "{$input}_top_service_$i" ?>" value="<?= custom_statistic("{$input}_top_service_$i") ?>" autocomplete="off" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>

                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        for (let i = 1; i <= 10; i++) {
            const value = $(`select[name="s_top_service_${i}"]`).val();
            toggle_mTs(i, value);
        }
        for (let i = 1; i <= 10; i++) {
            const value = $(`select[name="s_top_order_${i}"]`).val();
            toggle_mTo(i, value);
        }
        for (let i = 1; i <= 10; i++) {
            const value = $(`select[name="s_top_deposit_${i}"]`).val();
            toggle_mTd(i, value);
        }
    });

    function mTo(id, value) {
        toggle_mTo(id, value);
    }

    function toggle_mTo(id, value) {
        const inputs = ['u', 'a', 'c'];
        for (const input of inputs) {
            const element = $(`#${input}_top_order_${id}`);
            element.prop('disabled', value !== '1');
        }
    }

    function mTd(id, value) {
        toggle_mTd(id, value);
    }

    function toggle_mTd(id, value) {
        const inputs = ['u', 'a', 'c'];
        for (const input of inputs) {
            const element = $(`#${input}_top_deposit_${id}`);
            element.prop('disabled', value !== '1');
        }
    }

    function mTs(id, value) {
        toggle_mTs(id, value);
    }

    function toggle_mTs(id, value) {
        const inputs = ['sc', 'a', 'c'];
        for (const input of inputs) {
            const element = $(`#${input}_top_service_${id}`);
            element.prop('disabled', value !== '1');
        }
    }
</script>