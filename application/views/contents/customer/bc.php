<style>
	.pSearch{
		display:none!important;
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
					<div class="data-tables mt-3">
						<table id="dataTable" class="text-center">
							<thead class="bg-light text-capitalize">
								<tr>
									<th></th>
									<th>Nama Lengkap</th>
									<th>Email</th>
									<th>Phone</th>
									<th>School</th>
									<th>User Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($customers as $record): ?>
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
															<h5 class="modal-title" id="detailsModalLabel">Detail - <?php echo $record->email; ?></h5>
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
																				<label>Nama Lengkap:</label>
																				<input type="text" class="form-control" value="<?php echo $record->full_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Email:</label>
																				<input type="text" class="form-control" value="<?php echo $record->email ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Phone :</label>
																				<input type="text" class="form-control" value="<?php echo $record->phone ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Birth Date  :</label>
																				<input type="text" class="form-control" value="<?php echo $record->birthdate ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>School:</label>
																				<input type="text" class="form-control" value="<?php echo $record->school ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Alamat :</label>
																				<textarea class="form-control"><?php echo $record->address ?? 'Tidak ada data'; ?></textarea>
																			</div>
																		</div>
																		<div class="col">																			
																			<div class="form-group">
																				<label>Kota:</label>
																				<input type="text" class="form-control" value="<?php echo $record->city_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Provinsi:</label>
																				<input type="text" class="form-control" value="<?php echo $record->prov_name ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Negara:</label>
																				<input type="text" class="form-control" value="<?php echo $record->country ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Kode Pos:</label>
																				<input type="text" class="form-control" value="<?php echo $record->zip_code ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>User Type:</label>
																				<input type="text" class="form-control" value="<?php echo $record->title_id ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
																			</div>
																			<div class="form-group">
																				<label>Created Date :</label>
																				<input type="text" class="form-control" value="<?php echo $record->createdAt ?? 'Tidak ada data'; ?>" placeholder="Disabled input">
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
										<td><?php echo $record->full_name; ?></td>
										<td><?php echo $record->email; ?></td>
										<td><?php echo $record->phone; ?></td>
										<td><?php echo $record->school; ?></td>
										<td><?php echo $record->title_id; ?></td>

										<td>
											<a href="<?php echo base_url('users/deletec/' . $record->id) .'/id'; ?>" class="btn btn-xs btn-outline-success">
												<i class="ti ti-trash"></i> Delete
											</a>

											<a href="#" data-toggle="modal" data-target="#modalgenerated" class="btn btn-xs btn-outline-danger">
												<i class="fa fa-remove"></i> Reset Password
											</a>
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



<div class="modal" id="modalgenerated" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Password User</h5>
      </div>
      <div class="modal-body">
		<div class="col-md-12">
        <a id="linkforgot" target="_blank">Click Here To Reset Password</a>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="dismissmodal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
 echo $js_grid; ?>
<script type="text/javascript">
	 $(document).ready(function(e){
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
	if(com=='auth'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
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
    	
   				 $('.res').html('');
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					itemlist+=$('td:nth-child('+ (1+$.inArray('email',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/resetemail");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						
						var balik=JSON.parse(data);
						if(balik.response.code==200){
							$('#linkforgot').attr('href',balik.response.link);
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
	if (com=='delete')
    {
           if($('.trSelected',grid).length>0){
			   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
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
	if(com=='export'){
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
 		 window.location = _base_url + controller + 'export/?name=<?php echo $this->input->get('name')?>&email=<?php echo $this->input->get('email')?>&phone=<?php echo $this->input->get('phone')?>&school=<?php echo $this->input->get('school')?>&province=<?php echo $this->input->get('province')?>&city=<?php echo $this->input->get('city')?>';
			
	}           
}
function dismissmodal(){
	
	$('#linkforgot').attr('href','#');
	$('#modalgenerated').hide();
}
setInterval("$('#flex1').flexReload()",50000 );
</script>

<script>
	function gantiprov(){
		var prov=$('#province').val();
		if(prov){
			$('#city').empty();
			$.post('<?php echo base_url()?>customer/load_city',{p:prov},function(e){
			var data = {
				id: '',
				text: '-City-'
			};
			
			var newOption = new Option(data.text, data.id, false, false);
			$('#city').append(newOption).trigger('change');
			obj=JSON.parse(e);
			for (var i = 0; i < obj.length; i++) {
				var user = obj[i];
				var data = {
					id: user.id,
					text: user.city_name
				};
			
					var newOption = new Option(data.text, data.id, false, false);
					$('#city').append(newOption).trigger('change');
			}

			})
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