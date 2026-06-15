<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <div class="modal fade filter-data" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-12">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2-data form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>admin/auth/session" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter fs-6 me-2"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fab fa-firefox-browser me-2"></i>Sesi Aktif Admin</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Device</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table as $key => $value) : ?>
                                <tr>
                                    <td class="text-nowrap">
                                        <span class="fw-semibold">Device:</span> <?= $value['ud'] ?> (<?= $value['platform'] ?>) <?php $isBrowser = ($browser->cookie == $value['cookie']);
                                                                                                                                    if ($isBrowser) {
                                                                                                                                        echo '<span class="badge bg-light-success">Saat Ini</span>';
                                                                                                                                    } ?><br>
                                        <span class="fw-semibold">Browser:</span> <?= $value['browser'] ?> <?= $value['browser_version'] ?><br>
                                        <span class="fw-semibold">Login At:</span> <?= $this->lib->tanggal_indonesia($value['created_at']) ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php
                                        $lastActivity = strtotime($value['last_activity']);
                                        $currentTime = time();
                                        $timeDifference = $currentTime - $lastActivity;

                                        // Menyesuaikan variabel $isBrowser sesuai dengan data browser yang didapatkan
                                        $isBrowser = ($browser->cookie == $value['cookie']);

                                        if ($timeDifference > 60) { // Lebih dari 1 menit (60 detik)
                                            echo '<span class="btn btn-sm btn-light-secondary"><i class="fas fa-circle fs-6 me-2"></i>Aktif ' . $this->lib->time_elapsed_string($value['last_activity']) . '</span><br>';
                                        } else {
                                            echo '<span class="btn btn-sm btn-light-success"><i class="fas fa-circle fs-6 me-2"></i>Aktif saat ini</span><br>';
                                        }

                                        if (!$isBrowser) {
                                            echo '<a href="javascript:;" onclick="confirm_cabut(' . $value['id'] . ')" class="btn btn-danger btn-sm round mt-2"><i class="fas fa-times-circle fs-6 me-2"></i>Cabut Sesi</a>';
                                        } else {
                                            echo '<a href="javascript:;" class="btn btn-danger btn-sm round mt-2 disabled"><i class="fas fa-times-circle fs-6 me-2"></i>Cabut Sesi</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="align-items-center mt-2 row text-center text-sm-start">
                    <div class="col-sm mb-2">
                        <div class="text-muted">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <span class="text-muted">Menampilkan <?= currency($awal) ?> sampai <?php
                                                                                            if ($akhir >= $total_data) {
                                                                                                $akhir_page = $total_data;
                                                                                            } else {
                                                                                                $akhir_page = $akhir;
                                                                                            }
                                                                                            ?><?= currency($akhir_page) ?> dari <?= currency($total_data) ?> data.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function confirm_cabut(id) {
        Swal.fire({
            title: 'Konfirmasi',
            html: 'Yakin ingin Cabut Sesi ini?',
            icon: 'question',
            showCloseButton: true,
            confirmButtonText: 'Yakin',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-primary me-1',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.value) window.location = "<?= base_url() ?>admin/auth/cabut_sesi/" + id
        })
    }
</script>