<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #003366 0%, #005599 50%, #ffd700 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        body::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png') no-repeat center;
            background-size: contain;
            opacity: 0.05;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png') no-repeat center;
            background-size: contain;
            opacity: 0.05;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,215,0,0.1)" stroke-width="2"/></svg>');
            opacity: 0.3;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .logo-circle img {
            width: 70px;
            height: 70px;
        }

        .login-header h1 {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: 3rem 2.5rem;
        }

        .form-label {
            color: #003366;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ffd700;
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            outline: none;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.2rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.3);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #005599, #003366);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #999;
            position: relative;
            z-index: 1;
        }

        .form-check {
            margin: 1rem 0;
        }

        .form-check-input:checked {
            background-color: #003366;
            border-color: #003366;
        }

        .form-check-label {
            color: #666;
        }

        .forgot-password {
            text-align: right;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #005599;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #003366;
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 2rem;
        }

        .back-home a {
            color: #005599;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-home a:hover {
            color: #003366;
            gap: 0.8rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ffebee 0%, #fef1f1 100%);
            color: #c62828;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            z-index: 10;
            font-size: 1.2rem;
        }

        .password-toggle:hover {
            color: #003366;
        }

        @media (max-width: 576px) {
            .login-card {
                border-radius: 20px;
            }
            
            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }

            .logo-circle {
                width: 80px;
                height: 80px;
            }

            .logo-circle img {
                width: 55px;
                height: 55px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-circle">
                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png" alt="Logo Unair">
                </div>
                <h1>RSHP Unair</h1>
                <p>Rumah Sakit Hewan Pendidikan</p>
            </div>

            <div class="login-body">
                <!-- Alert Error (Hidden by default) -->
                <!-- <div class="alert alert-danger" role="alert">
                    <strong>⚠️ Login Gagal!</strong><br>
                    Username atau password yang Anda masukkan salah.
                </div> -->

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email / Username</label>
                        <div class="input-icon position-relative">
                            <input type="text" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Masukkan email atau username"
                                   required
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">🔒 Password</label>
                        <div class="input-icon position-relative">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password"
                                   required>
                            <span class="password-toggle" onclick="togglePassword()">👁️</span>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               value="" 
                               id="remember"
                               name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        🔑 Login
                    </button>

                    <div class="forgot-password">
                        <a href="#">Lupa Password?</a>
                    </div>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="back-home">
                    <a href="{{ route('home') }}">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem;">
                &copy; 2025 RSHP Universitas Airlangga. All Rights Reserved.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        // Handle form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('⚠️ Mohon lengkapi semua field!');
            }
        });
    </script>
</body>
</html>