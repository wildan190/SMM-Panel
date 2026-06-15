<div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Total Pesanan</th>
                <td><?= currency($total_order) ?> pesanan</td>
            </tr>
            <tr>
                <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Waktu Rata-Rata</th>
                <td>
                    <?= $average_time ?>
                    <br>
                    <em class="small text-danger">(Berdasarkan 10 pesanan terakhir)</em>
                </td>
            </tr>
            <tr>
                <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Success</th>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 30%; flex-shrink: 0;">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $combined_percent ?>%"></div>
                            </div>
                        </div>
                        <span style="margin-left: 5px;"><?= $combined_percent ?>%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Processing</th>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 30%; flex-shrink: 0;">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $processing_percent ?>%"></div>
                            </div>
                        </div>
                        <span style="margin-left: 5px;"><?= $processing_percent ?>%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);">Pending</th>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 30%; flex-shrink: 0;">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $pending_percent ?>%"></div>
                            </div>
                        </div>
                        <span style="margin-left: 5px;"><?= $pending_percent ?>%</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="form-group row mb-0">
    <div class="col-md-12">
        <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal"><i class="fas fa-times-circle fs-6 me-2"></i>Tutup</button>
    </div>
</div>