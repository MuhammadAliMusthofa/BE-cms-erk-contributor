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
        <!-- <div class="card"> -->
            <!-- <div class="card-body"> -->
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-old-tab" data-toggle="tab" href="#nav-old" role="tab" aria-controls="nav-old" aria-selected="true">Data</a>
                        <a class="nav-item nav-link" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="false">Report & Activation</a>
                    </div>
                </nav>
                <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-old" role="tabpanel" aria-labelledby="nav-old-tab">
                        <div class="layout-grid mt-3">
                            <table id="flex1" style="display:none; "></table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                        <div class="row mt-3">
                            <div class="col-12 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">User Transaksi</h4>
                                        <div class="tab-cuy" id="payment-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">Total Semua Penjualan</h4>
                                                <div class="seo-fact sbg3">
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
                                </div>
                                <!-- Baris Kedua Kolom Kanan -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-center">
                                                    <h4 class="header-title">Penjualan Pertahun</h4>
                                                    <div class="trd-history-tabs">
                                                        <ul class="nav" role="tablist">
                                                            <li>
                                                                <a class="active" data-toggle="tab" href="#2024" role="tab">2024</a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="tab" href="#2023" role="tab">2023</a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="tab" href="#2022" role="tab">2022</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- <div>
                                                        <?php echo date('Y-m-d H:i:s')?>
                                                    </div> -->
                                                </div>
                                                <div class="trad-history mt-4">
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active" id="2024" role="tabpanel">
                                                            <div class="seo-fact sbg1">
                                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                                    <div class="seofct-icon"><i class="menu-icon fa fa-money"></i></div>
                                                                    <h2><?php if ($price_2024 > 0): ?>
                                                                        <?php
                                                                            $formatted_price = number_format($price_2024, 0, ',', '.');
                                                                            echo "<h2>Rp $formatted_price</h2>";
                                                                        ?>
                                                                        <?php else: ?>
                                                                            <p>No results found</p>
                                                                        <?php endif; ?>
                                                                    </h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="2023" role="tabpanel">
                                                            <div class="seo-fact sbg1">
                                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                                    <div class="seofct-icon"><i class="menu-icon fa fa-money"></i></div>
                                                                    <h2><?php if ($price2023 > 0): ?>
                                                                        <?php
                                                                            $formatted_price = number_format($price2023, 0, ',', '.');
                                                                            echo "<h2>Rp $formatted_price</h2>";
                                                                        ?>
                                                                        <?php else: ?>
                                                                            <p>No results found</p>
                                                                        <?php endif; ?>
                                                                    </h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="2022" role="tabpanel">
                                                            <div class="seo-fact sbg1">
                                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                                    <div class="seofct-icon"><i class="menu-icon fa fa-money"></i></div>
                                                                    <h2><?php if ($price2022 > 0): ?>
                                                                        <?php
                                                                            $formatted_price = number_format($price2022, 0, ',', '.');
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
                                            </div>
                                        </div>
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
                                    <!-- <a href="<?php echo base_url('payment/form/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add Payment</a> -->
                                        <div class="table-responsive mt-3">
                                            <table id="example" class="table table-sm table-hover" cellspacing="0" width="100%">
                                                <thead class="">
                                                    <tr>
                                                        <th></th>
                                                        <th>Order ID</th>
                                                        <th>Email</th>
                                                        <th>Nama</th>
                                                        <th>QTY</th>
                                                        <th>Periode</th>
                                                        <th>Transaction Status</th>
                                                        <th>Aktivasi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            <!-- </div> -->
        <!-- </div> -->
    </div>
</div>

<script>
	$(document).ready(function() {

		var table = $('#example').DataTable({
				'dom': "<'row'<'col-12 col-md-6'l><'col-12 col-md-6'<'float-md-left ml-2'B>f>>" +
					"<'row'<'col-12'tr>>" +
					"<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

				"ajax": {
					"url": "<?php echo base_url('payment/data') ?>",
					"dataSrc": ""
				},
				'buttons': [{
						'text': '<i class="fa fa-id-badge fa-fw" aria-hidden="true"></i>',
						'action': function(e, dt, node) {

							$(dt.table().node()).toggleClass('cards');
							$('.fa', node).toggleClass(['fa-table', 'fa-id-badge']);

							dt.draw('page');
						},
						'className': 'btn-sm bg-yellow border-0',
						'attr': {
							'title': 'Change views',
						}
					},
					{
						extend: 'copy',
						text: '<i class="fa fa-clone fa-fw" aria-hidden="true"></i>',
						title: '<h5 class="text-center">Data Buku</h5>',
						className: 'btn-sm bg-primary border-0',
						messageTop: ''
					},
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel fa-fw" aria-hidden="true"></i>',
						title: 'Data Buku \n ',
						className: 'btn-sm bg-success border-0',
						messageTop: ''
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="far fa-file-pdf fa-fw" aria-hidden="true"></i>',
						title: 'Data Buku \n ',
						className: 'btn-sm bg-danger border-0',
						messageTop: ''
					},
					{
						extend: 'print',
						text: '<i class="fa fa-print fa-fw" aria-hidden="true"></i>',
						title: '<h5 class="text-center">Data Buku</h5>',
						className: 'btn-sm bg-warning border-0',
						messageTop: ''
					}
				],
				'select': 'single',
				'columns': [
					{
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								data = '<a href="#" data-toggle="modal" data-target="#detailsModal_' + full.id + '"><i onclick="hapus(' + full.id + ')" class="fa fa-eye" aria-hidden="true" style="font-size: 24px; color:#D4011B;"></i></a>';
								data += generateModal(full);
							}
							return data;
						}
					},
					{
						'data': 'order_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'email',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'full_name',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'qty',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						data: 'periode',
                        render: function(data, type, row) {
                            if (data !== null) {
                                return data + ' hari';
                            } else {
                                return 'Tidak Ada Data';
                            }
                        }
					},
					{
						'data': 'transaction_status',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},

                    {
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								data = '<a href="#" data-toggle="modal" data-target="#aktivasiModal_' + full.id + '"><i onclick="hapus(' + full.id + ')" class="fa fa-edit" aria-hidden="true" style="font-size: 24px; color:#D4011B;"></i></a>';
								data += generateModalAktivasi(full);
							}
							return data;
						}
					}
				],

				'drawCallback': function(settings) {
					var api = this.api();
					var $table = $(api.table().node());

					if ($table.hasClass('cards')) {

						// Create an array of labels containing all table headers
						var labels = [];
						$('thead th', $table).each(function() {
							labels.push($(this).text());
						});

						// Add data-label attribute to each cell
						$('tbody tr', $table).each(function() {
							$(this).find('td').each(function(column) {
								$(this).attr('data-label', labels[column]);
							});
						});

						var max = 0;
						$('tbody tr', $table).each(function() {
							max = Math.max($(this).height(), max);
						}).height(max);

					} else {
						// Remove data-label attribute from each cell
						$('tbody td', $table).each(function() {
							$(this).removeAttr('data-label');
						});

						$('tbody tr', $table).each(function() {
							$(this).height('auto');
						});
					}
				}
			})
			.on('select', function(e, dt, type, indexes) {
				var rowData = table.rows(indexes).data().toArray()
				$('#row-data').html(JSON.stringify(rowData));
			})
			.on('deselect', function() {
				$('#row-data').empty();
			})
	});
</script>
<script>
	function generateModal(record) {
    return `
    <div class="modal fade" id="detailsModal_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Detail - ${record.email}</h5>
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
                                        <input type="text" class="form-control" value="${record.order_id ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Trans Status:</label>
                                        <input type="text" class="form-control" value="${record.transaction_status ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Consumer :</label>
                                        <input type="text" class="form-control" value="${record.consumer ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" value="${record.email ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>School:</label>
                                        <input type="text" class="form-control" value="${record.school ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Package :</label>
                                        <input type="text" class="form-control" value="${record.package ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>QTY:</label>
                                        <input type="text" class="form-control" value="${record.qty ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Total Amount:</label>
                                        <input type="text" class="form-control" value="${record.total_amount !== null ? 'Rp ' + new Intl.NumberFormat('id-ID').format(record.total_amount) : 'Tidak ada data'}" placeholder="Disabled input" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Payable Amount:</label>
                                        <input type="text" class="form-control" value="${record.payable_amount !== null ? 'Rp ' + new Intl.NumberFormat('id-ID').format(record.payable_amount) : 'Tidak ada data'}" placeholder="Disabled input" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Platform Type:</label>
                                        <input type="text" class="form-control" value="${record.platform !== null ? record.platform : 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Trans ID:</label>
                                        <input type="text" class="form-control" value="${record.transaction_id ?? 'Tidak ada data'}" placeholder="Disabled input">
                                    </div>
                                    <div class="form-group">
                                        <label>Trans Time:</label>
                                        <input type="text" class="form-control" value="${record.transaction_time ? new Date(record.transaction_time * 1000).toISOString().slice(0, 19).replace('T', ' ') : 'Tidak ada data'}" placeholder="Disabled input" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Settlement Time:</label>
                                        <input type="text" class="form-control" value="${record.settlement_time ? new Date(record.settlement_time * 1000).toISOString().slice(0, 19).replace('T', ' ') : 'Tidak ada data'}" placeholder="Disabled input" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Create Date:</label>
                                        <input type="text" class="form-control" value="${record.createdAt ? new Date(record.createdAt * 1000).toISOString().slice(0, 19).replace('T', ' ') : 'Tidak ada data'}" placeholder="Disabled input" readonly>
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
    </div>`;
    }
</script>
<script>
    function generateModalAktivasi(record) {
        return `
        <div class="modal fade" id="aktivasiModal_${record.id}" tabindex="-1" role="dialog" aria-labelledby="aktivasiModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aktivasiModalLabel">AKTIVASI MANUAL - ${record.email}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo base_url('payment/update_tr/${record.id}'); ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="edit_transaction_status">Transaction Status</label>
                                <select class="form-control" id="edit_transaction_status" name="edit_transaction_status">
                                    <?php if ($data_edit['edit_transaction_status'] === null) : ?>
                                        <option value="" selected><?php echo $record->transaction_status; ?></option>
                                    <?php endif; ?>
                                    <?php foreach ($transaction_status as $value) : ?>
                                        <?php if ($value == $data_edit['edit_transaction_status']) : ?>
                                            <option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
                                        <?php else : ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" name="uid" id="uid" value="${record.uid}">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" name="package_id" id="package_id" value="${record.package_id}">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" name="total_amount" id="total_amount" value="${record.total_amount}">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" name="createdAt" id="createdAt" value="${record.createdAt}">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" name="periode" id="periode" value="${record.periode}">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="date" class="form-control" name="expiredAt" id="expiredAt" value="${record.expiredAt}">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>`;
    }
</script>


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

<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

