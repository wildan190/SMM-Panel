					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow mb-4">	
								<div class="card-body">
									<form method="get">
										<div class="row">
											<div class="form-group col-lg-6 mb-2">
												<label>Tanggal Sortir</label>
												<input type="text" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d" data-range-date="true" id="demo-datepicker" name="date" placeholder="Pilih tanggal spesifik untuk laporan pesanan" value="<?= ($this->input->get('date') ? $this->input->get('date') : '') ?>">
											</div>

											<div class="form-group col-lg-6 mb-2">
												<label class="">Submit</label>
												<button type="submit" class="btn w-100 btn-blue"><i class="mdi mdi-filter"></i> Filter</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
                        <div class="col-xl-12">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-md-3 row-cols-1">
                                        <div class="col col-lg border-end">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">TOTAL PENGHASILAN KOTOR <i
                                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-space-ship-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span>Rp <?= number_format($widget['gross'][0]['rupiah'],0,',','.') ?> (<?= number_format($widget['gross'][0]['total'],0,',','.') ?>)</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col col-lg border-end">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">TOTAL PENGHASILAN BERSIH <i
                                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">Rp<span><?= number_format($widget['net'][0]['rupiah'],0,',','.') ?> (<?= number_format($widget['net'][0]['total'],0,',','.') ?>)</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h4 class="card-title mb-0 flex-grow-1"><i class="mdi mdi-chart-line"></i> Grafik Pesanan <?= ($this->input->get('date') ? 'Dari '.$this->lib->format_date($start).' sampai '.$this->lib->format_date($end).'' : 'Bulan Ini') ?></h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="<?= base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script>
                    <script src="<?= base_url() ?>assets/libs/moment/moment.js"></script>
                    <script type="text/javascript">
                    function getChartColorsArray(e) {
                        if (null !== document.getElementById(e)) {
                            var e = document.getElementById(e).getAttribute("data-colors");
                            return (e = JSON.parse(e)).map(function(e) {
                                var t = e.replace(" ", "");
                                if (-1 === t.indexOf(",")) {
                                    var a = getComputedStyle(document.documentElement).getPropertyValue(t);
                                    return a || t
                                }
                                e = e.split(",");
                                return 2 != e.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")"
                            })
                        }
                    }
                    var areachartBasicColors = getChartColorsArray("chart"),
                        options = {
                            series: [{
                                name: "Jumlah Pesanan",
                                data: [<?php
                    foreach ($chart as $key => $value) {
                        print(''.$value['all'].',');
                    }
                    ?>]
                            }],
                            chart: {
                                type: "area",
                                height: 350,
                                zoom: {
                                    enabled: !1
                                }
                            },
                            dataLabels: {
                                enabled: !1
                            },
                            stroke: {
                                curve: "smooth"
                            },
                            title: {
                                text: "Grafik Pesanan <?= ($this->input->get('date') ? 'Dari '.$this->lib->format_date($start).' sampai '.$this->lib->format_date($end).'' : 'Bulan Ini') ?>",
                                align: "left",
                                style: {
                                    fontWeight: 500
                                }
                            },
                            subtitle: {
                                text: "Pergerakan Transaksi <?= ($this->input->get('date') ? 'Dari '.$this->lib->format_date($start).' sampai '.$this->lib->format_date($end).'' : 'Bulan Ini') ?>",
                                align: "left"
                            },
                            labels: ['aa'],
                            xaxis: {
                                categories: [<?php
                    foreach ($chart as $key => $value) {
                        print('"'.$this->lib->format_chart($value['date']).'",');
                    }
                    ?>],
                            },
                            yaxis: {
                                opposite: !0
                            },
                            legend: {
                                horizontalAlign: "left"
                            },
                            colors: areachartBasicColors
                        },
                        chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                    </script>
