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
	.marquee-container {
    width: 100%;
    overflow: hidden;
	}

	.marquee {
		white-space: nowrap;
		animation: marquee-scroll 20s linear infinite;
	}

	@keyframes marquee-scroll {
		0% { transform: translateX(100%); }
		100% { transform: translateX(-100%); }
	}
</style>

<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">All Voucher</a>
						<a class="nav-item nav-link" id="nav-approaching-tab" data-toggle="tab" href="#nav-approaching" role="tab" aria-controls="nav-approaching" aria-selected="false">Approaching Expired Voucher  <span class="badge badge-danger"><?php echo $expiredCount; ?></span></a>
					</div>
				</nav>
				<div class="tab-content mt-3" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
						<div class="table-responsive mt-3">
							<table id="all" class="table table-sm table-hover" cellspacing="0" width="100%">
								<thead class="">
									<tr>
										<th></th>
										<th style="width: auto;">Paket</th>
										<th>Order ID</th>
										<th>Code</th>
										<th>Job Generate</th>
										<th>Status Redeem</th>
										<th>Expired Date</th>
										<th>Status Exp</th>
										<th>Masa</th>
										<th></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="nav-approaching" role="tabpanel" aria-labelledby="nav-approaching-tab">
						<div class="marquee-container">
							<div class="marquee">
								<b><i>Data ini adalah voucher yang akan kadaluarsa untuk 3 hari ke depan</i></b>
							</div>
						</div>
						<div class="table-responsive mt-3">
							<table id="approaching" class="table table-sm table-hover" cellspacing="0" width="100%">
								<thead class="">
									<tr>
										<th></th>
										<th style="width: auto;">Paket</th>
										<th>Order ID</th>
										<th>Code</th>
										<th>Job Generate</th>
										<th>Status Redeem</th>
										<th>Expired Date</th>
										<th>Status Exp</th>
										<th>Masa</th>
										<th></th>
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

<!-- <div class="row mt-3">
    <div class="col">
        <div class="card">
			<div class="card-body">
			<a href="<?php echo base_url('vouchers/form/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add vouchers</a>
				<div class="table-responsive mt-3">
					<table id="example" class="table table-sm table-hover" cellspacing="0" width="100%">
						<thead class="">
							<tr>
								<th></th>
								<th style="width: auto;">Paket</th>
								<th>Order ID</th>
								<th>Code</th>
								<th>Job Generate</th>
								<th>Status Redeem</th>
								<th>Expired Date</th>
								<th>Status Exp</th>
								<th>Masa</th>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
        </div>
    </div>
</div> -->
<script>
	$(document).ready(function() {

		var table = $('#all').DataTable({
				'dom': "<'row'<'col-12 col-md-6'l><'col-12 col-md-6'<'float-md-left ml-2'B>f>>" +
					"<'row'<'col-12'tr>>" +
					"<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",


				"ajax": {
					"url": "<?php echo base_url('vouchers/data') ?>",
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
								data += generateModalDetail(full);
							}
							return data;
						}
					},
					{
						'data': 'package_name',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'order_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'code',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'title',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'is_redeem',
						'render': function(data, type, row) {
							return data == 1 ? 'Sudah Redeem' : 'Belum Redeem';
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var formattedDate = expiredDate.toLocaleDateString('id-ID');
								return formattedDate;
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var today = new Date();
								var timeDiff = expiredDate.getTime() - today.getTime();
								var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

								if (daysDiff < 0) {
									return '<span class="badge badge-danger">Expired</span>';
								} else {
									return '<span class="badge badge-success">Aktif</span>';
								}
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var today = new Date();
								var timeDiff = expiredDate.getTime() - today.getTime();
								var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

								if (daysDiff < 0) {
									return Math.abs(daysDiff) + ' Hari lalu';
								} else {
									return daysDiff + ' Hari lagi';
								}
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								data = '<a href="#" data-toggle="modal" data-target="#edit_' + full.id + '"><i onclick="hapus(' + full.id + ')" class="fa fa-edit" aria-hidden="true" style="font-size: 24px; color:#007bff;"></i></a>';
								data += generateModalEdit(full);
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
	$(document).ready(function() {

		var table = $('#approaching').DataTable({
				'dom': "<'row'<'col-12 col-md-6'l><'col-12 col-md-6'<'float-md-left ml-2'B>f>>" +
					"<'row'<'col-12'tr>>" +
					"<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",


				"ajax": {
					"url": "<?php echo base_url('vocmanualexp/dataExp') ?>",
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
								data = '<a href="#" data-toggle="modal" data-target="#detailsModalExp_' + full.id + '"><i onclick="hapus(' + full.id + ')" class="fa fa-eye" aria-hidden="true" style="font-size: 24px; color:#D4011B;"></i></a>';
								data += generateModalDetailExp(full);
							}
							return data;
						}
					},
					{
						'data': 'package_name',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'order_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'code',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'title',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'data': 'is_redeem',
						'render': function(data, type, row) {
							return data == 1 ? 'Sudah Redeem' : 'Belum Redeem';
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var formattedDate = expiredDate.toLocaleDateString('id-ID');
								return formattedDate;
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var today = new Date();
								var timeDiff = expiredDate.getTime() - today.getTime();
								var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

								if (daysDiff < 0) {
									return '<span class="badge badge-danger">Expired</span>';
								} else {
									return '<span class="badge badge-success">Aktif</span>';
								}
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'data': 'expiredAt',
						'render': function(data, type, row) {
							if (data !== null) {
								var expiredDate = new Date(data);
								var today = new Date();
								var timeDiff = expiredDate.getTime() - today.getTime();
								var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

								if (daysDiff < 0) {
									return Math.abs(daysDiff) + ' Hari lalu';
								} else {
									return daysDiff + ' Hari lagi';
								}
							} else {
								return 'Tidak Ada Data';
							}
						}
					},
					{
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								data = '<a href="#" data-toggle="modal" data-target="#editExp_' + full.id + '"><i onclick="hapus(' + full.id + ')" class="fa fa-edit" aria-hidden="true" style="font-size: 24px; color:#007bff;"></i></a>';
								data += generateModalEditExp(full);
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
	function generateModalDetail(record) {
    return `
    <div class="modal fade" id="detailsModal_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Detail - ${record.title}</h5>
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
										<input type="text" class="form-control" value="${record.title ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Status Redeem:</label>
										<input type="text" class="form-control" value="${record.is_redeem ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Pembeli :</label>
										<input type="text" class="form-control" value="${record.email ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Order ID:</label>
										<input type="text" class="form-control" value="${record.order_id ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Paket :</label>
										<input type="text" class="form-control" value="${record.package_name ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Code:</label>
										<input type="text" class="form-control" value="${record.code ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Create Date :</label>
										<input type="text" class="form-control" value="${record.createdAt ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Expired Date :</label>
										<input type="text" class="form-control" value="${record.expiredAt ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Di Redeem Oleh :</label>
										<input type="text" class="form-control" value="${record.full_name ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Tanggal Redeem :</label>
										<input type="text" class="form-control" value="${record.updatedAt ?? 'Tidak ada data'}" placeholder="Disabled input">
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
	function generateModalEdit(record) {
    return `
    <div class="modal fade" id="edit_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Ubah Expired - ${record.title}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-left">
					<form id="editForm" method="post" action="<?php echo base_url('vocmanualexp/updateexp/${record.id}'); ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label>Job Generate :</label>
									<input type="text" class="form-control" value="${record.title ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Order ID:</label>
									<input type="text" class="form-control" value="${record.order_id ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Paket :</label>
									<input type="text" class="form-control" value="${record.package_name ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Code:</label>
									<input type="text" class="form-control" value="${record.code ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Create Date :</label>
									<input type="text" class="form-control" value="${record.createdAt ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Expired Date : ${record.expiredAt ?? 'Tidak ada data'}</label>
									<input type="date" class="form-control" name="expiredAt" value="${record.expiredAt ?? 'Tidak ada data'}">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>`;
}
</script>
<script>
	function generateModalDetailExp(record) {
    return `
    <div class="modal fade" id="detailsModalExp_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Detail - ${record.title}</h5>
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
										<input type="text" class="form-control" value="${record.title ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Status Redeem:</label>
										<input type="text" class="form-control" value="${record.is_redeem ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Pembeli :</label>
										<input type="text" class="form-control" value="${record.email ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Order ID:</label>
										<input type="text" class="form-control" value="${record.order_id ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Paket :</label>
										<input type="text" class="form-control" value="${record.package_name ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Code:</label>
										<input type="text" class="form-control" value="${record.code ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Create Date :</label>
										<input type="text" class="form-control" value="${record.createdAt ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Expired Date :</label>
										<input type="text" class="form-control" value="${record.expiredAt ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Di Redeem Oleh :</label>
										<input type="text" class="form-control" value="${record.full_name ?? 'Tidak ada data'}" placeholder="Disabled input">
									</div>
									<div class="form-group">
										<label>Tanggal Redeem :</label>
										<input type="text" class="form-control" value="${record.updatedAt ?? 'Tidak ada data'}" placeholder="Disabled input">
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
	function generateModalEditExp(record) {
    return `
    <div class="modal fade" id="editExp_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Ubah Expired - ${record.title}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-left">
					<form id="editForm" method="post" action="<?php echo base_url('vocmanualexp/updateexp/${record.id}'); ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label>Job Generate :</label>
									<input type="text" class="form-control" value="${record.title ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Order ID:</label>
									<input type="text" class="form-control" value="${record.order_id ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Paket :</label>
									<input type="text" class="form-control" value="${record.package_name ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Code:</label>
									<input type="text" class="form-control" value="${record.code ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Create Date :</label>
									<input type="text" class="form-control" value="${record.createdAt ?? 'Tidak ada data'}" placeholder="Disabled input" disabled>
								</div>
								<div class="form-group">
									<label>Expired Date : ${record.expiredAt ?? 'Tidak ada data'}</label>
									<input type="date" class="form-control" name="expiredAt" value="${record.expiredAt ?? 'Tidak ada data'}">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>`;
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

