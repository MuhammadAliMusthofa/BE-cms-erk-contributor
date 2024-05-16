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
				<div class="table-responsive">
					<table id="example" class="table table-sm table-hover" cellspacing="0" width="100%">
						<thead class="">
							<tr>
								<th></th>
								<th>Nama Lengkap</th>
								<th>Email</th>
								<th>Phone</th>
								<th>School</th>
								<th>User Type</th>
								
							</tr>
						</thead>
					</table>
				</div>
			</div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {

		var table = $('#example').DataTable({
				// 'dom': "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-left ml-2'B>f>>" +
				// 	"<'row'<'col-sm-12'tr>>" +
				// 	"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				'dom': "<'row'<'col-12 col-md-6'l><'col-12 col-md-6'<'float-md-left ml-2'B>f>>" +
					"<'row'<'col-12'tr>>" +
					"<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

				"ajax": {
					"url": "<?php echo base_url('customer/data') ?>",
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
						'data': 'full_name',
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
						'data': 'phone',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'school',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'title_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
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
										<label>Nama Lengkap:</label>
										<input type="text" class="form-control" value="${record.full_name !== null ? record.full_name : 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Email:</label>
										<input type="text" class="form-control" value="${record.email !== null ? record.email : 'Tidak ada data'}"" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Phone :</label>
										<input type="text" class="form-control" value="${record.phone !== null ? record.phone : 'Tidak ada data'}"" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Birth Date  :</label>
										<input type="text" class="form-control" value="${record.birthdate !== null ? record.birthdate : 'Tidak ada data'}"" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>School:</label>
										<input type="text" class="form-control" value="${record.school !== null ? record.school : 'Tidak ada data'}"" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Alamat :</label>
										<textarea class="form-control">${record.address !== null ? record.address : 'Tidak ada data'}</textarea>
									</div>
								</div>
								<div class="col">																			
									<div class="form-group">
										<label>Kota:</label>
										<input type="text" class="form-control" value="${record.city_name !== null ? record.city_name : 'Tidak ada data'}"" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Provinsi:</label>
										<input type="text" class="form-control" value="${record.prov_name !== null ? record.prov_name : 'Tidak ada data'}"placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Negara:</label>
										<input type="text" class="form-control" value="${record.country !== null ? record.country : 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Kode Pos:</label>
										<input type="text" class="form-control" value="${record.zip_code !== null ? record.zip_code : 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>User Type:</label>
										<input type="text" class="form-control" value="${record.title_id !== null ? record.title_id : 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Created Date :</label>
										<input type="text" class="form-control" value="${record.createdAt !== null ? record.createdAt : 'Tidak ada data'}" placeholder="Disabled input">
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
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url('assets')?>/assets/srtdash/assets/js/bootstrap.min.js"></script>
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>