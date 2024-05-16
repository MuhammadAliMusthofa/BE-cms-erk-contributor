<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
			<h4 class="header-title">Data Menu</h4>
				<button type="button" class="btn-info btn" data-toggle="modal" data-target="#pdfUploadModal">
					<i class="fa fa-plus"></i> Tambah Data Capaian Pembelajaran
				</button>
				<div class="modal fade" id="pdfUploadModal" tabindex="-1" role="dialog" aria-labelledby="pdfUploadModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="pdfUploadModalLabel">Tambah Data Capaian Pembelajaran</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url('capaian_pembelajaran/add_cp'); ?>" enctype="multipart/form-data">
									<div class="form-group">
										<label for="judul">Judul</label>
										<input type="text" class="form-control" id="judul" name="judul">
									</div>
									<div class="form-group">
										<label for="deskripsi">Deskripsi</label>
										<textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
									</div>
									<div class="form-group">
										<label for="jenjang">Jenjang</label>
										<select class="form-control" id="jenjang" name="jenjang">
											<?php foreach ($jenjang_options as $value) : ?>
												<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="pdf_files">File Capaian Pembelajaran</label>
										<input type="file" class="form-control-file" id="pdf_files" name="pdf_files[]" accept=".pdf" multiple>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">Unggah</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="box-content">
					<div class="data-tables mt-3">
						<table id="dataTable" class="text-center">
							<thead class="bg-light text-capitalize">
								<tr>
									<th>Action</th>
									<th>Judul</th>
									<th>Deskripsi</th>
									<th>Jenjang</th>
									<th>Link</th>
									<th>Review</th>
									<th>Created Date</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($get_cp as $cp): ?>
								<tr>
									<td>
										<a href="#" class="editBtn" data-toggle="modal" data-target="#editCapaianModal_<?php echo $cp->id; ?>">
											<i class="fa fa-edit" style="font-size: 24px;"></i>
										</a>
										<div class="modal fade" id="editCapaianModal_<?php echo $cp->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editCapaianModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="editCapaianModalLabel">Edit Data - <?php echo $cp->judul; ?></h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form method="post" action="<?php echo base_url('capaian_pembelajaran/update_cp/'.$cp->id); ?>" enctype="multipart/form-data">
															<div class="form-group">
																<label for="edit_judul">Judul</label>
																<input type="text" class="form-control" name="edit_judul" id="edit_judul" value="<?php echo $cp->judul; ?>">
															</div>
															<div class="form-group">
																<label for="edit_deskripsi">Deskripsi</label>
																<textarea class="form-control" name="edit_deskripsi" id="edit_deskripsi"><?php echo $cp->deskripsi; ?></textarea>
															</div>
															<div class="form-group">
																<label for="edit_jenjang">Jenjang</label>
																<select class="form-control" id="edit_jenjang" name="edit_jenjang">
																	<?php if ($data_edit['edit_jenjang'] === null) : ?>
																		<option value="" selected>Belum Memilih Jenjang</option>
																	<?php endif; ?>
																	<?php foreach ($jenjang_options as $value) : ?>
																		<?php if ($value == $data_edit['edit_jenjang']) : ?>
																			<option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
																		<?php else : ?>
																			<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
																		<?php endif; ?>
																	<?php endforeach; ?>
																</select>
															</div>
															<div class="form-group">
																<label for="edit_pdf_file">File Capaian Pembelajaran</label>
																<input type="file" class="form-control-file" name="edit_pdf_file" id="edit_pdf_file" accept=".pdf">
																<p style="text-align: left;">File saat ini: <?php echo $cp->link; ?></p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
																<button type="submit" class="btn btn-danger">Simpan</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<a href="#" data-toggle="modal" data-target="#confirmDeleteModal_<?php echo $cp->id; ?>">
											<i class="ti-trash" style="font-size: 24px; color:#D4011B;"></i>
										</a>
										<div class="modal fade" id="confirmDeleteModal_<?php echo $cp->id; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
														<a href="<?php echo base_url('capaian_pembelajaran/deletec/'.$cp->id); ?>" class="btn btn-danger">Hapus</a>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td><?php echo $cp->judul; ?></td>
									<td><?php echo $cp->deskripsi; ?></td>
									<td><?php echo $cp->jenjang ?? 'Belum Memilih Jenjang'; ?></td>
									<td><?php echo $cp->link; ?></td>
									<td><a href="<?php echo $cp->link; ?>" target="_blank" class="btn btn-info">Buka PDF</a></td>
									<td><?php echo $cp->createdAt; ?></td>
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
