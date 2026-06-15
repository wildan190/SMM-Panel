<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total User</p>
                        <h4 class="mb-0 text-white"><?= $this->user_model->get_count(['where' => [['status' => 1]]]) ?></h4>
                    </div>
                    <div class="avtar">
                        <i class="fas fa-users f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total Saldo User</p>
                        <h4 class="mb-0 text-white">Rp <?= currency($widget['user'][0]['rupiah']) ?></h4>
                    </div>
                    <div class="avtar">
                        <i class="fas fa-wallet f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total Deposit</p>
                        <h4 class="mb-0 text-white">Rp <?= currency($widget['deposit'][0]['rupiah']) ?> (<?= currency($widget['deposit'][0]['total']) ?>)</h4>
                    </div>
                    <div class="avtar">
                        <i class="far fa-credit-card f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="card bg-primary available-balance-card" style="border: var(--bs-card-border-width) solid var(--bs-primary) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-0 text-white text-opacity-75">Total Pesanan</p>
                        <h4 class="mb-0 text-white">Rp <?= currency($widget['order'][0]['rupiah']) ?> (<?= currency($widget['order'][0]['total']) ?>)</h4>
                    </div>
                    <div class="avtar">
                        <i class="fas fa-cart-plus f-18"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik Transaksi 14 Hari Terakhir</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div id="mixed-chart-2"></div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-12 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-trophy me-2"></i>Top 5 Layanan Terlaris</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <?php if ($widget['service_order'] == true) { ?>
                    <div id="pie-chart-1" style="width: 100%"></div>
                <?php } else { ?>
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                        <h5 class="mt-2">Sorry! No Result Found</h5>
                        <p class="text-muted">Data belum tersedia, lakukan pesanan dengan 3 layanan berbeda untuk melihat data</p>
                    </div>
                <?php } ?>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>

    <div class="col-12 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="fas fa-trophy me-2"></i>Top 3 Pengguna Terbaik</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-bordered table-striped table-hover m-0" id="table-data">
                        <thead>
                            <tr class="">
                                <th>PERINGKAT</th>
                                <th>NAMA</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($order as $key => $value) {
                            ?>
                                <tr class="<?= ($no == 1) ? 'table-info' : '' ?>">
                                    <td><?= $no ?></td>
                                    <td><?= ($no == 1) ? '<i class="mdi mdi-trophy-outline text-black"></i>' : '' ?><?= $value['full_name'] ?></td>
                                    <td>Rp <?= number_format($value['rupiah'], 0, ',', '.') ?> (<?= number_format($value['total'], 0, ',', '.') ?>)</td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
<!-- [Page Specific JS] start -->
<script src="<?= base_url() ?>assets/js/plugins/apexcharts.min.js"></script>
<script src="<?= base_url() ?>assets/js/pages/chart-apex.js"></script>
<script src="<?= base_url() ?>assets/js/pages/dashboard-analytics.js"></script>

<script type="text/javascript">
    // pie chart 1
    var options_pie_chart_1 = {
        chart: {
            height: 480,
            type: 'pie'
        },
        labels: [<?php
                    foreach ($widget['service_order'] as $key => $value) {
                        print('"' . $value['service'] . '",');
                    }
                    ?>],
        series: [<?php
                    foreach ($widget['service_order'] as $key => $value) {
                        print('' . $value['total_service'] . ',');
                    }
                    ?>],
        colors: ['#4680FF', '#2CA87F', '#13c2c2', '#E58A00', '#DC2626'],
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'left'
        },
        dataLabels: {
            enabled: true,
            dropShadow: {
                enabled: false
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var chart_pie_chart_1 = new ApexCharts(document.querySelector('#pie-chart-1'), options_pie_chart_1);
    chart_pie_chart_1.render();

    // mixed chart 2
    var options_mixed_chart_2 = {
        chart: {
            height: 350,
            type: 'line',
            stacked: false
        },
        stroke: {
            width: [2, 5, 0],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%'
            }
        },
        colors: ['#4680FF', '#E58A00', '#DC2626'],
        series: [{
                name: 'Pesanan',
                type: 'area',
                data: [<?php
                        foreach ($chart as $key => $value) {
                            print('' . $value['order'] . ',');
                        }
                        ?>]
            },
            {
                name: 'Deposit',
                type: 'line',
                data: [<?php
                        foreach ($chart as $key => $value) {
                            print('' . $value['deposit'] . ',');
                        }
                        ?>]
            },
            {
                name: 'Refund',
                type: 'column',
                data: [<?php
                        foreach ($chart as $key => $value) {
                            print('' . $value['refund'] . ',');
                        }
                        ?>]
            }
        ],
        fill: {
            opacity: [0.25, 1, 0.85],
            gradient: {
                inverseColors: false,
                shade: 'light',
                type: 'vertical',
                opacityFrom: 0.85,
                opacityTo: 0.55,
                stops: [0, 100, 100, 100]
            }
        },
        labels: [
            <?php
            foreach ($chart as $key => $value) {
                print('"' . date('Y-m-d', strtotime($value['date'])) . '",');
            }
            ?>
        ],
        markers: {
            size: 0
        },
        xaxis: {
            type: 'datetime'
        },
        yaxis: {
            min: 0
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== 'undefined') {
                        return y.toFixed(0);
                    }
                    return y;
                }
            }
        },
        legend: {
            labels: {
                useSeriesColors: true
            },
            markers: {
                customHTML: [
                    function() {
                        return '';
                    },
                    function() {
                        return '';
                    },
                    function() {
                        return '';
                    }
                ]
            }
        }
    };
    var charts_mixed_chart_2 = new ApexCharts(document.querySelector('#mixed-chart-2'), options_mixed_chart_2);
    charts_mixed_chart_2.render();
</script>