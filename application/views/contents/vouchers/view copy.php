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
									<th>Job Generate</th>
									<th>Status Redeem</th>
									<th>Pembeli</th>
									<th>Order ID</th>
									<th>Paket</th>
									<th>Code</th>
									<th>Create Date</th>
									<th>Expired Date</th>
									<th>Di Redeem Oleh</th>
									<th>Tanggal Redeem</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($vouchers as $voucher): ?>
									<tr>
										<td>
											<a href="<?php echo base_url('vouchers/form/'.$voucher->id); ?>" ><i class="fa fa-edit" style="font-size: 24px;"></i></a>
											<a href="#" data-toggle="modal" data-target="#confirmDeleteModal">
												<i class="ti-trash" style="font-size: 24px; color:#D4011B;"></i>
											</a>
											<!-- Modal -->
											<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Apakah Anda yakin ingin menghapus?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
															<a href="<?php echo base_url('vouchers/delete/'.$voucher->id); ?>" class="btn btn-danger">Hapus</a>
														</div>
													</div>
												</div>
											</div>
										</td>
										<td><?php echo $voucher->job_id; ?></td>
										<td><?php echo $voucher->is_redeem; ?></td>
										<td><?php echo $voucher->uid; ?></td>
										<td><?php echo $voucher->payment_id; ?></td>
										<td><?php echo $voucher->package_id; ?></td>
										<td><?php echo $voucher->code; ?></td>
										<td><?php echo $voucher->createdAt; ?></td>
										<td><?php echo $voucher->expiredAt; ?></td>
										<td><?php echo $voucher->redeemedBy; ?></td>
										<td><?php echo $voucher->updatedAt; ?></td>
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
setInterval("$('#flex1').flexReload()",60000 );
</script>
<?php if($this->session->flashdata('message')){?>
	<div class="row mt-3">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="box-content">
						<div class="alert alert-<?php echo ($this->session->flashdata('err_code')=='0')? 'success':'danger'?>" role="alert">
							<?php echo $this->session->flashdata('message')?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }?>

<div class="row mt-3">
	<div class="card">
			<div class="card-body">
				<div class="box-content">
					<div class="col-sm-12 col-md-12">
					<button data-toggle="modal" id="modal_trigger" data-target="#modal_search" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
					<div class="modal fade" id="modal_search">
						<div class="modal-dialog">
							<form enctype="multipart/form-data" method="get" action="<?php echo base_url($this->utama) ?>">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Filter</h5>
										<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
									</div>
									<div class="modal-body">
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="name";?>
											<div class="col-sm-3 col-md-3">
												<label>Name</label>
											</div>
											<div class="col">
												<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="email";?>
											<div class="col-sm-3 col-md-3">
												<label>Email</label>
											</div>
											<div class="col">
												<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="phone";?>
											<div class="col-sm-3 col-md-3">
												<label>Phone</label>
											</div>
											<div class="col">
												<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="school";?>
											<div class="col-sm-3 col-md-3">
												<label>School</label>
											</div>
											<div class="col">
												<?php echo form_input($nm_f,$this->input->get($nm_f),'class="form-control" style="margin-bottom:5px;" placeholder="-'.strtoupper($nm_f).'-"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="province";?>
											<div class="col-sm-3 col-md-3">
												<label>Province</label>
											</div>
											<div class="col">
												<?php echo form_dropdown($nm_f,GetOptAll('sv_provinces','-Province-',array(),'prov_name'),$this->input->get($nm_f),'class="form-control select2" style="margin-bottom:5px;width:100%;" id="'.$nm_f.'" placeholder="-'.strtoupper($nm_f).'-" onchange="gantiprov()"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<?php $nm_f="city";?>
											<div class="col-sm-3 col-md-3">
												<label>City</label>
											</div>
											<div class="col">
												<?php echo form_dropdown($nm_f,GetOptAll('sv_cities','-City-',array('prov_id'=>'where/'.$this->input->get('province')),'city_name'),$this->input->get($nm_f),'class="form-control select2" id="'.$nm_f.'" style="margin-bottom:5px;width:100%;" placeholder="-'.strtoupper($nm_f).'-"')?>
											</div>
										</div>									
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<input type="submit" value="Search" name="search" class="btn-danger btn">
									</div>
								</div>
							</form>
						</div>
					</div>
						<button data-toggle="collapse" id="expandsearch" data-target="#demo" class="btn-info btn"><i class="fa fa-plus"></i>&nbsp;Add Filter</button>
						<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 mt-2 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="demo">
							<form enctype="multipart/form-data" method="get" action="<?php echo base_url($this->utama) ?>">
								<div class="col-sm-12 col-md-12" style="margin-top:10px">
									<div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
										<div class="row" style="margin-bottom:2%;">
											<div class="col-sm-3 col-md-3">
												<label>Kode Voucher</label>
											</div>
											<div class="col-sm-4 col-md-4">
												<?php echo form_input('code',$this->input->get('code'),'class="form-control" style="margin-bottom:5px;"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<div class="col-sm-3 col-md-3">
												<label>Email Pembeli</label>
											</div>
											<div class="col-sm-4 col-md-4">
												<?php echo form_input('email',$this->input->get('email'),'class="form-control" style="margin-bottom:5px;"')?>
											</div>
										</div>
										<div class="row" style="margin-bottom:2%;">
											<div class="col-sm-3 col-md-3">
												<label>Generate Job</label>
											</div>
											<div class="col-sm-4 col-md-4">
												<?php echo form_dropdown('job',GetOptAll('voucher_job','-All-',array(),'title','id'),$this->input->get('job'),'class="form-control select2" style="margin-bottom:5px;width:100%;"')?>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3 col-md-3">
												<label>Status</label>
											</div>
											<div class="col-sm-4 col-md-4">
												<?php echo form_dropdown('status',array(''=>'-All-','0'=>'Belum Diredeem','1'=>'Sudah Diredeem','2'=>'Void','expired'=>'Expired'),$this->input->get('status'),'class="form-control select2" style="margin-bottom:5px;width:100%;"')?>
											</div>
										</div>
									</div>
								</div>
								<?php //echo form_hidden('lastq',$lastq);?>
								<div class="col-sm-12 col-md-12" style="text-align: right;"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" class="btn-danger btn" name="search">&nbsp;<!--input type="reset" value="Clear" name="clear"--></div></div>
								<div class="col-sm-12" style="margin-top:10px"></div>
							</form>
						</fieldset>
					</div>
					<div class="row mt-3">
						<div class="col-md-12">
						<div class="layout-grid">
							<table id="flex1" style="display:none; "></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#modal_trigger').on('click', function() {
      $('#modal_search').modal('show');
    });
</script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/bootstrap.min.js"></script>