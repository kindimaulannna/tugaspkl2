<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jurusan</h3>
            </div>
            <div class="card-body">
                <div class="btn btn-primary btnTambahJurusan mb-2"> <i class="fas fa-plus"></i> Tambah</div>
                <div class="row">
                    <table class="table table-striped" id="tabelTahunPelajaran">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Tahun Pelajaran</th>
                                <th>Nama Jurusan</th>
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

<div class="modal" id="modalJurusan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jurusan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Input hidden untuk ID -->
                    <input type="hidden" id="id" name="id">
                    <div class="mb-1">
                        <label for="id_tahun_pelajaran" class="form-label">ID Tahun Pelajaran</label>
                        <input type="text" class="form-control" id="id_tahun_pelajaran" name="id_tahun_pelajaran">
                        <span class="error-block text-danger"></span>
                    </div>
                    <div class="mb-1">
                        <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan">
                        <span class="error-block text-danger"></span>
                    </div>
                </form>
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
    tabelJurusan();

    // Event handler untuk tombol tambah
    $('.btnTambahJurusan').click(function () {
        $('#modalJurusan').modal('show');
        $('#id').val(''); // Kosongkan ID untuk tambah data baru
        $('#id_tahun_pelajaran').val('');
        $('#nama_jurusan').val('');
        $('.error-block').html(''); // Reset pesan error
    });

    // Event handler untuk tombol simpan
    $('.saveBtn').click(function () {
        const id = $('#id').val(); // Ambil nilai ID
        const idTahunPelajaran = $('#id_tahun_pelajaran').val().trim();
        const namaJurusan = $('#nama_jurusan').val().trim();

        // Validasi input
        let isValid = true;
        $('.error-block').html(''); // Reset error message

        if (!idTahunPelajaran) {
            $('#id_tahun_pelajaran').next('.error-block').html('ID Tahun Pelajaran tidak boleh kosong.');
            isValid = false;
        }
        if (!namaJurusan) {
            $('#nama_jurusan').next('.error-block').html('Nama Jurusan tidak boleh kosong.');
            isValid = false;
        }

        // Jika validasi gagal, hentikan proses
        if (!isValid) return;

        // Tentukan URL untuk tambah atau edit
        const url = id ? 'jurusan/edit_jurusan' : 'jurusan/tambah_jurusan';

        // Proses AJAX untuk tambah/edit
        $.ajax({
            url: `<?php echo base_url(); ?>${url}`,
            type: 'POST',
            data: {
                id: id, // Akan kosong jika tambah
                id_tahun_pelajaran: idTahunPelajaran,
                nama_jurusan: namaJurusan,
            },
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                if (response.status) {
                    $('#modalJurusan').modal('hide');
                    tabelJurusan(); // Refresh tabel setelah simpan
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan pada server.');
            },
        });
    });
});

// Fungsi untuk menampilkan data tabel jurusan
function tabelJurusan() {
    const tabelJurusan = $('#tabelTahunPelajaran');
    tabelJurusan.find('tbody').html(''); // Kosongkan tabel terlebih dahulu

    $.ajax({
        url: '<?php echo base_url('jurusan/table_jurusan'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let no = 1;
                response.data.forEach(function (item) {
                    let row = `
                        <tr>
                            <td>${no++}</td>
                            <td>${item.id_tahun_pelajaran}</td>
                            <td>${item.nama_jurusan}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editJurusan(${item.id})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteJurusan(${item.id})">Delete</button>
                            </td>
                        </tr>`;
                    tabelJurusan.find('tbody').append(row);
                });
            } else {
                tabelJurusan.find('tbody').html(`<tr><td colspan="4">${response.message}</td></tr>`);
            }
        },
    });
}

// Fungsi untuk menghapus jurusan
function deleteJurusan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        $.ajax({
            url: `<?php echo base_url('jurusan/hapus_jurusan/'); ?>${id}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                if (response.status) {
                    tabelJurusan(); // Refresh tabel setelah hapus
                }
            },
        });
    }
}

// Fungsi untuk edit jurusan
function editJurusan(id) {
    $.ajax({
        url: '<?php echo base_url('jurusan/detail_jurusan'); ?>',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                const data = response.data;
                $('#modalJurusan').modal('show');
                $('#id').val(data.id);
                $('#id_tahun_pelajaran').val(data.id_tahun_pelajaran);
                $('#nama_jurusan').val(data.nama_jurusan);
            } else {
                alert('Data tidak ditemukan.');
            }
        },
        error: function () {
            alert('Terjadi kesalahan pada server.');
        },
    });
    function tabelJurusan() {
    const tabelJurusan = $('#tabelTahunPelajaran');
    tabelJurusan.find('tbody').html('<tr><td colspan="4">Loading...</td></tr>');

    $.ajax({
        url: '<?php echo base_url('jurusan/table_jurusan'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let rows = '';
                response.data.forEach((item, index) => {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.id_tahun_pelajaran}</td>
                            <td>${item.nama_jurusan}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editJurusan(${item.id})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteJurusan(${item.id})">Delete</button>
                            </td>
                        </tr>`;
                });
                tabelJurusan.find('tbody').html(rows);
            } else {
                tabelJurusan.find('tbody').html(`<tr><td colspan="4">${response.message}</td></tr>`);
            }
        },
        error: function () {
            tabelJurusan.find('tbody').html('<tr><td colspan="4">Terjadi kesalahan saat memuat data.</td></tr>');
        },
    });
}
}

</script>