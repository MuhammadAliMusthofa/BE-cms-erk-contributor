<style>
	.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>

<div class="row mt-3">
    <div class="col">
        <div class="card">
			<div class="card-body">
			<a href="<?php echo base_url('videos/create/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add Video</a>
				<div class="table-responsive mt-3">
					<table id="example" class="table table-sm table-hover" cellspacing="0" width="100%">
						<thead class="">
							<tr>
								<th></th>
								<th>Video Status (ID)</th>
								<th>Video (ID)</th>
								<th>Judul Video</th>
								<!-- <th>Video Tags</th> -->
								<th>Status</th>
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
					"url": "<?php echo base_url('videos/data') ?>",
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
						'width': '10%',
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								var viewIcon = '<a href="#" data-toggle="modal" data-target="#detailsModal_' + full.id + '" title="Lihat Detail"><i class="fa fa-eye" aria-hidden="true" style="font-size: 24px; color:#008000;"></i></a>';
								var editIcon = '<a href="<?php echo base_url('videos/create/'); ?>' + full.id + '" title="Edit Metadata" target="_blank"><i class="fa fa-edit" aria-hidden="true" style="font-size: 24px; color:#D4011B; margin-left: 10px;"></i></a>';
								var editAr = '<a href="<?php echo base_url("videos/edit_ar/' + full.id + '/id" ); ?>" title="Edit Video AR" target="_blank"><i class="" aria-hidden="true" style="font-size: 24px; color:#007bff; margin-left: 10px;">AR</i></a>';
								return viewIcon + editIcon + editAr + generateModal(full);
							}
							return data;

						}
					},
					{
						'width': '7%',
						'data': 'ingest_status_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'width': '15%',
						'data': 'video_id',
						'render': function(data, type, row) {
							return data !== null ? data : 'Tidak Ada Data';
						}
					},
					{
						'width': '40%',
						'data': null,
						'render': function(data, type, row) {
							var thumbnailUrl = data.thumbnail_id !== null ? '<?php echo base_url()?>assets/upload_thumbnail/' + data.thumbnail_id : '';
							var thumbnailImage = thumbnailUrl !== '' ? '<img src="' + thumbnailUrl + '" alt="img" width="50" height="50">' : '[No Thumbnail] ';
							var nameData = data.name_id !== null ? data.name_id : 'Tidak Ada Data';

							return thumbnailImage + ' ' + nameData;
						}
					},
					// {
					// 	'data': 'tags',
					// 	'render': function(data, type, row) {
					// 		return data !== null ? data : 'Tidak Ada Data';
					// 	}
					// },
					{
						'width': '50%',
						'orderable': false,
						'data': null,
						'className': 'text-center',
						'render': function(data, type, full, meta) {
							if (type === 'display') {
								var captions = '<a href="<?php echo base_url("videos/form_caption/' + full.id + '/id"); ?>" title="Caption" target="_blank" class="btn btn-xs ' + (full.caption_id !== null ? 'btn-success' : 'btn-outline-danger') + '"><i class="fa fa-cc" aria-hidden="true" style="font-size: 20px;"></i><span style="font-size: 5px; display: block;">Captions</span></a>';                            
								var videos = '<a href="<?php echo base_url("videos/form/' + full.id + '/id"); ?>" title="Videos" target="_blank" class="btn btn-xs ' + (full.filename_id !== null ? 'btn-success' : 'btn-outline-danger') + '"><i class="fa fa-video-camera" aria-hidden="true" style="font-size: 20px;"></i><span style="font-size: 5px; display: block;">Videos</span></a>';
								var thumbnails = '<a href="<?php echo base_url("videos/form_thumbnail/' + full.id + '/id"); ?>" title="Thumbnail" target="_blank" class="btn btn-xs ' + (full.thumbnail_id !== null ? 'btn-success' : 'btn-outline-danger') + '"><i class="fa fa-image" aria-hidden="true" style="font-size: 20px;"></i><span style="font-size: 5px; display: block;">Thumbnails</span></a>';                            
								var covers = '<a href="<?php echo base_url("videos/form_poster/' + full.id + '/id"); ?>" title="Cover" target="_blank" class="btn btn-xs ' + (full.poster_id !== null ? 'btn-success' : 'btn-outline-danger') + '"><i class="fa fa-image" aria-hidden="true" style="font-size: 20px;"></i><span style="font-size: 5px; display: block;">Cover</span></a>';                            
								var file_worksheet = '<a href="<?php echo base_url("videos/form_worksheet/' + full.id + '/id"); ?>" title="Worksheet" target="_blank" class="btn btn-xs ' + (full.file_worksheet !== null && full.file_worksheet.trim() !== '' ? 'btn-success' : 'btn-outline-danger') + '"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 20px;"></i><span style="font-size: 5px; display: block;">Worksheet</span></a>';
								// var repository = '<a href="<?php echo base_url("videos/edit_ar/' + full.id + '/id"); ?>" target="_blank" class="btn btn-xs ' + (full.repository !== null ? 'btn-success' : 'btn-outline-danger') + '">Video AR</a>';  
								// var publish = '<a href="<?php echo base_url("videos/publish/' + full.id + '/id"); ?>" class="btn btn-xs">Publish</a>';
        						// var unpublish = '<a href="<?php echo base_url("videos/unpublish/' + full.id + '/id"); ?>" class="btn btn-xs">Unpublish</a>';
								// return captions + ' ' +  videos + ' ' +  thumbnails + ' ' +  covers + ' ' +  file_worksheet + ' ' + repository + ' ' +  publish + ' ' +  unpublish;
								return captions + ' ' +  videos + ' ' +  thumbnails + ' ' +  covers + ' ' +  file_worksheet;
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
											<div class="form-group">
												<label>Repository :</label>
												<textarea class="form-control" rows="3" placeholder="Disabled input" disabled>${record.repository || 'Tidak ada data'}</textarea>
											</div>
											<div class="form-group">
												<label>Project :</label>
												<textarea class="form-control" rows="3" placeholder="Disabled input" disabled>${record.project || 'Tidak ada data'}</textarea>
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
													<img src="${base_url}assets/upload_cover/${record.poster_id}" alt="cover" width="100%" height="100%">
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