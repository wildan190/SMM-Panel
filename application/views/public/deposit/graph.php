<div class="row">
    <div class="col-md-12">
        <?php if ($this->input->get('date')) : ?>
            <?php
            $awal = $this->lib->format_date($start);
            $akhir = $this->lib->format_date($end);
            ?>
            <div class="alert alert-primary">
                <div class="alert-body">
                    <i class="fas fa-info-circle me-2"></i> Menampilkan data Deposit <em><b><?= $awal ?></b></em> sampai <em><b><?= $akhir ?></b></em>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-primary">
                <div class="alert-body">
                    <i class="fas fa-info-circle me-2"></i> Menampilkan data Deposit bulan ini.
                </div>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-pen-nib me-2"></i>Laporan Deposit</h4>
            </div>
            <div class="card-body pb-4">
                <form method="get" class="row">
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <input type="text" id="pc-date_range_picker-2" class="form-control" name="date" placeholder="Pilih tanggal spesifik untuk laporan deposit" value="<?= ($this->input->get('date') ? $this->input->get('date') : '') ?>">
                            <button type="submit" class="input-group-text btn btn-primary"><i class="feather icon-calendar me-2"></i>Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <?php foreach ($widget as $status => $data) : ?>
                        <table class="table <?= ($status == 'success') ? 'table-success' : (($status == 'pending') ? 'table-warning' : (($status == 'canceled') ? 'table-danger' : '')) ?> table-hover mb-0">
                            <tr>
                                <th width="30%"><?= ucfirst($status) ?></th>
                                <td>Rp <?= number_format($data[0]['rupiah'], 0, ',', '.') ?> dari <?= number_format($data[0]['total'], 0, ',', '.') ?> deposit.</td>
                            </tr>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-line-chart me-2"></i>Grafik Deposit</h4>
            </div>
            <div class="card-body pb-4">
                <div id="chart"></div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.querySelector('#pc-date_range_picker-2'), {
            mode: 'range',
            dateFormat: 'Y-m-d', // Sesuaikan format tanggal yang diinginkan
        });
    });
</script>
<!-- Script untuk ApexCharts -->
<script src="<?= base_url() ?>assets/js/plugins/apexcharts.min.js"></script>
<script src="<?= base_url() ?>assets/js/pages/chart-apex.js"></script>
<script>
    const jsonData = <?= json_encode($chart) ?>;

    const chartData = Object.keys(jsonData).map(date => ({
        x: jsonData[date].date,
        all: parseInt(jsonData[date].all),
        success: parseInt(jsonData[date].success),
        pending: parseInt(jsonData[date].pending),
        canceled: parseInt(jsonData[date].canceled),
    }));

    const options = {
        chart: {
            type: 'area',
            height: 350,
            width: '100%',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        series: [{
                name: 'Semua',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.all
                }))
            },
            {
                name: 'Success',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.success
                }))
            },
            {
                name: 'Pending',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.pending
                }))
            },
            {
                name: 'Canceled',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.canceled
                }))
            }
        ],
        xaxis: {
            type: 'category'
        },
        yaxis: {
            min: 0
        },
        colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        }
    };

    const chart = new ApexCharts(document.querySelector('#chart'), options);
    chart.render();
</script>