<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
    <link href="<?= base_url('public/template/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="row justify-content-center pt-5">
        <div class="card col-md-4">
            <div class="card-header">
                <div class="card-title fw-bold">Sign In</div>
            </div>
            <div class="card-body">
                <form id="loginForm" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                        <div id="usernameError" class="error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div id="passwordError" class="error"></div>
                    </div>

                    <button type="button" id="loginBtn" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#loginBtn').click(function () {
                $('#usernameError').text('');
                $('#passwordError').text('');

                const username = $('#username').val().trim();
                const password = $('#password').val().trim();
                let hasError = false;

                if (!username) {
                    $('#usernameError').text('Username harus diisi');
                    hasError = true;
                }

                if (!password) {
                    $('#passwordError').text('Password harus diisi');
                    hasError = true;
                }

                if (!hasError) {
                    $.ajax({
                        url: "<?= site_url('login/proses_login'); ?>",
                        method: "POST",
                        data: { username, password },
                        dataType: "json",
                        success: function (response) {
                            if (response.status) {
                                window.location.href = "<?= site_url('dashboard'); ?>";
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
