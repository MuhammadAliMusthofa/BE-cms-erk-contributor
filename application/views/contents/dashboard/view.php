<style>
.tab-cuy {
    width: 100%;
    height: 350px;
    max-width: 100%
}
.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }

    @media (max-width: 767px) {
    .hide-on-mobile {
        display: none;
    }
}
</style>
<div class="row mt-5">
    <div class="col-lg-12 mt-12">
        <div class="row mt-2">
            <div class="col-6 col-sm-3 col-md-2">
                <div class="card">
                    <a href="<?php echo base_url('videos')?>" target = " _blank ">
                        <div class="seo-fact sbg1">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="menu-icon fa fa-video-camera"></i></div>
                                <h2><?php echo $totalVideosCount; ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <div class="card">
                    <a href="<?php echo base_url('users')?>" target = " _blank ">
                        <div class="seo-fact sbg2">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="menu-icon ti-user"></i></div>
                                <h2><?php echo $usersCount; ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <div class="card">
                    <a href="<?php echo base_url('packages')?>" target = " _blank ">
                        <div class="seo-fact sbg3">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="menu-icon fa fa-ticket"></i></div>
                                <h2><?php echo $packageCount; ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <a href="<?php echo base_url('payment')?>" target = " _blank ">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="menu-icon fa fa-cart-arrow-down"></i></div>
                                <h2><?php echo $paymentCount; ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="menu-icon fa fa-money"></i></div>
                            <h2><?php if ($total_price > 0): ?>
                                <?php
                                    $formatted_price = number_format($total_price, 0, ',', '.');
                                    echo "<h2>Rp $formatted_price</h2>";
                                ?>
                                <?php else: ?>
                                    <p>No results found</p>
                                <?php endif; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="header-title">Penggunaan Harian</h4>
                            <div class="trd-history-tabs">
                                <ul class="nav" role="tablist">
                                    <li>
                                        <a class="active" data-toggle="tab" href="#users" role="tab">Users</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#redeem" role="tab">Redeem</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#video" role="tab">VIdeo</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#payment" role="tab">Transaksi</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- <div>
                            <?php echo date('Y-m-d H:i:s')?>
                            </div> -->
                        </div>
                        <div class="trad-history mt-4">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="users" role="tabpanel">
                                    <div class="tab-cuy" id="customers"></div>
                                    <div style="text-align: right;">
                                        <a href="<?php echo base_url('customer')?>" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="redeem" role="tabpanel">
                                    <div class="tab-cuy" id="redeem-chart"></div>
                                    <div style="text-align: right;">
                                        <a href="<?php echo base_url('redeem_history')?>" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="video" role="tabpanel">
                                    <div class="tab-cuy" id="video-chart"></div>
                                    <div style="text-align: right;">
                                        <a href="<?php echo base_url('videos')?>" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="payment" role="tabpanel">
                                    <div class="tab-cuy" id="payment-chart"></div>
                                    <div style="text-align: right;">
                                        <a href="<?php echo base_url('payment')?>" >Detail Data  <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sell_order" role="tabpanel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="card">
                    <div class="card-body">
                    <h4 class="header-title">Top Transaksi</h4>
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <div class="trd-history-tabs">
                                <ul class="nav" role="tablist">
                                    <li>
                                        <a class="active" data-toggle="tab" href="#banyak" role="tab">Jumlah</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#nominal" role="tab">Nilai</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="trad-history mt-2">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="banyak" role="tabpanel">
                                    <!-- <h4 class="header-title">With Badges</h4> -->
                                    <ul class="list-group">
                                        <?php foreach ($top_users as $row) { ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo $row->full_name ?>
                                                <span class="badge badge-primary badge-pill"><?php echo $row->total_uid ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="nominal" role="tabpanel">
                                    <!-- <h4 class="header-title">With Badges</h4> -->
                                    <ul class="list-group">
                                        <?php foreach ($top_users_total_price as $row) {
                                            $formatted_price = number_format($row->total_price, 0, ',', '.'); // Formatting to Rupiah
                                        ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo $row->full_name ?>
                                                <span class="badge badge-primary badge-pill">Rp <?php echo $formatted_price ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <a href="<?php echo base_url('payment')?>" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex flex-wrap justify-content-between mb-4 align-items-center">
                                    <h4 class="header-title mb-0">Team Admin</h4>
                                </div>
                                <div class="member-box">
                                    <?php foreach ($admins as $admin): ?>
                                        <div class="s-member">
                                            <div class="media align-items-center">
                                                <img src="<?php echo base_url()?>assets/ace/avatars/<?php echo $admin->avatar ?>" class="d-block ui-w-30 rounded-circle" alt="">
                                                <div class="media-body ml-5">
                                                    <p><?php echo $admin->name ?></p>
                                                    <span><?php echo $admin->title ?></span>
                                                </div>
                                                <div class="tm-social">
                                                    <?php if ($admin->status === 'online'): ?>
                                                        <i class="fa fa-circle" style="color: #4cff63;"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-circle" style="color: #ff0e0e;"></i>
                                                    <?php endif; ?>
                                                    <!-- <a href="#"><i class="fa fa-envelope"></i></a> -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div style="text-align: right;">
                                    <a href="<?php echo base_url('admin')?>" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="header-title">User Transaksi</h4>
                            <div class="trd-history-tabs">
                                <ul class="nav" role="tablist">
                                    <li>
                                        <a class="active" data-toggle="tab" href="#satu" role="tab">Retail/Sekolah</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#langganan" role="tab">Subscribe/Voucher</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="trad-history mt-4">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="satu" role="tabpanel">
                                    <div id="ampiechart1"></div>
                                </div>
                                <div class="tab-pane fade" id="langganan" role="tabpanel">
                                    <div id="ampiechart2"></div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <a href="<?php echo base_url('payment')?>" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">History User</h4>
                        <div class="timeline-area">
                            <?php foreach ($user_history as $row) { ?>
                                <div class="timeline-task">
                                    <div class="icon bg2">
                                        <i class="fa fa-history"></i>
                                    </div>
                                    <div class="tm-title">
                                        <h4><?php echo $row->full_name ?></h4>
                                        <span class="time"><i class="ti-time"></i><?php echo $row->updatedAt ?></span>
                                        <p><?php echo $row->action ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div> 
                        <div style="text-align: right;">
                            <a href="<?php echo base_url('admin')?>" >Selengkapnya  <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Video Terbaru</h4>
                        <div class="letest-news mt-2">
                            <?php foreach ($terbaru_videos as $lastes): ?>
                                <div class="single-post mb-xs-40 mb-sm-40">
                                    <div class="lts-thumb">
                                        <img src="<?= base_url('assets/upload_thumbnail/' . ($lastes->thumbnail_id ? $lastes->thumbnail_id : 'not_available.png')); ?>" alt="post thumb">
                                    </div>
                                    <div class="lts-content">
                                        <h2><a href="<?= base_url('videos')?>"><?= $lastes->name_id; ?></a></h2>
                                        <p class="hide-on-mobile"><?= $lastes->description_id; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div style="text-align: right;">
                                <a href="<?php echo base_url('videos')?>" >Semua Data Video  <i class="fa fa-chevron-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bar  -->
<script>
    var chartDataUsers = <?= $jsonChartDataUsers ?>;

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("customers", am4charts.XYChart);
        // var chart = am4core.create("redeem", am4charts.XYChart);

        // Add data
        chart.data = chartDataUsers;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";
        
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "chart-export";
        chart.exporting.useWebFonts = false;
        chart.exporting.adapter.add("data", function(data) {
            data.data = data.data.filter(function(item) {
                return item.category !== undefined;
            });
            return data;
        });

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Users";

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 10;

        

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;
    
        // Create a range to highlight weekends
        var weekends = new am4core.Column();
        weekends.fill = am4core.color("#F5F5F5");
        weekends.fillOpacity = 0.6;

        var range = dateAxis.axisRanges.create();
        range.date = new Date("2023-01-01");
        range.endDate = new Date("2023-12-31");
        range.axisFill = weekends;
        range.grid.stroke = am4core.color("#FFFFFF");
        range.grid.strokeOpacity = 0.8;
        range.grid.strokeWidth = 1;
    });
</script>
<script>
    var chartDataRedeem = <?= $jsonChartDataRedeem ?>

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("redeem-chart", am4charts.XYChart);

        // Add data
        chart.data = chartDataRedeem;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Redeem History";

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 10;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        // Create a range to highlight weekends
        var weekends = new am4core.Column();
        weekends.fill = am4core.color("#F5F5F5");
        weekends.fillOpacity = 0.6;

        var range = dateAxis.axisRanges.create();
        range.date = new Date("2023-01-01");
        range.endDate = new Date("2023-12-31");
        range.axisFill = weekends;
        range.grid.stroke = am4core.color("#FFFFFF");
        range.grid.strokeOpacity = 0.8;
        range.grid.strokeWidth = 1;
    });
</script>
<script>
    var chartDataVideo = <?= $jsonChartDataVideo ?>;

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("video-chart", am4charts.XYChart);
        // var chart = am4core.create("redeem", am4charts.XYChart);

        // Add data
        chart.data = chartDataVideo;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Video";

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 10;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        // Create a range to highlight weekends
        var weekends = new am4core.Column();
        weekends.fill = am4core.color("#F5F5F5");
        weekends.fillOpacity = 0.6;

        var range = dateAxis.axisRanges.create();
        range.date = new Date("2023-01-01");
        range.endDate = new Date("2023-12-31");
        range.axisFill = weekends;
        range.grid.stroke = am4core.color("#FFFFFF");
        range.grid.strokeOpacity = 0.8;
        range.grid.strokeWidth = 1;
    });
</script>
<script>
    var chartDataPayment = <?= $jsonChartDataPayment ?>;

    // AmCharts Configuration
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("payment-chart", am4charts.XYChart);

        // Add data
        chart.data = chartDataPayment;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.title.text = "Date";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Transaksi";

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 10;

        // Add scrollbar
        chart.scrollbarX = new am4core.Scrollbar();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        // Create a range to highlight weekends
        var weekends = new am4core.Column();
        weekends.fill = am4core.color("#F5F5F5");
        weekends.fillOpacity = 0.6;

        var range = dateAxis.axisRanges.create();
        range.date = new Date("2023-01-01");
        range.endDate = new Date("2023-12-31");
        range.axisFill = weekends;
        range.grid.stroke = am4core.color("#FFFFFF");
        range.grid.strokeOpacity = 0.8;
        range.grid.strokeWidth = 1;
    });
</script>
<!-- pie chart -->
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countEnum1 = <?php echo $count_consumer_1; ?>;
    var countEnum2 = <?php echo $count_consumer_2; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart1", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Retail",
            "jumlah": <?php echo $count_consumer_1; ?>
        }, {
            "transaksi": "Sekolah",
            "jumlah": <?php echo $count_consumer_2; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Atur properti dan tema grafik (opsional)
        chart.paddingBottom = 30;
        chart.angle = 15;
        chart.innerRadius = am4core.percent(50);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "chart-export";
        chart.exporting.useWebFonts = false;
        chart.exporting.adapter.add("data", function(data) {
            data.data = data.data.filter(function(item) {
                return item.category !== undefined;
            });
            return data;
        });

        // Jalankan/Render grafik
        chart.legend = new am4charts.Legend();
        chart.legend.position = "center";
        chart.legend.scrollable = true;
        chart.legend.itemContainers.template.events.on("hit", function(ev) {
            var series = ev.target.dataItem.dataContext.series;
            if (!series.isHidden) {
                series.hide();
            }
            else {
                series.show();
            }
        });
    });
</script>
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countEnum1 = <?php echo $count_actv_1; ?>;
    var countEnum2 = <?php echo $count_actv_2; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart2", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Subscribe",
            "jumlah": <?php echo $count_actv_1; ?>
        }, {
            "transaksi": "Voucher",
            "jumlah": <?php echo $count_actv_2; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik dengan menentukan warna berdasarkan kategori
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Menentukan warna untuk setiap kategori
        pieSeries.colors.list = [
            am4core.color("#3366FF"),
            am4core.color("#19D0A2"),
            am4core.color("#FF5733")
        ];

        // Atur properti dan tema grafik (opsional)
        chart.paddingBottom = 30;
        chart.angle = 15;
        chart.innerRadius = am4core.percent(50);
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "chart-export";
        chart.exporting.useWebFonts = false;
        chart.exporting.adapter.add("data", function(data) {
            data.data = data.data.filter(function(item) {
                return item.category !== undefined;
            });
            return data;
        });

        // Jalankan/Render grafik
        chart.legend = new am4charts.Legend();
        chart.legend.position = "center";
        chart.legend.scrollable = true;
        chart.legend.itemContainers.template.events.on("hit", function(ev) {
            var series = ev.target.dataItem.dataContext.series;
            if (!series.isHidden) {
                series.hide();
            }
            else {
                series.show();
            }
        });
    });
</script>