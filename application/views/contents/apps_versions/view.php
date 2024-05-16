<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Data Version Apps Mobile</h4>
                <button type="button" class="btn-info btn" data-toggle="modal" data-target="#pdfUploadModal">
                    <i class="fa fa-plus"></i> Tambah Data Versi Terbaru
                </button>
                <div class="modal fade" id="pdfUploadModal" tabindex="-1" role="dialog" aria-labelledby="pdfUploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdfUploadModalLabel">Tambah Data Versi Terbaru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('apps_versions/add_versions'); ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="versions">Versions</label>
                                        <input type="text" class="form-control" id="versions" name="versions">
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select class="form-control" id="type" name="type">
                                            <?php
                                            // Ambil semua nilai enum dari database
                                            // Misalnya, Anda memiliki tabel 'types' dengan satu kolom 'name'
                                            // Gantilah 'types' dengan nama tabel Anda sendiri jika berbeda
                                            $query = $this->db->query("SHOW COLUMNS FROM sv_mobile LIKE 'type'");
                                            $row = $query->row(0);
                                            $enum = $row->Type;
                                            preg_match('/enum\((.*)\)$/', $enum, $matches);
                                            $enums = array();
                                            foreach (explode(',', $matches[1]) as $value) {
                                                $enums[] = trim($value, "'");
                                            }

                                            // Tampilkan nilai enum sebagai opsi dropdown
                                            foreach ($enums as $enum) {
                                                echo "<option value='$enum'>$enum</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Unggah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title" style="text-align: center;">Android Version</h4>
								<div class="single-table">
									<div class="table-responsive">
										<table class="table table-bordered text-center">
											<thead class="text-uppercase">
												<tr>
													<th scope="col">Version</th>
													<th scope="col">Type</th>
													<th scope="col">Descriptions</th>
													<th scope="col">Create Date</th>
													<th scope="col">Actions</th> <!-- Tambah kolom untuk action -->
												</tr>
											</thead>
											<tbody>
												<?php foreach ($get_android as $android): ?>
													<tr>
														<td><?php echo $android->versions; ?></td>
														<td><span class="badge badge-primary"><?php echo $android->type; ?></span></td>
														<td>
															<?php echo !empty($android->description) ? $android->description : "No description available"; ?>
														</td>
														<td><?php echo $android->createdAt; ?></td>
														<td>
															<a class="btn btn-danger btn-sm" href="<?php echo site_url('apps_versions/deletec/'.$android->id); ?>"><i class="ti-trash"></i></a>
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
					<div class="col">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title" style="text-align: center;">iOS Version</h4>
								<div class="single-table">
									<div class="table-responsive">
										<table class="table table-bordered text-center">
											<thead class="text-uppercase">
												<tr>
													<th scope="col">Version</th>
													<th scope="col">Type</th>
													<th scope="col">Descriptions</th>
													<th scope="col">Create Date</th>
													<th scope="col">Actions</th> <!-- Tambah kolom untuk action -->
												</tr>
											</thead>
											<tbody>
												<?php foreach ($get_ios as $ios): ?>
													<tr>
														<td><?php echo $ios->versions; ?></td>
														<td><span class="badge badge-secondary"><?php echo $ios->type; ?></span></td>
														<td>
															<?php echo !empty($ios->description) ? $ios->description : "No description available"; ?>
														</td>
														<td><?php echo $ios->createdAt; ?></td>
														<td>
															<a class="btn btn-danger btn-sm" href="<?php echo site_url('apps_versions/deletec/'.$ios->id); ?>"><i class="ti-trash"></i></a>
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
