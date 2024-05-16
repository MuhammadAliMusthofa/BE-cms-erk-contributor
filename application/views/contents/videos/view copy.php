<style>
	.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
</script>
<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="box-content">
					<a href="<?php echo base_url('videos/create/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add Video</a>
					<div class="data-tables mt-3">
						<table id="dataTable" class="text-center">
							<thead class="bg-light text-capitalize" >
								<tr>
									<th></th>
									<th>Video Status (ID)</th>
									<th>Video (ID)</th>
									<th>Judul Video</th>
									<th>Video Tags</th>
									<th>Create Date</th>
									<th>Publish Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="text-left">
							<?php foreach ($get_video as $record): ?>
									<tr>
										<td>
											<a href="<?php echo base_url('videos/create/'.$record->id); ?>" ><i class="fa fa-edit" style="font-size: 24px;"></i></a>
											<a href="#" data-toggle="modal" data-target="#confirmDeleteModal">
												<i class="ti-trash" style="font-size: 24px; color:#D4011B;"></i>
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
															Apakah Anda yakin ingin menghapus?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
															<a href="<?php echo base_url('videos/delete/'.$record->id); ?>" class="btn btn-danger">Hapus</a>
														</div>
													</div>
												</div>
											</div>
										</td>
										<td><?php echo $record->ingest_status_id; ?></td>
										<td><?php echo $record->video_id; ?></td>
										<td>
											<div class="row">
												<div class="col-6 col-md-4">
													<img src="<?php echo base_url()?>assets/upload_thumbnail/<?php echo $record->thumbnail_id ?>" alt="img" width="50" height="50">
												</div>
												<div class="col-12 col-md-8">
													<?php echo $record->name_id; ?>
												</div>
											</div>
											<!-- <div class="lts-thumb">
												<img src="<?php echo base_url()?>assets/upload_thumbnail/<?php echo $record->thumbnail_id ?>" alt="post thumb" width="50" height="50">
											</div>
											<div class="lts-content">
												<?php echo $record->name_id; ?>
											</div> -->
										</td>
										<td><?php echo $record->tags; ?></td>
										<!-- <td><?php echo $record->labels; ?></td> -->
										<td><?php echo $record->createdAt; ?></td>
										<td><?php echo ($record->publish == 1) ? 'Publish' : 'Not Publish'; ?></td>

										<td>
											<?php
												$buttonCaption = ($record->caption_id !== null) ? 'btn-success' : 'btn-outline-danger';
												$buttonThumbnail = ($record->thumbnail_id !== null) ? 'btn-success' : 'btn-outline-danger';
												$buttonVideos = ($record->filename_id !== null) ? 'btn-success' : 'btn-outline-danger';
												$buttonCover = ($record->poster_id !== null) ? 'btn-success' : 'btn-outline-danger';
												$buttonPublish = ($record->publish == 1 && $record->publish !== null) ? 'btn-success' : 'btn-outline-danger';
											?>
											<a href="<?php echo base_url('videos/form_caption/' . $record->id . '/id'); ?>" class="btn btn-xs <?php echo $buttonCaption; ?>">
												<i class="fa fa-cloud-upload"></i> 
												Upload Caption
											</a>
											<a href="<?php echo base_url('videos/form/' . $record->id . '/id'); ?>" class="btn btn-xs <?php echo $buttonVideos; ?>">
												<i class="fa fa-cloud-upload"></i> 
												Upload Video
											</a>
											<a href="<?php echo base_url('videos/form_thumbnail/' . $record->id . '/id'); ?>" class="btn btn-xs <?php echo $buttonThumbnail; ?>">
												<i class="fa fa-cloud-upload"></i> 
												Upload Thumbnail
											</a>
											<a href="<?php echo base_url('videos/form_poster/' . $record->id . '/id'); ?>" class="btn btn-xs <?php echo $buttonCover; ?>">
												<i class="fa fa-cloud-upload"></i> 
												Upload Cover
											</a>
											<a href="<?php echo base_url('videos/publish/' . $record->id . '/id'); ?>" class="btn btn-xs <?php echo $buttonPublish; ?>">
												<i class="fa fa-check"></i> 
												Publish
											</a>
											<a href="<?php echo base_url('videos/unpublish/' . $record->id . '/id'); ?>" class="btn btn-xs btn-outline-danger">
												<i class="fa fa-remove"></i> 
												Unpublish
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