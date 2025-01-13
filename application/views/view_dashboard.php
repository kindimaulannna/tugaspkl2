<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo base_url('public/template/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<title>Dashboard</title>
</head>

<body>
	<div class="row justify-content-center">
		<div class="card col-md-8 mt-5 ">
			<div class="card-header">
				<h1>halaman dashboard</h1>
			</div>
			<div class="card-body">
				<div class="">
					<button type="button" class="btn btn-primary btnTambahUser">Tambah User</button>
				</div>
				<div class="">
					<a href="<?= base_url('dashboard/logout'); ?>" class="btn btn-danger">logout</a>
				</div>
				<div class="table-user">
					<table class="table table-striped" id="tabelUser">
						<thead>
							<tr>
								<th>No</th>
								<th>Username</th>
								<th>Password</th>
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

	<div class="modal" id="modal-user" tabindex=" -1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tambah User</h5>
					<button type="button" class="close " data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-user">
						<form action="#" method="post" enctype="multipart/form-data">
							<div class="mb-1">
								<label for="id" class="form-label">ID</label>
								<input type="text" class="form-control" id="id" name="id" value="">
								<div class="error-block"></div>
							</div>
							<div class="mb-1">
								<label for="username" class="form-label">Username</label>
								<input type="text" class="form-control" id="username" name="username" value="">
								<div class="error-block"></div>
							</div>
							<div class="mb-1">
								<label for="password" class="form-label">Password</label>
								<input type="text" class="form-control" id="password" name="password" value="">
								<div class="error-block"></div>
							</div>


						</form>

						<div>

						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary saveBtn">Simpan</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>



	<script src="<?php echo base_url('public/template/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('public/template/js/jquery-3.7.1.min.js'); ?>"></script>


	<script>
		$(document).ready(function() {

			tableUser();
			$('.btnTambahUser').on('click', function() {
				$('#modal-user').modal('show');
			})

			$('.saveBtn').on('click', function() {
				var id = $('#id').val();
				var username = $('#username').val();
				var password = $('#password').val();
				let url = '<?php echo base_url('dashboard/save'); ?>';

				$.ajax({
					url: url,
					type: 'POST',
					data: {
						id: id,
						username: username,
						password: password
					},
					dataType: 'json',
					success: function(response) {
						if (response.status) {
							alert(response.message);
							$('#modal-user').modal('hide');
							tableUser();
						} else {
							alert(response.message);
						}
					}
				});
			})


		});

		function tableUser() {
			let tabelUser = $('#tabelUser');
			$.ajax({
				url: '<?php echo base_url('dashboard/tableUser'); ?>',
				type: 'GET',

				dataType: 'json',
				success: function(response) {
					if (response.status) {
						tabelUser.find('tbody').html('');
						let no = 1;
						$.each(response.data, function(i, item) {
							let tr = $('<tr>');
							tr.append('<td>' + no++ + '</td>');
							tr.append('<td>' + item.username + '</td>');
							tr.append('<td>' + item.password + '</td>');
							tr.append('<td>	<button class="btn btn-primary" onclick="editUser(' + item.id + ')">Edit</button> <button class="btn btn-danger" onclick="deleteUser(' + item.id + ')">Delete</button></td>');
							tabelUser.find('tbody').append(tr);
						});

					} else {
						tabelUser.find('tbody').html('');
						tr.append('<td colspan="4">' + response.message + '</td>');
					}
				}
			});
		}

		function editUser(id) {
			$.ajax({
				url: '<?php echo base_url('dashboard/edit'); ?>',
				type: 'POST',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						$('#id').val(response.data.id);
						$('#username').val(response.data.username);
						$('#password').val(response.data.password);
						$('#modal-user').modal('show');
					} else {
						alert(response.message);
					}
				}
			});
		}

		function deleteUser(id) {
			let url = '<?php echo base_url('dashboard/delete'); ?>';
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						alert(response.message);
						tableUser();
					} else {
						alert(response.message);
					}
				}
			});
		}
	</script>
</body>

</html>