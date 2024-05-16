<style>
.tab-cuy {
    width: 100%;
    height: 350px;
    max-width: 100%
}
.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
<?php
//error_reporting(0);
echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
$(document).ready(function(){
    
    $('.select2').select2();
    
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight:true
    });
    <?php 
    if($this->input->get('period_start') || $this->input->get('period_end') || $this->input->get('method') || $this->input->get('consumer')){
        ?>
        $('#expandsearch').click();
    <?php }
    ?>
});

var _base_url = '<?php echo  base_url() ?>';
var controller = '<?php echo $this->utama?>/';
function del(id) { 
i = confirm('Hapus : ' + id + ' ?');
if (i) {
    window.location = _base_url + controller + 'delete/' + id;
}
}
//$('.flex1').flexigrid({height:'auto',width:'auto',striped:false});

function edit(id) {
window.location = _base_url + controller + 'input/' + id;
}

function detail(id) {
window.location = _base_url + controller + 'form/' + id;
}
function btn(com,grid)
{
    if (com == 'add' ) {
        window.location = _base_url + controller + 'form/';
    }
    
    if (com == 'select' )
    {
        $('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com == 'deselect')
    {
        $('.bDiv tbody tr',grid).removeClass('trSelected');
    }
    if(com=='edit'){
        if($('.trSelected',grid).length==1){ 
                var abbr = [];
                    $('.hDiv th', flex).each( function(index){
                abbr[index] = $(this).attr('abbr');
                });
        //var items = $('.trSelected',grid);
        window.location = _base_url + controller + 'form/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
            } else {
                return false;
            } 
    }if(com=='auth'){
        if($('.trSelected',grid).length==1){ 
                var abbr = [];
                    $('.hDiv th', flex).each( function(index){
                abbr[index] = $(this).attr('abbr');
                });
        //var items = $('.trSelected',grid);
        window.location = _base_url + controller + 'auth/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
            } else {
                return false;
            } 
    }
    if(com=='export'){
                var abbr = [];
                    $('.hDiv th', flex).each( function(index){
                abbr[index] = $(this).attr('abbr');
                });
        //var items = $('.trSelected',grid);
        window.location = _base_url + controller + 'export/?consumer=<?php echo $this->input->get('consumer')?>&method=<?php echo $this->input->get('method')?>&periode_start=<?php echo $this->input->get('periode_start')?>&periode_end=<?php echo $this->input->get('periode_end')?>';
            
    }
    if (com=='delete')
    {
        if($('.trSelected',grid).length>0){
            if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
                var flex = $(grid).closest('.flexigrid');
                var abbr = [];
                    $('.hDiv th', flex).each( function(index){
                abbr[index] = $(this).attr('abbr');
                });
        
                $('.res').html('');//div.res - area for display result
                    var items = $('.trSelected',grid);
                    var itemlist ='';
                    for(i=0;i<items.length;i++){
                    //itemlist+=items[i].id+",";
                    //var iteming=$('td:"no_reg" >div', items[i]).text();
                    itemlist+=$('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', items[i]).text()+",";
                    }
                        
                    $.ajax({
                    type: "POST",
                    url: "<?php echo site_url($this->utama."/deletec");?>",
                    data: "items="+itemlist,
                    success: function(data){
                        $('#flex1').flexReload();
                        //alert(data);
                        if(data=='ok'){
                        alert('Sukses!');}
                        else{
                            alert('Failed to Delete Data');
                        }
                    }
                    });
                }
            } else {
                return false;
            } 
    }           
}
setInterval("$('#flex1').flexReload()",50000 );
</script>
<script>
    // Menjalankan kode saat tautan di-klik
document.getElementById('exportLink').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah tindakan default dari tautan

    var abbr = [];
    $('.hDiv th', flex).each(function(index) {
        abbr[index] = $(this).attr('abbr');
    });

    var base_url = "_base_url"; // Ganti dengan nilai yang sesuai
    var controller = "controller"; // Ganti dengan nilai yang sesuai

    // Mengonstruksi URL sesuai dengan data yang diperlukan
    var exportUrl = base_url + controller + 'export/?consumer=<?php echo $this->input->get("consumer") ?>&method=<?php echo $this->input->get("method") ?>&periode_start=<?php echo $this->input->get("periode_start") ?>&periode_end=<?php echo $this->input->get("periode_end") ?>';

    // Mengarahkan ke URL yang telah dikonstruksi
    window.location.href = exportUrl;
});

</script>
<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">User Transaksi</h4>
				<div class="tab-cuy" id="payment-chart"></div>
			</div>
		</div>
	</div>
		
</div>
<div class="row mt-5">
	<div class="col-sm-5 ">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Type Platform</h4>
				<div id="ampiechart1"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Status Transaksi</h4>
				<div id="ampiechart2"></div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datatables</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">All Data</a>
                    </div>
                </nav>
                <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <!-- <div class="card"> -->
                            <!-- <div class="card-body"> -->
                            <h4 class="header-title">Data Semua Transaksi</h4>
                            <button onclick="btn('export')" class="btn-success btn"><i class="fa fa-print"></i> &nbsp;Eksport</button>
                                <div class="box-content">
                                    <div class="data-tables mt-3">
                                        <table id="dataTable" class="text-center">
                                            <thead class="bg-light text-capitalize">
                                                <tr>
                                                    <th></th>
                                                    <th>Order ID</th>
                                                    <th>Email</th>
                                                    <th>Nama</th>
                                                    <th>QTY</th>
                                                    <th>Total Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($payments as $record): ?>
                                                <tr>
                                                    <td>
                                                        <!-- Create unique modal IDs for each record -->
                                                        <a href="#" data-toggle="modal" data-target="#detailsModal_<?php echo $record->order_id; ?>">
                                                            <i class="fa fa-eye" style="font-size: 24px; color:#D4011B;"></i>
                                                        </a>
                                                        <!-- Modal for each record -->
                                                        <div class="modal fade" id="detailsModal_<?php echo $record->order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="detailsModalLabel">Detail - <?php echo $record->order_id; ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <form>
                                                                            <fieldset disabled>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="form-group">
                                                                                            <label>Order ID:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->order_id ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Trans Status:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->transaction_status ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Consumer :</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->consumer ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Email:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->email ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>School:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->school ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Package :</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->package ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>QTY:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->qty ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="form-group">
                                                                                            <label>Total Amount:</label>
                                                                                            <?php
                                                                                            $totalAmount = $record->total_amount ?? null;
                                                                                            $formattedTotalAmount = ($totalAmount !== null) ? 'Rp ' . number_format($totalAmount, 0, ',', '.') : 'Tidak ada data';
                                                                                            ?>
                                                                                            <input type="text" class="form-control" value="<?php echo $formattedTotalAmount; ?>" placeholder="Disabled input" readonly>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Payable Amount:</label>
                                                                                            <?php
                                                                                            $payableAmount = $record->payable_amount ?? null;
                                                                                            $formattedPayableAmount = ($payableAmount !== null) ? 'Rp ' . number_format($payableAmount, 0, ',', '.') : 'Tidak ada data';
                                                                                            ?>
                                                                                            <input type="text" class="form-control" value="<?php echo $formattedPayableAmount; ?>" placeholder="Disabled input" readonly>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Platform Type:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->platform ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Trans ID:</label>
                                                                                            <input type="text" class="form-control" value="<?php echo $record->transaction_id ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Trans Time:</label>
                                                                                            <?php
                                                                                            $timestamp = $record->transaction_time; 
                                                                                            $dateTime = date('Y-m-d H:i:s', $timestamp);
                                                                                            ?>
                                                                                            <input type="text" class="form-control" value="<?php echo $dateTime; ?>" placeholder="Disabled input" readonly>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Settlement Time:</label>
                                                                                            <?php
                                                                                            $timestamp = $record->settlement_time; 
                                                                                            $dateTime = date('Y-m-d H:i:s', $timestamp);
                                                                                            ?>
                                                                                            <input type="text" class="form-control" value="<?php echo $dateTime; ?>" placeholder="Disabled input" readonly>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Create Date:</label>
                                                                                            <?php
                                                                                            $timestamp = $record->createdAt; 
                                                                                            $dateTime = date('Y-m-d H:i:s', $timestamp);
                                                                                            ?>
                                                                                            <input type="text" class="form-control" value="<?php echo $dateTime; ?>" placeholder="Disabled input" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $record->order_id; ?></td>
                                                    <td><?php echo $record->email; ?></td>
                                                    <td><?php echo $record->full_name; ?></td>
                                                    <td><?php echo $record->qty; ?></td>
                                                    <td><?php echo $record->total_amount; ?></td>
                                                    <td><?php echo $record->transaction_status; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- <div class="card"> -->
                            <!-- <div class="card-body"> -->
                                <h4 class="header-title">Data Semua Transaksi</h4>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
                                        <fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">
                                            <form enctype="multipart/form-data" method="get" action="<?php echo base_url() ?>payment">
                                                <div class="col-sm-12 col-md-12" style="margin-top:10px">
                                                    <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                                                        <div class="row" style="margin-bottom:2%;">
                                                            <div class="col-sm-3 col-md-3">
                                                                <label>Consumer</label>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <?php echo form_dropdown('consumer',array(''=>'-All-','retail'=>'Retail','school'=>'School'),$this->input->get('consumer'),'class="select2" style="margin-bottom:5px;width:100%;"')?>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-bottom:2%;">
                                                            <div class="col-sm-3 col-md-3">
                                                                <label>Platform</label>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <?php echo form_dropdown('method',array(''=>'-All-','midtrans'=>'Midtrans','other'=>'Other'),$this->input->get('method'),'class="select2" style="margin-bottom:5px;width:100%;"')?>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-bottom:2%;">
                                                            <div class="col-sm-3 col-md-3">
                                                                <label>Periode</label>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <?php echo form_input('periode_start',$this->input->get('periode_start'),' style="margin-bottom:5px;" class="form-control datepicker" placeholder="Start"')?>
                                                                <?php echo form_input('periode_end',$this->input->get('periode_end'),' style="margin-bottom:5px;" class="form-control datepicker"  placeholder="End"')?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php //echo form_hidden('lastq',$lastq);?>
                                                <div class="col-sm-12 col-md-12"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" name="search" class="btn-danger btn">&nbsp;<!--input type="reset" value="Clear" name="clear"--></div></div>
                                                <div class="col-sm-12" style="margin-top:10px"></div>
                                            </form>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="layout-grid mt-3">
                                    <table id="flex1" style="display:none; "></table>
                                </div>
                            <!-- </div> -->
                        <!-- </div>       -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.pSearch{
		display:none!important;
	}
</style>



<div class="row mt-5">
    <div class="col">


<!-- line chart  -->
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
    var countApple = <?php echo $count_apple; ?>;
    var countMidtrans = <?php echo $count_midtrans; ?>;
    var countGoogle = <?php echo $count_google; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart1", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Apple",
            "jumlah": <?php echo $count_apple; ?>
        }, {
            "transaksi": "Midtrans",
            "jumlah": <?php echo $count_midtrans; ?>
        }, {
            "transaksi": "Google",
            "jumlah": <?php echo $count_google; ?>
        }];
        // chart.data = chartDataUsers;

        // Atur properti grafik dengan menentukan warna berdasarkan kategori
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "jumlah";
        pieSeries.dataFields.category = "transaksi";

        // Menentukan warna untuk setiap kategori
        pieSeries.colors.list = [
            am4core.color("#3366FF"), // Warna untuk kategori "Apple"
            am4core.color("#FF5733"), // Warna untuk kategori "Midtrans"
            am4core.color("#33FF57")  // Warna untuk kategori "Google"
            // Tambahkan warna lain jika diperlukan
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
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countpending = <?php echo $count_pending; ?>;
    var countsettlement = <?php echo $count_settlement; ?>;
    var countcapture = <?php echo $count_capture; ?>;
    var countexpired = <?php echo $count_expired; ?>;
    var countcancel = <?php echo $count_cancel; ?>;
    var countdeny = <?php echo $count_deny; ?>;
    var countrefund = <?php echo $count_refund; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart2", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "pending",
            "jumlah": <?php echo $count_pending; ?>
        }, {
            "transaksi": "settlementr",
            "jumlah": <?php echo $count_settlement; ?>
        }, {
        }, {
            "transaksi": "capture",
            "jumlah": <?php echo $count_capture; ?>
        }, {
        }, {
            "transaksi": "expired",
            "jumlah": <?php echo $count_expired; ?>
        }, {
        }, {
            "transaksi": "cancel",
            "jumlah": <?php echo $count_cancel; ?>
        }, {
        }, {
            "transaksi": "deny",
            "jumlah": <?php echo $count_deny; ?>
        }, {
        }, {
            "transaksi": "refund",
            "jumlah": <?php echo $count_refund; ?>
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

<!-- all bar chart -->
<script src="<?php echo base_url('assets')?>/srtdash/assets/js/bar-chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>


<!-- Start datatable js -->
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/bootstrap.min.js"></script>
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


<script src="<?php echo base_url('assets')?>/assets/js/plugins.js"></script>
    <script src="<?php echo base_url('assets')?>/assets/js/scripts.js"></script>
