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
                            <div class="form-group col-md-12">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2 form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?> baris</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>page/fav_services" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
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
                <h4 class="mb-0"><i class="far fa-star me-2"></i>Layanan Favorit</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Layanan</th>
                                <th>Min</th>
                                <th>Maks</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php foreach ($table as $value) : ?>
                            <tr>
                                <td><?= $value['service_id'] ?></td>
                                <td><?= $value['category_name'] ?></td>
                                <td><?= $value['service_name'] ?></td>
                                <td><?= currency($value['min']) ?></td>
                                <td><?= currency($value['max']) ?></td>
                                <td>Rp <?= currency($value['price']) ?></td>
                                <td class="text-nowrap">
                                    <button onclick="confirm_hapus('<?= $value['service_id'] ?>')" class="btn btn-danger btn-sm round">
                                        <i class="fas fa-trash fs-6 me-2"></i>Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="align-items-center mt-2 row text-center text-sm-start">
                    <div class="col-sm mb-2">
                        <div class="text-muted">
                            <?= $pagination_links ?>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <span class="text-muted">
                            Menampilkan <?= currency($awal) ?> sampai <?= ($akhir >= $total_data) ? currency($total_data) : currency($akhir) ?> dari <?= currency($total_data) ?> data.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // $(function() {
    //     $('#table-row').on('change', function() {
    //         var row = $('#table-row').val();
    //         var search = $('#table-search').val();
    //         window.location = "<?= base_url() ?>page/fav_services?row=" + row + "&search=" + search;
    //     });
    // });

    function confirm_hapus(service_id) {
        Swal.fire({
            title: 'Konfirmasi',
            html: 'Yakin ingin menghapus layanan <b>#' + service_id + '</b> dari Favorit?',
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
            if (result.value) window.location = "<?= base_url() ?>page/delete_fav/" + service_id
        })
    }
</script>