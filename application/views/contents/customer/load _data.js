document.addEventListener("DOMContentLoaded", function () {
    const customers = <?php echo json_encode($customers); ?>; // Ambil data pelanggan dari PHP

    const tableBody = document.querySelector("#dataTable tbody");

    customers.forEach(function (record) {
      const row = document.createElement("tr");

      // Isi kolom pada baris tabel dengan data yang sesuai
      row.innerHTML = `
        <td>
          <a href="#" data-toggle="modal" data-target="#detailsModal_${record.id}">
            <i class="fa fa-eye" style="font-size: 24px; color:#D4011B;"></i>
          </a>
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
											<input type="text" class="form-control" value="${record.brithdate !== null ? record.brithdate : 'Tidak ada data'}"" placeholder="Disabled input">
										</div>
										<div class="form-group">
											<label>School:</label>
											<input type="text" class="form-control" value="${record.school !== null ? record.school : 'Tidak ada data'}"" placeholder="Disabled input">
										</div>
										<div class="form-group">
											<label>Alamat :</label>
											<textarea class="form-control">${record.address !== null ? record.address : 'Tidak ada data'}"</textarea>
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
		</div>			
        </td>
        <td>${record.full_name !== null ? record.full_name : 'Tidak Ada Data'}</td>
		<td>${record.email !== null ? record.email : 'Tidak Ada Data'}</td>
		<td>${record.phone !== null ? record.phone : 'Tidak Ada Data'}</td>
		<td>${record.school !== null ? record.school : 'Tidak Ada Data'}</td>
		<td>${record.title_id !== null ? record.title_id : 'Tidak Ada Data'}</td>
        <td>
          <a href="<?php echo base_url('users/deletec/') ?>${record.id}/id" class="btn btn-xs btn-outline-success">
            <i class="ti ti-trash"></i> Delete
          </a>
          <a href="#" data-toggle="modal" data-target="#modalgenerated" class="btn btn-xs btn-outline-danger">
            <i class="fa fa-remove"></i> Reset Password
          </a>
        </td>
      `;
      
      tableBody.appendChild(row);
    });
  });