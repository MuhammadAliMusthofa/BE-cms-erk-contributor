<style>
	.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>

<?php
 echo $js_grid; ?>
<script type="text/javascript">
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
			   if(confirm('Yakin Menghapus Item Ini? Note : Jika voucher telah tergenerate, Maka Akan Terhapus Juga ')){
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
						else if(data=='printed'){
							alert('Voucher Sudah Dicetak, Tidak Dapat Dihapus!');
						}
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
			   if(confirm('Yakin Membatalkan Item Ini? Note : Jika voucher telah tergenerate, Maka Akan Dibatalkan Juga ')){
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
						else if(data=='printed'){
							alert('Voucher Sudah Dicetak, Tidak Dapat Dihapus!');
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
			   if(confirm('Yakin Membuka Item Ini? Note : Jika voucher telah tergenerate, Maka Akan Dibuka Juga ')){
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
					   url: "<?php echo site_url($this->utama."/unvoid");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						if(data=='ok'){
							alert('Sukses!');}
						else if(data=='printed'){
							alert('Voucher Sudah Dicetak, Tidak Dapat Dihapus!');
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
}
setInterval("$('#flex1').flexReload()",5000 );
</script>

<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
            <h4 class="header-title">Data Job Generate Vouchers</h4>
            <!-- <button onclick="btn('export')" class="btn-success btn"><i class="fa fa-print"></i> &nbsp;Eksport</button> -->
                <div class="box-content">
                    <div class="data-tables mt-3">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th></th>
                                    <th>Job status</th>
                                    <th>Job Name</th>
                                    <th>Kode Axapta</th>
                                    <th>Created Date</th>
                                    <th>Expired Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($job_gen as $record): ?>
                                <tr>
                                    <td>
                                        <!-- Create unique modal IDs for each record -->
                                        <a href="#" data-toggle="modal" data-target="#detailsModal_<?php echo $record->id; ?>">
                                            <i class="fa fa-eye" style="font-size: 24px; color:#D4011B;"></i>
										</a>
										<!-- Modal for each record -->
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
                                                                            <label>Job Status :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->job_status ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Job Name:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->title ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Package :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->package_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Kode Produk AX:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->package_ax ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
																			<label>Price :</label>
																			<?php
																			$setPrice = $record->price ?? null;
																			$formattedSetPrice = ($setPrice !== null) ? 'Rp ' . number_format($setPrice, 0, ',', '.') : 'Tidak ada data';
																			?>
																			<input type="text" class="form-control" value="<?php echo $formattedSetPrice; ?>" placeholder="Disabled input" readonly>
																		</div>
                                                                       <div class="form-group">
                                                                            <label>Periode :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->periode ?? 'Tidak ada data'; ?> Hari" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Jumlah Voucher :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->jumlah ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Create Date:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->createdAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Expired Date:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->expiredAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Talah Dicetak? :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->printed ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Dibatalkan?:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->is_void ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Created By :</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Modify By:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->modifyBy ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Modify Date:</label>
                                                                            <input type="text" class="form-control" value="<?php echo $record->modifyAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
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
                                    <td><?php echo $record->job_status; ?></td>
                                    <td><?php echo $record->title; ?></td>
                                    <td><?php echo $record->package_ax; ?></td>
                                    <td><?php echo $record->createdAt; ?></td>
                                    <td><?php echo $record->expiredAt; ?></td>
                                    <td>
										<a href="<?php echo base_url('voucher/form/' . $record->id); ?>" class="btn btn-xs btn-outline-info">
											<i class="fa fa-edit"></i> Edit
										</a>
										<a href="#" data-toggle="modal" data-target="#confirmDeleteModal" class="btn btn-xs btn-outline-danger">
											<i class="ti-trash"></i> Hapus
										</a>
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
														<p>Apakah Anda yakin ingin menghapus?</p>
														<p>Data - <?php echo $record->title ?></p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
														<a href="<?php echo base_url('voucher/delete/'.$record->id); ?>" class="btn btn-danger">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<a href="<?php echo base_url('voucher/void/' . $record->id); ?>" class="btn btn-xs btn-outline-success">
											<i class="fa fa-check"></i> Void
										</a>

										<a href="<?php echo base_url('voucher/unvoid/' . $record->id . '/id'); ?>" class="btn btn-xs btn-outline-danger">
											<i class="fa fa-remove"></i> Unvoid
										</a>

										<a href="#" data-toggle="modal" data-target="#confirmPrintModal_<?php echo $record->id; ?>" class="btn btn-xs btn-outline-secondary ">
											<i class="fa fa-print"></i> Print
										</a>

										<div class="modal fade" id="confirmPrintModal_<?php echo $record->id; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmPrintModalLabel_<?php echo $record->id; ?>" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="confirmPrintModalLabel">Konfirmasi Print</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<p>Yakin Akan Mencetak Voucher Ini?</p>
														<p><?php echo $record->title; ?></p>
														<br>
														<p>Note: Setelah Dicetak, Paket Voucher Tidak Dapat Diganti</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
														<a href="<?php echo base_url('voucher/print/' . $record->id); ?>" class="btn btn-danger">Print</a>
													</div>
												</div>
											</div>
										</div>
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


<script>
  function checkAndPrint() {
    var com = 'print';

    if (com == 'print') {
      if ($('.trSelected', grid).length == 1) {
        if (confirm('Yakin Akan Mencetak Voucher Ini? Note : Setelah Dicetak, Paket Voucher Tidak Dapat Diganti ')) {
          var abbr = [];
          $('.hDiv th', flex).each(function(index) {
            abbr[index] = $(this).attr('abbr');
          });
          window.location = _base_url + controller + 'print/' + $('td:nth-child(' + (1 + $.inArray('idnya', abbr)) + ')>div', '.trSelected', grid).text();
        }
      } else {
        return false;
      }
    }
  }
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