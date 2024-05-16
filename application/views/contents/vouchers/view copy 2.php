<style>
	.pSearch{
		display:none!important;
	}
	.trans{
	background: transparent;
	color: black;
	/*top: 40vh;*/
	position: relative;
	border: 0px solid #FFF;
	display: inline-block;
	}
	.card {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
		}
</style>

<?php
 echo $js_grid; ?>
<script type="text/javascript"> 
$(document).ready(function(e){
		$('.pSearch').hide();
	  <?php 
	 if($this->input->get('search')){
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
	
	if(com=='print'){
		if($('.trSelected',grid).length==1){ 
			
			if(confirm('Yakin Akan Mencetak Voucher Ini? Note : Setelah Dicetak, Paket Voucher Tidak Dapat Diganti ')){
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
 		 window.location = _base_url + controller + 'print/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
				}
			} else {
				return false;
			} 
	}
	if(com=='edit'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
 		 window.location = _base_url + controller + 'form/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			} else {
				return false;
			} 
	}
	if (com=='delete')
    {
           if($('.trSelected',grid).length==1){
			   if(confirm('Yakin Menghapus Item Ini? Note : Jika label ini memiliki child, Maka Akan Terhapus Juga ')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
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
	if (com=='void')
    {
           if($('.trSelected',grid).length==1){
			   if(confirm('Yakin Membatalkan Item Ini?')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					itemlist+=$('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/void");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						if(data=='ok'){
							alert('Sukses!');}
						else if(data=='redeemed'){
							alert('Voucher Sudah Diredeem, Tidak Dapat Divoid!');
						}
						else{
							alert('Failed to Void Data');
						}
					   }
					});
				}
			} else {
				return false;
			} 
      }   
	  if (com=='unvoid')
    {
           if($('.trSelected',grid).length==1){
			   if(confirm('Yakin Membuka Item Ini?')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					itemlist+=$('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/unvoid");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						if(data=='ok'){
							alert('Sukses!');}
						else if(data=='redeemed'){
							alert('Voucher Sudah Diredeem, Tidak Dapat Diunvoid!');
						}
						else{
							alert('Failed to Void Data');
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
 		 window.location = _base_url + controller + 'export/?code=<?php echo $this->input->get('code')?>&email=<?php echo $this->input->get('email')?>&job=<?php echo $this->input->get('job')?>&status=<?php echo $this->input->get('status')?>';
			
	}     
	                    
}
$('.codes').mousedown(function(event) {
if(event.which == 3){
    var THIS = $(this);
    THIS.focus();
    THIS.select();
  }
});
</script>

<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="box-content">
					<a href="<?php echo base_url('vouchers/form/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add vouchers</a>
					<div class="data-tables mt-3">
						<table id="dataTable" class="text-center">
							<thead class="bg-light text-capitalize">
								<tr>
									<th></th>
									<th>Paket</th>
									<th>Order ID</th>
									<th>Code</th>
									<th>Job Generate</th>
									<th>Status Redeem</th>
									<th>Action</th>
								</tr>
							</thead>
							<!-- <tbody>
								<?php foreach ($vouchers as $record): ?>
									<tr>
										<td>
											<a href="#" data-toggle="modal" data-target="#detailsModal_<?php echo $record->id; ?>">
												<i class="fa fa-eye" style="font-size: 24px; color:#D4011B;"></i>
											</a>
											<div class="modal fade" id="detailsModal_<?php echo $record->id; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="detailsModalLabel">Detail - <?php echo $record->title; ?></h5>
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
																				<label>Job Generate :</label>
																				<input type="text" class="form-control" value="<?php echo $record->title ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Status Redeem:</label>
																				<input type="text" class="form-control" value="<?php echo ($record->is_redeem == 1) ? 'Sudah Redeem' : 'Belum Redeem'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Pembeli :</label>
																				<input type="text" class="form-control" value="<?php echo $record->email ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Order ID:</label>
																				<input type="text" class="form-control" value="<?php echo $record->order_id ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Paket :</label>
																				<input type="text" class="form-control" value="<?php echo $record->package_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																		</div>
																		<div class="col">
																			<div class="form-group">
																				<label>Code:</label>
																				<input type="text" class="form-control" value="<?php echo $record->code ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Create Date :</label>
																				<input type="text" class="form-control" value="<?php echo $record->createdAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Expired Date :</label>
																				<input type="text" class="form-control" value="<?php echo $record->expiredAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Di Redeem Oleh :</label>
																				<input type="text" class="form-control" value="<?php echo $record->full_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Tanggal Redeem :</label>
																				<input type="text" class="form-control" value="<?php echo $record->updatedAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
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
										<td><?php echo $record->package_name; ?></td>
										<td><?php echo $record->order_id; ?></td>
										<td><?php echo $record->code; ?></td>
										<td><?php echo $record->title; ?></td>
										<td><?php echo ($record->is_redeem == 1) ? 'Sudah Redeem' : 'Belum Redeem'; ?></td>
										<td>
											<a href="<?php echo base_url('vouchers/void/' . $record->id); ?>" class="btn btn-xs btn-outline-success">
												<i class="fa fa-check"></i> Void
											</a>

											<a href="<?php echo base_url('vouchers/unvoid/' . $record->id . '/id'); ?>" class="btn btn-xs btn-outline-danger">
												<i class="fa fa-remove"></i> Unvoid
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody> -->
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
    $('#myTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('vouchers/getListVoucherAjax'); ?>",
            "type": "POST" // Atur metode sesuai dengan kebutuhan Anda
            // Jika menggunakan POST, pastikan endpoint server Anda menerima metode POST
        },
        // Konfigurasikan kolom tabel sesuai dengan respons dari server
        "columns": [
            { "data": "detailColumn", "orderable": false }, // Kolom untuk detail atau aksi
            { "data": "package_name" }, // Kolom lainnya
            { "data": "order_id" },
            { "data": "code" },
            { "data": "($record->is_redeem == 1) ? 'Sudah Redeem' : 'Belum Redeem'; ?>" },
            // Kolom lainnya
        ]
    });
});

</script>

<script>
	$('#modal_trigger').on('click', function() {
      $('#modal_search').modal('show');
    });
</script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/bootstrap.min.js"></script>
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

