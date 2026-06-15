<div class="row">
    <div class="col-md-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total Penghasilan Kotor</p>
                        <h4 class="mb-0 text-white">Rp <?= number_format($widget['gross'][0]['rupiah'], 0, ',', '.') ?> (<?= number_format($widget['gross'][0]['total'], 0, ',', '.') ?>)
                        </h4>
                    </div>
                    <div class="avtar">
                        <i class="fas fa-dollar f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total Penghasilan Bersih</p>
                        <h4 class="mb-0 text-white">Rp <?= number_format($widget['net'][0]['rupiah'], 0, ',', '.') ?> (<?= number_format($widget['net'][0]['total'], 0, ',', '.') ?>)</h4>
                    </div>
                    <div class="avtar">
                        <i class="fas fa-dollar f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        $data = ''; // Inisialisasi variabel $data dengan string kosong

        // Cek apakah parameter 'date' ada dalam URL
        if ($this->input->get('date')) {
            // Format tanggal awal dan akhir menggunakan fungsi format_date dari objek $this->lib
            $awal = $this->lib->format_date($start);
            $akhir = $this->lib->format_date($end);

            // Buat pesan dengan rentang tanggal
            $data = '<div class="alert alert-primary">
                    <div class="alert-body">
                        <i class="fas fa-info-circle me-2"></i> Menampilkan data Pesanan <em><b>' . $awal . '</b></em> sampai <em><b>' . $akhir . '</b></em>
                    </div>
                </div>';
        } else {
            // Jika tidak ada parameter 'date', tampilkan pesan "Bulan Ini"
            $data = '<div class="alert alert-primary">
                    <div class="alert-body">
                        <i class="fas fa-info-circle me-2"></i> Menampilkan data Pesanan bulan ini.
                    </div>
                </div>';
        }
        ?>

        <?= $data ?>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-pen-nib me-2"></i>Laporan Pesanan</h4>
            </div>
            <div class="card-body pb-4">
                <form method="get" class="row">
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <input type="text" id="pc-date_range_picker-2" class="form-control" name="date" placeholder="Pilih tanggal spesifik untuk laporan pesanan" value="<?= ($this->input->get('date') ? $this->input->get('date') : '') ?>">
                            <button type="submit" class="input-group-text btn btn-primary"><i class="feather icon-calendar me-2"></i>Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tr class="table-success">
                            <th width="30%">Success</th>
                            <td>Rp
                                <?= number_format($widget['success'][0]['rupiah'], 0, ',', '.') ?> dari
                                <?= number_format($widget['success'][0]['total'], 0, ',', '.') ?> pesanan.
                            </td>
                        </tr>
                        <tr class="table-warning">
                            <th width="30%">Pending</th>
                            <td>Rp
                                <?= number_format($widget['pending'][0]['rupiah'], 0, ',', '.') ?> dari
                                <?= number_format($widget['pending'][0]['total'], 0, ',', '.') ?> pesanan.
                            </td>
                        </tr>
                        <tr class="table-info">
                            <th width="30%">Processing</th>
                            <td>Rp
                                <?= number_format($widget['processing'][0]['rupiah'], 0, ',', '.') ?> dari
                                <?= number_format($widget['processing'][0]['total'], 0, ',', '.') ?> pesanan.
                            </td>
                        </tr>
                        <tr class="table-danger">
                            <th width="30%">Error</th>
                            <td>Rp
                                <?= number_format($widget['error'][0]['rupiah'], 0, ',', '.') ?> dari
                                <?= number_format($widget['error'][0]['total'], 0, ',', '.') ?> pesanan.
                            </td>
                        </tr>
                        <tr class="table-danger">
                            <th width="30%">Partial</th>
                            <td>Rp
                                <?= number_format($widget['partial'][0]['rupiah'], 0, ',', '.') ?> dari
                                <?= number_format($widget['partial'][0]['total'], 0, ',', '.') ?> pesanan.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-line-chart me-2"></i>Grafik Pesanan</h4>
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
    // Data status
    console.log('Data JSON:', <?= json_encode($chart); ?>); // Tambahkan baris ini
    const jsonData = <?= json_encode($chart); ?>; // Menyesuaikan dengan variabel yang menyimpan data chart dari PHP

    const dataStatus = {};
    jsonData.forEach(obj => {
        const date = Object.keys(obj)[0];
        const statuses = obj[date];
        dataStatus[date] = statuses;
    });

    // Mengubah data status menjadi format yang dapat digunakan oleh ApexCharts
    const chartData = Object.keys(jsonData).map(date => ({
        x: jsonData[date].date,
        all: jsonData[date].all,
        success: jsonData[date].success,
        pending: jsonData[date].pending,
        processing: jsonData[date].processing,
        error: jsonData[date].error,
        partial: jsonData[date].partial,
    }));
    // Konfigurasi grafik
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
                name: 'Processing',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.processing
                }))
            },
            {
                name: 'Error',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.error
                }))
            },
            {
                name: 'Partial',
                data: chartData.map(data => ({
                    x: data.x,
                    y: data.partial
                }))
            }
        ],
        xaxis: {
            type: 'category'
        },
        yaxis: {
            min: 0
        },
        colors: ['#008FFB', '#00E396', '#FEB019', '#30bccc', '#FF4560', '#ff45e3'],
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

    // Membuat grafik dengan menggunakan ApexCharts
    const chart = new ApexCharts(document.querySelector('#chart'), options);
    chart.render();
</script>