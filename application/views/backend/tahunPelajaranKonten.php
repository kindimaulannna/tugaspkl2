<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Tahun Pelajaran</h3>
			</div>
			<div class="card-body">
				<div class="btn btn-primary btnTambahTahunPelajaran mb-2"> <i class="fas fa-plus"></i> Tambah</div>
				<div class="row">
					<table class="table table-striped" id="tabelTahunPelajaran">
						<thead>
							<tr>
								<th>No</th>
								<th>Tahun Pelajaran</th>
								<th>Mulai</th>
								<th>Akhir</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalTahunPelajaran" tabindex=" -1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Tahun Pelajaran</h5>

				<button type="button" class="close " data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-user">
					<form action="#" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control" id="id" name="id" value="">

						<div class="mb-1">
							<label for="nama_tahun_pelajaran" class="form-label">Nama Tahun Pelajaran</label>
							<input type="text" class="form-control" id="nama_tahun_pelajaran" name="nama_tahun_pelajaran" value="">
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
							<input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="">
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
							<input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="">
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="status_tahun_pelajaran" class="form-label">Status</label>
							<select class="form-control" id="status_tahun_pelajaran" name="status_tahun_pelajaran">
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
							<div class="error-block"></div>
						</div>


					</form>

					<div>

					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveBtn">Simpan</button>
				<button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>



<script>
	$(document).ready(function () {
    tabelTahunPelajaran();

    // Event handler untuk tombol tambah
    $('.btnTambahTahunPelajaran').click(function () {
        $('#modalTahunPelajaran').modal('show');
        $('#id').val('');
        $('#nama_tahun_pelajaran').val('');
        $('#tanggal_mulai').val('');
        $('#tanggal_akhir').val('');
        $('#status_tahun_pelajaran').val('');
    });

    // Event handler untuk tombol simpan
    $('.saveBtn').click(function () {
    // Ambil nilai input
    const id = $('#id').val();
    const namaTahunPelajaran = $('#nama_tahun_pelajaran').val().trim();
    const tanggalMulai = $('#tanggal_mulai').val().trim();
    const tanggalAkhir = $('#tanggal_akhir').val().trim();
    const statusTahunPelajaran = $('#status_tahun_pelajaran').val();

    // Reset error block
    $('.error-block').html('');

    // Validasi input
    let isValid = true;
    if (!namaTahunPelajaran) {
        $('#nama_tahun_pelajaran').next('.error-block').html('Nama Tahun Pelajaran tidak boleh kosong.');
        isValid = false;
    }
    if (!tanggalMulai) {
        $('#tanggal_mulai').next('.error-block').html('Tanggal Mulai tidak boleh kosong.');
        isValid = false;
    }
    if (!tanggalAkhir) {
        $('#tanggal_akhir').next('.error-block').html('Tanggal Akhir tidak boleh kosong.');
        isValid = false;
    }
    if (!statusTahunPelajaran) {
        $('#status_tahun_pelajaran').next('.error-block').html('Status harus dipilih.');
        isValid = false;
    }

    // Jika validasi gagal, hentikan proses
    if (!isValid) {
        return;
    }

    // Jika validasi berhasil, lakukan AJAX
    const url = id ? 'tahun_pelajaran/edit_tahun_pelajaran' : 'tahun_pelajaran/tambah_tahun_pelajaran';

    $.ajax({
        url: `<?php echo base_url(); ?>${url}`,
        type: 'POST',
        data: {
            id: id,
            nama_tahun_pelajaran: namaTahunPelajaran,
            tanggal_mulai: tanggalMulai,
            tanggal_akhir: tanggalAkhir,
            status_tahun_pelajaran: statusTahunPelajaran,
        },
        dataType: 'json',
        success: function (response) {
            alert(response.message);
            if (response.status) {
                $('#modalTahunPelajaran').modal('hide');
                tabelTahunPelajaran(); // Refresh tabel setelah simpan
            }
        },
    });
});

});

// Fungsi untuk menampilkan data tabel tahun pelajaran
function tabelTahunPelajaran() {
    const tabelTahunPelajaran = $('#tabelTahunPelajaran');
    tabelTahunPelajaran.find('tbody').html(''); // Kosongkan tabel terlebih dahulu

    $.ajax({
        url: '<?php echo base_url('tahun_pelajaran/table_tahun_pelajaran'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let no = 1;
                response.data.forEach(function (item) {
                    let row = `
                        <tr>
                            <td>${no++}</td>
                            <td>${item.nama_tahun_pelajaran}</td>
                            <td>${item.tanggal_mulai}</td>
                            <td>${item.tanggal_akhir}</td>
                            <td>${item.status_tahun_pelajaran == 1 ? 'Aktif' : 'Tidak Aktif'}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editTahunPelajaran(${item.id})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteTahunPelajaran(${item.id})">Delete</button>
                            </td>
                        </tr>`;
                    tabelTahunPelajaran.find('tbody').append(row);
                });
            } else {
                tabelTahunPelajaran.find('tbody').html(`<tr><td colspan="6">${response.message}</td></tr>`);
            }
        },
    });
}

// Fungsi untuk menghapus tahun pelajaran
function deleteTahunPelajaran(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        $.ajax({
            url: `<?php echo base_url('tahun_pelajaran/hapus_tahun_pelajaran/'); ?>${id}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                if (response.status) {
                    tabelTahunPelajaran(); // Refresh tabel setelah hapus
                }
            },
        });
    }
}

// Fungsi untuk edit tahun pelajaran
function editTahunPelajaran(id) {
    $.ajax({
        url: `<?php echo base_url('tahun_pelajaran/table_tahun_pelajaran'); ?>`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                const data = response.data.find((item) => item.id == id); // Cari data berdasarkan ID
                if (data) {
                    $('#modalTahunPelajaran').modal('show');
                    $('#id').val(data.id);
                    $('#nama_tahun_pelajaran').val(data.nama_tahun_pelajaran);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_akhir').val(data.tanggal_akhir);
                    $('#status_tahun_pelajaran').val(data.status_tahun_pelajaran);
                }
            }
        },
    });
}

</script>