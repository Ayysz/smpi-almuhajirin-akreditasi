<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi Kegiatan Kesiswaan</title>
    <link rel="icon" href="<?= base_url('logo-sekolah.png') ?>" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-header login-header text-center py-4">
                        <h3 class="mb-0"><i class="bi bi-mortarboard-fill"></i> SI Kesiswaan</h3>
                        <p class="mb-0 small">Sistem Informasi Kegiatan Kesiswaan</p>
                    </div>
                    <div class="card-body p-4">
                        <div id="alert-message"></div>
                        <form id="formLogin">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="btnLogin">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#togglePassword').click(function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });

        $('#formLogin').submit(function(e) {
            e.preventDefault();
            
            // Disable button
            $('#btnLogin').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Loading...');
            
            // Get form data
            var formData = $(this).serialize();
            
            // Debug - tampilkan data yang dikirim
            console.log('Form Data:', formData);
            console.log('Username:', $('#username').val());
            console.log('Password:', $('#password').val());
            
            $.ajax({
                url: '<?= base_url('auth/login') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response);
                    
                    if (response.status == 'success') {
                        $('#alert-message').html('<div class="alert alert-success"><i class="bi bi-check-circle"></i> ' + response.message + '</div>');
                        setTimeout(function() {
                            window.location.href = '<?= base_url('dashboard') ?>';
                        }, 1000);
                    } else {
                        $('#alert-message').html('<div class="alert alert-danger"><i class="bi bi-x-circle"></i> ' + response.message + '</div>');
                        $('#btnLogin').prop('disabled', false).html('<i class="bi bi-box-arrow-in-right"></i> Login');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('Response:', xhr.responseText);
                    
                    $('#alert-message').html('<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> Error: ' + error + '<br>Cek console untuk detail</div>');
                    $('#btnLogin').prop('disabled', false).html('<i class="bi bi-box-arrow-in-right"></i> Login');
                }
            });
        });
    </script>
</body>
</html>
