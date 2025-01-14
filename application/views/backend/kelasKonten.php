<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Kelas</h3>
			</div>
			<div class="card-body">
				<div class="btn btn-primary btnTambah mb-2"> <i class="fas fa-plus"></i> Tambah</div>
				<div class="row">
					<table class="table table-striped" id="tabel">
						<thead>
							<tr>
								<th>No</th>
								<th>Tahun Pelajaran</th>
								<th>Nama Jurusan</th>
								<th>Nama Kelas</th>


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

<div class="modal" id="modal" tabindex=" -1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Kelas</h5>

				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-user">
					<form id="formKelas" action="#" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control" id="id" name="id" value="">

						<div class="mb-1">
							<label for="id_tahun_pelajaran" class="form-label">Nama Tahun Pelajaran</label>
							<select class="form-control" name="id_tahun_pelajaran" id="id_tahun_pelajaran">
								<option value="">- Pilih Tahun Pelajaran -</option>
							</select>
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="id_jurusan" class="form-label">Nama Jurusan</label>
							<select class="form-control" name="id_jurusan" id="id_jurusan">
								<option value="">- Pilih Jurusan -</option>
							</select>
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="nama_kelas" class="form-label">Nama Kelas</label>
							<input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="">
							<div class="error-block"></div>
						</div>

					</form>

					<div>

					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveBtn">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>



<script>
	$(document).ready(function() {
		tabel();
		$('#id_tahun_pelajaran').load('<?php echo base_url('kelas/option_tahun_pelajaran'); ?>');
		$('#id_tahun_pelajaran').change(function() {
			let id = $(this).val(); // id tahun pelajaran
			let url = '<?php echo base_url('kelas/option_jurusan'); ?>';
			$('#id_jurusan').load(url + '/' + id);
		})

	})

	function tabel() {
		let tabel = $('#tabel');
		let tr = '';
		$.ajax({
			url: '<?php echo base_url('kelas/table_kelas'); ?>',
			type: 'GET',

			dataType: 'json',
			success: function(response) {
				if (response.status) {
					tabel.find('tbody').html('');
					let no = 1;
					$.each(response.data, function(i, item) {
						tr = $('<tr>');

						tr.append('<td>' + no++ + '</td>');
						tr.append('<td>' + item.nama_tahun_pelajaran + '</td>');
						tr.append('<td>' + item.nama_jurusan + '</td>');
						tr.append('<td>' + item.nama_kelas + '</td>');

						tr.append('<td>	<button class="btn btn-primary" onclick="editKelas(' + item.id + ')">Edit</button> <button class="btn btn-danger" onclick="deleteKelas(' + item.id + ')">Delete</button></td>');
						tabel.find('tbody').append(tr);
					});

				} else {
					tr = $('<tr>');
					tabel.find('tbody').html('');
					tr.append('<td colspan="4">' + response.message + '</td>');
				}
			}
		});
	}

	$('.btnTambah').click(function() {
		$('#id').val('');
		$('#formKelas').trigger('reset');
		$('#modal').modal('show');
	});
	$('.saveBtn').click(function() {
		// lakukan proses simpan data, lalu tutup modal , lalu reload tabel
		$.ajax({
			url: '<?php echo base_url('kelas/save'); ?>',
			type: 'POST',
			data: {
				id: $('#id').val(),
				id_tahun_pelajaran: $('#id_tahun_pelajaran').val(),
				id_jurusan: $('#id_jurusan').val(),
				nama_kelas: $('#nama_kelas').val(),

			},
			dataType: 'json',
			success: function(response) {
				if (response.status) {
					alert(response.message);
					$('#modal').modal('hide');
					tabel();
				} else {
					alert(response.message);
				}
			}

		})
	})


	function editKelas(id) {
		// tampilkan data dalam modal 
		$.ajax({
			url: '<?php echo base_url('kelas/edit'); ?>',
			type: 'POST',
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response) {
				if (response.status) {
					$('#id').val(response.data.id);
					$('#id_tahun_pelajaran').val(response.data.id_tahun_pelajaran);
					$('#id_jurusan').val(response.data.id_jurusan);
					$('#nama_kelas').val(response.data.nama_kelas);
					setJurusan(response.data.id_tahun_pelajaran, response.data.id_jurusan);
					$('#modal').modal('show');
				} else {
					alert(response.message);
				}
			}
		})
	};

	function deleteKelas(id) {
		// lakukan proses delete data, lalu reload tabel
		$.ajax({
			url: '<?php echo base_url('kelas/delete'); ?>',
			type: 'POST',
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response) {
				if (response.status) {
					alert(response.message);
					tabel();
				} else {
					alert(response.message);
				}
			}
		})
	};

	function setJurusan(id_tahun_pelajaran, id) {
		let url = '<?php echo base_url('kelas/option_jurusan'); ?>';
		$('#id_jurusan').load(url + '/' + id_tahun_pelajaran, function() {
			$('#id_jurusan').val(id);
		});

	}
</script>