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
                <h1>Halaman Dashboard</h1>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button class="btn btn-primary" id="btn-add-user">Tambah User</button>
                </div>

                <div><a href="<?php echo base_url('login/logout'); ?>">Logout</a></div>

                <div class="table-user">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($users as $user) :
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->password ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-edit-user" data-id="<?= $user->id ?>" data-username="<?= $user->username ?>">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteUser(<?= $user->id ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-username">Username</label>
                        <input type="text" id="add-username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="add-password">Password</label>
                        <input type="password" id="add-password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-user">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-user-id">
                    <div class="form-group">
                        <label for="edit-username">Username</label>
                        <input type="text" id="edit-username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Password</label>
                        <input type="password" id="edit-password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-user">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('public/template/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/template/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        $(document).ready(function () {
            // Open Add User Modal
            $('#btn-add-user').click(function () {
                $('#addUserModal').modal('show');
            });

            // Save User
            $('#save-user').click(function () {
                const username = $('#add-username').val();
                const password = $('#add-password').val();

                $.ajax({
                    url: "<?= base_url('dashboard/save_ajax'); ?>",
                    method: "POST",
                    data: { username, password },
                    success: function () {
                        alert('User added successfully');
                        $('#addUserModal').modal('hide');
                        location.reload();
                    }
                });
            });

            // Open Edit User Modal
            $('.btn-edit-user').click(function () {
                const id = $(this).data('id');
                const username = $(this).data('username');
                console.log('Edit button clicked for ID: ' + id + ' and Username: ' + username); // Debugging log

                $('#edit-user-id').val(id);
                $('#edit-username').val(username);
                $('#editUserModal').modal('show');
            });

            // Update User
            $('#update-user').click(function () {
                const id = $('#edit-user-id').val();
                const username = $('#edit-username').val();
                const password = $('#edit-password').val();

                $.ajax({
                    url: "<?= base_url('dashboard/update_ajax'); ?>",
                    method: "POST",
                    data: { id, username, password },
                    success: function () {
                        alert('User updated successfully');
                        $('#editUserModal').modal('hide');
                        location.reload();
                    }
                });
            });
        });

        // Delete User
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: "<?= base_url('dashboard/delete_ajax/'); ?>" + id,
                    method: "POST",
                    success: function () {
                        alert('User deleted successfully');
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>

</html>
