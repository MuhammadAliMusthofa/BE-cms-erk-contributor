<style>
.pSearch{
		display:none!important;
	}

.card {
box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
	}
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
<?php
//error_reporting(0);
 echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
$(document).ready(function(e){
         $('.select2').select2();
	  <?php 
	 if($this->input->get('search')){
		?>
		$('#expandsearch').click();
	 <?php }
	  ?>

	$('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         todayHighlight:true
      });
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
	}
	if(com=='auth'){
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
	if(com=='reset password'){
		if($('.trSelected',grid).length>0){
			   if(confirm('Generate Link Reset Password?')){
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
					itemlist+=$('td:nth-child('+ (1+$.inArray('email',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/resetemail");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						
						var balik=JSON.parse(data);
						if(balik.response.code==200){
							$('#linkforgot').attr('href',balik.response.link);
							//$('#linkforgot').text(balik.response.link);
							$('#modalgenerated').show();
						}else{
							alert('ERROR '+balik.response.code+'\n '+balik.response.message);
						}
					   }
					});
				}
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
 		 window.location = _base_url + controller + 'export/?email=<?php echo $this->input->get('email')?>&package=<?php echo $this->input->get('package')?>&status=<?php echo $this->input->get('status')?>&periode_start=<?php echo $this->input->get('periode_start')?>&periode_end=<?php echo $this->input->get('periode_end')?>';
			
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
function dismissmodal(){
	
	$('#linkforgot').attr('href','#');
	$('#modalgenerated').hide();
}
setInterval("$('#flex1').flexReload()",50000 );
</script>

<div class="row mt-3">
	<div class="col-sm-5">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Type Activation</h4>
				<div id="ampiechart1"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-7 ">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Top 5 Package</h4>
				<div id="ampiechart2"></div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
            <h4 class="header-title">Data User Package</h4>
            <button onclick="btn('export')" class="btn-success btn"><i class="fa fa-print"></i> &nbsp;Eksport</button>
                <div class="box-content">
                    <div class="data-tables mt-3">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>School</th>
                                    <th>Paket</th>
                                    <th>Price</th>
                                    <th>Mulai Langganan</th>
                                    <th>Expired Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($u_package as $record): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $record->full_name; ?></td>
                                    <td><?php echo $record->email; ?></td>
                                    <td><?php echo $record->name; ?></td>
                                    <td><?php echo 'Rp ' . number_format($record->price, 0, ',', '.'); ?></td>
                                    <td><?php echo $record->activation; ?></td>
                                    <td>
                                        <?php
                                        $timestamp = $record->createdAt; 
                                        $formattedDateTime = ($timestamp !== null) ? date('Y-m-d H:i:s', $timestamp) : 'Tidak ada data';
                                        ?>
                                        <?php echo $formattedDateTime; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $timestamp = $record->expiredAt; 
                                        $formattedDateTime = ($timestamp !== null) ? date('Y-m-d H:i:s', $timestamp) : 'Tidak ada data';
                                        ?>
                                        <?php echo $formattedDateTime; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- pie chart  -->
<script>
    // Gunakan data PHP yang didapat ke dalam script JavaScript
    var countEnum1 = <?php echo $count_actv_1; ?>;
    var countEnum2 = <?php echo $count_actv_2; ?>;

    // Buat grafik menggunakan AmCharts
    am4core.ready(function() {
        var chart = am4core.create("ampiechart1", am4charts.PieChart);

        // Atur data grafik
        chart.data = [{
            "transaksi": "Subscribe",
            "jumlah": <?php echo $count_actv_1; ?>
        }, {
            "transaksi": "Voucher",
            "jumlah": <?php echo $count_actv_2; ?>
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

<!-- Start datatable js -->
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/bootstrap.min.js"></script>
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
