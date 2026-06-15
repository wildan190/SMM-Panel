<div class="row">
    <div class="col-md-12">
        <a href="javascript:;" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target=".filter-data"><i class="fas fa-filter fs-6 me-2"></i>Filter Data</a>
        <a href="javascript:;" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target=".info-refill"><i class="fas fa-info-circle fs-6 me-2"></i>Informasi Refill</a>
        <div class="modal fade info-refill" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Ketentuan Refill</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-0">
                            <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Untuk Layanan Refill</h5>
                            <div class="alert-body">
                                <ul class="mb-0">
                                    <li>Hanya <b><em>tombol refill</em></b> yang berwarna <b><em>merah / hijau</em></b> yang bisa dilakukan refill.</li>
                                    <li>Gunakan <b><em>tombol refill</em></b> ini hanya ketika pesanan Anda mengalami drop.</li>
                                    <li>Anda dapat menggunakan <b><em>tombol refill</em></b> kembali setelah 24 jam terakhir kali Anda menggunakannya.</li>
                                    <li>Jika <b><em>tombol refill</em></b> berwarna merah artinya <b><em>tombol refill</em></b> belum bisa digunakan.</li>
                                    <li>Jika <b><em>tombol refill</em></b> berwarna hijau namun responnya adalah <em>"Refill not allowed"</em> artinya fitur refill pada pesanan tersebut belum bisa digunakan, namun Anda bisa mencoba kembali secara berkala.</li>
                                    <li>Anda harus menunggu selama 1-3 hari setelah pesanan Anda <em>Success</em> untuk dapat menggunakan fitur refill.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade filter-data" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-filter me-2"></i>Filter Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <form method="get" class="row">
                            <div class="form-group col-md-4">
                                <label class="form-label">Tampilkan</label>
                                <select class="select2 form-control" name="rows" id="rows">
                                    <?php
                                    foreach ($rows as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('rows') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Filter Status</label>
                                <select class="select2 form-control" name="status" id="statuss">
                                    <option value="">Semua</option>
                                    <?php
                                    foreach ($status as $key => $value) {
                                    ?>
                                        <option value="<?= $key ?>" <?= ($this->input->get('status') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Cari ID Refill</label>
                                <input type="text" class="form-control" nname="search" id="search" value="<?= $this->input->get('search') ?>" placeholder="ID Refill...">
                            </div>
                            <div class="form-group col-md-6 d-grid">
                                <a href="<?= base_url() ?>order/refill_history" class="btn btn-danger"><i class="fas fa-sync fs-6 me-2"></i>Reset</a>
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
                <h4 class="mb-0"><i class="fas fa-recycle me-2"></i>Riwayat Refill</h4>
            </div>
            <div class="card-body pb-4">
                <a href="javascript:;" class="btn btn-primary mb-4" onclick="copy_id();"><i class="fas fa-copy fs-6 me-2"></i>Salin <b><em>ID Refill</em></b></a>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr class="text-uppercase">
                                <th class="text-nowrap">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th class="text-nowrap">ID Refill</th>
                                <th>ID PESANAN</th>
                                <th class="text-nowrap">Layanan</th>
                                <th class="text-nowrap">Target</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Tgl <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tanggal Refill"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $key => $value) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox" id="checkbox-aditdev" value="<?= $value['id'] ?>">
                                        </div>
                                    </td>
                                    <td><?= $value['id'] ?></td>
                                    <td><a href="javascript:;" onclick="modal_open('detail_pesanan', '<?= base_url('order/detail/' . $value['order_id'] . '/' . $this->security->get_csrf_hash() . '') ?>')" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Detail"><b>#<?= $value['order_id'] ?></b></a></td>
                                    <td><?= $value['service'] ?></td>
                                    <td><?= $value['target'] ?></td>
                                    <td class="text-nowrap">
                                        <?= $this->lib->status_order($value['status']) ?></span>
                                    </td>
                                    <td><?= $this->lib->tanggal_indonesia($value['created_at']) ?></td>
                                </tr>
                            <?php
                            }
                            ?>
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
<div class="modal fade" id="detail_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail_modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3" id="detail_modal_body">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#rows').on('change', function() {
            var rows = $('#rows').val();
            var status = $('#statuss').val();
            var search = $('#search').val();
            window.location = "<?= base_url('order/refill_history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
        });
        $('#statuss').on('change', function() {
            var rows = $('#rows').val();
            var status = $('#statuss').val();
            var search = $('#search').val();
            window.location = "<?= base_url('order/refill_history') ?>?rows=" + rows + "&status=" + status + "&search=" + search;
        });
    });
</script>
<script type="text/javascript">
    function copy_target(element) {
        var copyText = document.getElementById(element);
        copyText.select();
        document.execCommand("copy");
    }

    function copy_id() {
        var data = "";
        var i = 1;
        $("tbody input[type=checkbox]:checked").each(function() {
            var id = $(this).val();
            data += id;
            if ($("tbody input[type=checkbox]:checked").length > i) {
                data += ", ";
            }
            i++;
        });
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.setAttribute("id", "dummy_id");
        document.getElementById("dummy_id").value = data;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        if (data.length > 0) {
            Swal.fire({
                title: 'Yeay!',
                icon: 'success',
                html: '<em><b>ID Refill</b></em> berhasil disalin.',
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
                html: 'Tidak ada <em><b>ID Refill</b></em> untuk disalin.',
                confirmButtonText: 'Okay',
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false,
            });
        }
    }

    $('#select-all').on('click', function() {
        console.log(1);
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });

    function detail_order(id) {
        $('#detail_modal_title').html('<i class="fas fa-search me-2"></i>Detail Pesanan #' + id);
        $('#detail_modal').modal('show');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>order/detail",
            data: "id=" + id,
            dataType: "html",
            success: function(data) {
                $('#detail_modal_body').html(data);
            },
            error: function() {
                $('#ajax-result').html('<font color="red">Terjadi kesalahan, jika masalah ini masih berlanjut mohon hubungi Admin.</font>');
            },
            beforeSend: function() {
                $('#detail_modal_body').html('<div class="progress mb-0"><div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"></div></div>');
            }
        });
    }
</script>