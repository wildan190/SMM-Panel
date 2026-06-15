<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Informasi</h4>
            </div>
            <div class="card-body pb-4" style="overflow: auto;">
                <?php
                foreach ($table as $key => $value) {
                ?>
                    <ul class="list-group list-group-flush border-top-0">
                        <li class="list-group-item pt-0 px-0">
                            <div class="d-flex align-items-start ">
                                <div class="flex-grow-1 me-2">
                                    <span class="mb-0"><span class="fs-6 badge text-white fw-bold bg-<?= $this->lib->status_info_bg($value['category']) ?> rounded-pill"><i class="fas fa-info-circle"></i>
                                            <?= $this->lib->status_info($value['category']) ?>
                                        </span><small class="fw-normal float-end">
                                            <?= $this->lib->tanggal_indonesia($value['created_at']) ?>
                                        </small></span>
                                    <p class="my-1" style="margin-top: 0.6rem !important">
                                        <?= $value['content'] ?>
                                    </p>
                                    <small>Pembaruan terakhir:
                                        <?= $this->lib->tanggal_indonesia($value['updated_at']) ?>
                                    </small>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <hr class="mt-0">
                <?php } ?>
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