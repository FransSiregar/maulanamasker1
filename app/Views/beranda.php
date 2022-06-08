<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<main>
    <div class="container-fluid px-4">
        <!-- Judul Besar -->
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
        <!-- Body -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Penjualan
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-trans" class="form-control" value="<?= date('Y'); ?>" onchange="chartTransaksi()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartTransaksi" width="100%" height="40"></canvas></div>
                    <div class="d-grid gab-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartTransaksi('PDF')">
                            Unduh PDF
                        </button>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Pembelian
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-pem" class="form-control" value="<?= date('Y'); ?>" onchange="chartPembelian()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartPembelian" width="100%" height="40"></canvas></div>
                    <div class="d-grid gab-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartPembelian('PDF')">
                            Unduh PDF
                        </button>
                       
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Customer
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-cust" class="form-control" value="<?= date('Y'); ?>" onchange="chartCustomer()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartCust" width="100%" height="40"></canvas></div>
                    <div class="d-grid gab-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartCustomer('PDF')">
                            Unduh PDF
                        </button>
                        
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Supplier
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-sup" class="form-control" value="<?= date('Y'); ?>" onchange="chartSupplier()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartSup" width="100%" height="40"></canvas></div>
                    <div class="d-grid gab-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartSupplier('PDF')">
                            Unduh PDF
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        chartTransaksi()
        chartPembelian()
        chartCustomer()
        chartSupplier()
    });


    // ==========================TRANSAKSI===========================

    function setLineChart(dataset) {

        // Area Chart Example
        var ctx = document.getElementById("chartTransaksi");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartTransaksi() {
        var tahun = $('#tahun-trans').val();
        $.ajax({
            url: "/chart-transaksi",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setLineChart(dataset)
            }
        });
    }
    // end setLineChart

    // ==========================PEMBELIAN===========================

    function set2LineChart(dataset) {

        // Area Chart Example
        var ctx = document.getElementById("chartPembelian");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartPembelian() {
        var tahun = $('#tahun-pem').val();
        $.ajax({
            url: "/chart-pembelian",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                set2LineChart(dataset)
            }
        });
    }
    // end setLineChart


    // ======================CUSTOMER ============================
    function setBarChart(dataset) {
        // Bar chart exmaple

        var ctx = document.getElementById("chartCust");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartCustomer() {
        var tahun = $('#tahun-cust').val();
        $.ajax({
            url: "/chart-customer",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setBarChart(dataset)
            }
        });
    }

    // ======================SUPLIER ============================
    function setBarChart2(dataset) {
        // Bar chart exmaple

        var ctx = document.getElementById("chartSup");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartSupplier() {
        var tahun = $('#tahun-sup').val();
        $.ajax({
            url: "/chart-supplier",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setBarChart2(dataset)
            }
        });
    }

    // Download Chart png

    function downloadChartImg(download, chart) {
        var img = chart.toDataURL("image/jpg", 1.0).replace("image/jpg",
            "image / octet-stream ")
        download.setAttribute("href", img)
    }

    function downloadChartPDF(chart, name) {
        html2canvas(chart, {
            onrendered: function(canvas) {
                var img = canvas.toDataURL("image/jpg", 1.0)
                var doc = new jsPDF('p', 'pt', 'A4')
                var lebarKonten = canvas.width
                var tinggiKonten = canvas.height
                var tinggiPage = lebarKonten / 592.28 * 841.89
                var leftHeight = tinggiKonten
                var position = 0
                var imgWidth = 592.28
                var imgHeight = 592.28 / lebarKonten * tinggiKonten
                if (leftHeight < tinggiPage) {
                    doc.addImage(img, 'PNG', 0, 0, imgWidth, imgHeight)
                } else {
                    while (leftHeight > 0) {
                        doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight)
                        leftHeight -= tinggiPage
                        position -= 841.80
                        if (leftHeight > 0) {
                            pdf.addPage()
                        }
                    }
                }
                doc.save(name);
            }
        });
    }

    function downloadChartTransaksi(type) {
        var download = document.getElementById('download-trans')
        var chart = document.getElementById('chartTransaksi')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Transaksi.pdf")
        }
    }
    
 function downloadChartPembelian(type) {
        var download = document.getElementById('download-beli')
        var chart = document.getElementById('chartPembelian')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Pembelian.pdf")
        }

    }

    function downloadChartCustomer(type) {
        var download = document.getElementById('download-cust')
        var chart = document.getElementById('chartCust')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Customer.pdf")
        }
    }

    function downloadChartSupplier(type) {
        var download = document.getElementById('download-sup')
        var chart = document.getElementById('chartSup')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "ChartSupplier.pdf")
        }
    }
</script>


<style>
    .carousel-item {
        height: 32rem;
        background: #777;
        color: white;
        position: relative;
    }

    .container {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding-bottom: 50px;
    }
</style>
<?= $this->endSection() ?>