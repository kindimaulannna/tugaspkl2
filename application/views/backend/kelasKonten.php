<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelas</h3>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btnTambahKelas mb-2">Tambah Kelas</button>
                <table class="table table-striped" id="tabelKelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Tahun Pelajaran</th>
                            <th>Id Jurusan</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalKelas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formKelas">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="id_tahun_pelajaran">ID Tahun Pelajaran</label>
                        <input type="text" id="id_tahun_pelajaran" name="id_tahun_pelajaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_jurusan">ID Jurusan</label>
                        <input type="text" id="id_jurusan" name="id_jurusan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary saveKelasBtn">Simpan</button>
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    function refreshTable() {
        $.get('<?= base_url('kelas/table_kelas'); ?>', function (res) {
            const table = $('#tabelKelas tbody').empty();
            if (res.status) {
                res.data.forEach((row, i) => {
                    table.append(`<tr>
                        <td>${i + 1}</td>
                        <td>${row.id_tahun_pelajaran}</td>
                        <td>${row.id_jurusan}</td>
                        <td>${row.nama_kelas}</td>
                        <td>
                            <button onclick="edit(${row.id})" class="btn btn-sm btn-warning">Edit</button>
                            <button onclick="hapus(${row.id})" class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>`);
                });
            } else {
                table.append(`<tr><td colspan="5">${res.message}</td></tr>`);
            }
        });
    }

    $('.btnTambahKelas').click(() => $('#modalKelas').modal('show'));

    $('.saveKelasBtn').click(function () {
        const data = $('#formKelas').serialize();
        const id = $('#id').val();
        const url = id ? 'kelas/edit_kelas' : 'kelas/tambah_kelas';

        $.post(`<?= base_url(); ?>${url}`, data, function (res) {
            alert(res.message);
            if (res.status) {
                $('#modalKelas').modal('hide');
                refreshTable();
            }
        });
    });

    window.hapus = (id) => {
        if (confirm('Yakin ingin menghapus?')) {
            $.get(`kelas/hapus_kelas/${id}`, refreshTable);
        }
    };

    refreshTable();
});
</script>
