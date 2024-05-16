<style>
	.card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
</style>
<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="box-content">
					<a href="<?php echo base_url('packages/form/'); ?>" class="btn-info btn" target="_blank"><i class="fa fa-plus"></i> &nbsp;Add Packages</a>
					<div class="data-tables mt-3">
						<table id="dataTable" class="text-center">
							<thead class="bg-light text-capitalize">
								<tr>
									<th></th>
									<th>Device</th>
									<th>Nama</th>
									<th>Kode</th>
									<th>Kode AX</th>
									<th>Type</th>
									<th>Consumer</th>
									<th>Jenjang</th>
									<th>Duration</th>
									<th>Price</th>
									<th>Status</th>
									<th>Create Date</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($packages as $package): ?>
									<tr>
										<td>
											<a href="<?php echo base_url('packages/form/'.$package->id); ?>" ><i class="fa fa-edit" style="font-size: 24px;"></i></a>
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
															<a href="<?php echo base_url('packages/delete/'.$package->id); ?>" class="btn btn-danger">Hapus</a>
														</div>
													</div>
												</div>
											</div>
										</td>
										<td><?php echo $package->device; ?></td>
										<td><?php echo $package->name; ?></td>
										<td><?php echo $package->code; ?></td>
										<td><?php echo $package->kode_produk_ax; ?></td>
										<td><?php echo $package->consumer; ?></td>
										<td><?php echo $package->method; ?></td>
										<td><?php echo $package->jenjang_id; ?></td>
										<td><?php echo $package->periode; ?></td>
										<td><?php echo 'Rp ' . number_format($package->price, 0, ',', '.'); ?></td>
										<td><?php echo ($package->status == 1) ? 'Aktif' : 'Tidak Aktif'; ?></td>
										<td><?php echo $package->createdAt; ?></td>
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