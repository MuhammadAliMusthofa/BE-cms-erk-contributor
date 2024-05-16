<div class="row mt-3">
    <div class="col">
        <div class="card">
			<div class="card-body">
                <button type="button" class="btn-info btn" data-toggle="modal" data-target="#pdfUploadModal">
					<i class="fa fa-plus"></i> Tambah Data Video AR
				</button>
				<div class="modal fade" id="pdfUploadModal" tabindex="-1" role="dialog" aria-labelledby="pdfUploadModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="pdfUploadModalLabel">Tambah Data Video AR</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url('capaian_pembelajaran/add_cp'); ?>" enctype="multipart/form-data">
									<div class="form-group">
										<label for="video_id">Video ID</label>
										<input type="text" class="form-control" id="video_id" name="video_id">
									</div>
									<div class="form-group">
										<label for="repository">Repository</label>
										<textarea class="form-control" id="repository" name="repository"></textarea>
									</div>
									<div class="form-group">
										<label for="project">Project</label>
										<textarea class="form-control" id="project" name="project"></textarea>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			<!-- <a href="<?php echo base_url('videos/create/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add Video AR</a> -->
				<div class="table-responsive mt-3">
					<table id="example" class="table table-sm table-hover" cellspacing="0" width="100%">
						<thead class="">
							<tr>
								<th></th>
								<th>Video ID</th>
								<th>Repository</th>
								<th>Project</th>
								<th>Created date</th>
								<!-- <th>Created By</th> -->
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
				'dom': "<'row'<'col-12 col-md-6'l><'col-12 col-md-6'<'float-md-left ml-2'B>f>>" +
						"<'row'<'col-12'tr>>" +
						"<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
				'responsive': true,

				"ajax": {
					"url": "<?php echo base_url('videos/data_ar') ?>",
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
						'width': '7%',
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								var viewIcon = '<a href="#" data-toggle="modal" data-target="#detailsModal_' + full.id + '"><i class="fa fa-eye" aria-hidden="true" style="font-size: 24px; color:#17a2b8;"></i></a>';
								var editIcon = '<a href="<?php echo base_url('videos/create/'); ?>' + full.id + '" target="_blank"><i class="fa fa-edit" aria-hidden="true" style="font-size: 24px; color:#008000; margin-left: 10px;"></i></a>';
								return viewIcon + editIcon + generateModal(full);
							}
							return data;

						}
					},
					{
						'width': '10%',
						'data': 'video_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'width': '15%',
						'data': 'repository',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'width': '15%',
						'data': 'project',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'width': '7%',
						'data': 'createdAt',
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
        const base_url = '<?php echo base_url(); ?>';
		return `
			<div class="modal fade" id="detailsModal_${record.id}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="detailsModalLabel">Detail - ${record.video_id}</h5>
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
												<label>Video Status:</label>
												<input type="text" class="form-control" value="${record.ingest_status_id || 'Tidak ada data'}" placeholder="Disabled input">
											</div>
											<div class="form-group">
												<label>Video ID:</label>
												<input type="text" class="form-control" value="${record.video_id || 'Tidak ada data'}" placeholder="Disabled input">
											</div>
											<div class="form-group">
												<label>Judul Video :</label>
												<textarea class="form-control" rows="3" placeholder="Disabled input" disabled>${record.name_id || 'Tidak ada data'}</textarea>
											</div>
											<div class="form-group">
												<label>Tags:</label>
												<input type="text" class="form-control" value="${record.tags || 'Tidak ada data'}" placeholder="Disabled input">
											</div>
											<div class="form-group">
												<label>Labels :</label>
												<input type="text" class="form-control" value="${record.labels || 'Tidak ada data'}" placeholder="Disabled input">
											</div>
											<div class="form-group">
												<label>Worksheet :</label>
												<input type="text" class="form-control" value="${record.file_worksheet || 'Tidak ada data'}" placeholder="Disabled input">
												${record.file_worksheet ? `<a href="${base_url}assets/upload_worksheet/${record.file_worksheet}" target="_blank">Preview Worksheet</a>` : ''}
											</div>
											<div class="form-group">
												<label>Status :</label>
												<input type="text" class="form-control" value="${parseInt(record.publish) === 1 ? 'Publish' : 'Not Publish'}" placeholder="Disabled input">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label>Video URL :</label>
												<textarea class="form-control" rows="2" placeholder="Disabled input" disabled>${record.filename_id || 'Tidak ada data'}</textarea>
												<div class="video-preview mt-1">
													<video width="100%" height="100%" controls>
														<source src="${record.filename_id}" type="video/mp4">
														Your browser does not support the video tag.
													</video>
												</div>
											</div>
											<div class="form-group">
												<label>Thumbnail :</label>
												<input type="text" class="form-control" value="${record.thumbnail_id || 'Tidak ada data'}" placeholder="Disabled input">
												<div class="thumbnail-preview mt-1">
													<img src="${base_url}assets/upload_thumbnail/${record.thumbnail_id}" alt="Thumbnail" width="100%" height="100%">
												</div>
											</div>
											<div class="form-group">
												<label>Cover :</label>
												<input type="text" class="form-control" value="${record.poster_id || 'Tidak ada data'}" placeholder="Disabled input">
												<div class="cover-preview mt-1">
													<img src="${base_url}assets/upload_poster/${record.poster_id}" alt="cover" width="100%" height="100%">
												</div>
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
		`;
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