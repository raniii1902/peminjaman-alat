<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Peminjaman Laptop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            left: -250px;
            animation: float 15s infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 165, 0, 0.1);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            animation: float 20s infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 320px;
            max-width: 400px;
            animation: slideInRight 0.4s ease-out;
            border-left: 4px solid #ef4444;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast.hide {
            animation: slideOutRight 0.4s ease-out forwards;
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }

        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-icon i {
            color: #ef4444;
            font-size: 18px;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .toast-message {
            color: #6b7280;
            font-size: 13px;
        }

        .toast-close {
            cursor: pointer;
            color: #9ca3af;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            color: #1f2937;
        }

        .card {
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .left {
            width: 50%;
            background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
        }

        .left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="%23667eea" opacity="0.1"/></svg>');
            opacity: 0.4;
        }

        .brand-section {
            position: absolute;
            top: 40px;
            left: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .brand-text h2 {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text p {
            font-size: 11px;
            color: #999;
            font-weight: 500;
        }

        .illustration {
            width: 100%;
            max-width: 380px;
            position: relative;
            z-index: 1;
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .illustration svg {
            filter: drop-shadow(0 10px 20px rgba(102, 126, 234, 0.2));
        }

        .features {
            position: absolute;
            bottom: 40px;
            left: 50px;
            right: 50px;
        }

        .feature-list {
            display: flex;
            gap: 30px;
            justify-content: center;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-size: 13px;
            font-weight: 500;
        }

        .feature-item i {
            font-size: 16px;
        }

        .right {
            width: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 55px;
            position: relative;
        }

        .right::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .right h1 {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .subtitle {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 35px;
            text-align: center;
            font-weight: 300;
        }

        .input-group {
            width: 100%;
            margin-bottom: 20px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            z-index: 2;
        }

        .input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border-radius: 12px;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.98);
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .input::placeholder {
            color: #aaa;
            font-weight: 400;
        }

        .input:focus {
            background: #ffffff;
            border-color: #FFA500;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .input:focus + .input-icon {
            color: #667eea;
        }

        .input.error {
            border-color: #ff6b6b;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 16px;
            z-index: 2;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.6s, height 0.6s;
            transform: translate(-50%, -50%);
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-signin {
            background: linear-gradient(135deg, #FFA500 0%, #FF6B6B 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(255, 165, 0, 0.3);
        }

        .btn-signin:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 165, 0, 0.4);
        }

        .form-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }

        .form-footer a {
            color: #ffffff;
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .card {
                flex-direction: column;
            }

            .left,
            .right {
                width: 100%;
                padding: 40px 35px;
            }

            .features {
                position: relative;
                bottom: auto;
                left: auto;
                right: auto;
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .card {
                border-radius: 15px;
            }

            .left,
            .right {
                padding: 30px 25px;
            }

            .right h1 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

<div class="toast-container" id="toastContainer"></div>

<div class="card">
    <div class="left">
        <div class="brand-section">
            <div class="brand-icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="brand-text">
                <h2>Peminjaman Laptop</h2>
                <p>Sistem Peminjaman Laptop</p>
            </div>
        </div>

        <div class="illustration">
            <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                <circle cx="250" cy="250" r="200" fill="#f0f4ff" opacity="0.5"/>
                <rect x="150" y="150" width="200" height="250" rx="15" fill="#ffffff" stroke="#667eea" stroke-width="4"/>
                <rect x="150" y="150" width="200" height="50" rx="15" fill="#667eea"/>
                <rect x="150" y="185" width="200" height="15" fill="#667eea"/>
                <circle cx="250" cy="175" r="15" fill="#FFA500"/>
                <rect x="242" y="178" width="16" height="12" rx="2" fill="#FFA500"/>
                <path d="M 245 178 Q 245 172 250 172 Q 255 172 255 178" fill="none" stroke="#ffffff" stroke-width="2.5"/>
                <circle cx="250" cy="185" r="2" fill="#ffffff"/>
                <rect x="170" y="220" width="160" height="15" rx="7" fill="#e0e7ff"/>
                <rect x="170" y="245" width="160" height="15" rx="7" fill="#e0e7ff"/>
                <rect x="170" y="270" width="160" height="15" rx="7" fill="#e0e7ff"/>
                <rect x="200" y="305" width="100" height="30" rx="15" fill="#667eea"/>
                <circle cx="210" cy="340" r="25" fill="#667eea"/>
                <circle cx="210" cy="335" r="10" fill="#ffffff"/>
                <path d="M 200 350 Q 210 360 220 350" fill="#ffffff"/>
                <rect x="310" y="360" width="50" height="60" rx="5" fill="#667eea" opacity="0.8"/>
                <line x1="320" y1="375" x2="350" y2="375" stroke="#ffffff" stroke-width="2"/>
                <line x1="320" y1="385" x2="350" y2="385" stroke="#ffffff" stroke-width="2"/>
                <line x1="320" y1="395" x2="340" y2="395" stroke="#ffffff" stroke-width="2"/>
                <path d="M 140 200 L 143 206 L 149 207 L 144 212 L 146 218 L 140 215 L 134 218 L 136 212 L 131 207 L 137 206 Z" fill="#FFA500" opacity="0.7"/>
                <path d="M 360 280 L 363 286 L 369 287 L 364 292 L 366 298 L 360 295 L 354 298 L 356 292 L 351 287 L 357 286 Z" fill="#667eea" opacity="0.6"/>
            </svg>
        </div>

        <div class="features">
            <div class="feature-list">
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-bolt"></i>
                    <span>Fast</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Reliable</span>
                </div>
            </div>
        </div>
    </div>

    <div class="right">
        <h1>Buat Akun</h1>
        <p class="subtitle">Lengkapi data untuk membuat akun baru</p>

        <form method="POST" action="{{ route('register') }}" style="width: 100%;" id="registerForm">
            @csrf

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" class="input" required autofocus>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-user-tag input-icon"></i>
                    <input type="text" name="username" id="username" placeholder="Username" class="input" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Password" class="input" required>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" class="input" required>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation', this)"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-signin">
                <span>Daftar</span>
            </button>

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    function showToast(title, message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <div class="toast-close" onclick="closeToast(this)">
                <i class="fas fa-times"></i>
            </div>
        `;

        container.appendChild(toast);
        setTimeout(() => {
            closeToast(toast.querySelector('.toast-close'));
        }, 5000);
    }

    function closeToast(element) {
        const toast = element.closest('.toast');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 400);
    }

    function togglePassword(targetId, toggleEl) {
        const passwordInput = document.getElementById(targetId);
        if (!passwordInput) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleEl.classList.remove('fa-eye');
            toggleEl.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleEl.classList.remove('fa-eye-slash');
            toggleEl.classList.add('fa-eye');
        }
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const namaLengkap = document.getElementById('nama_lengkap');
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        namaLengkap.classList.remove('error');
        username.classList.remove('error');
        password.classList.remove('error');
        confirmPassword.classList.remove('error');

        if (!namaLengkap.value.trim() || !username.value.trim() || !password.value.trim() || !confirmPassword.value.trim()) {
            e.preventDefault();
            showToast('Registrasi Gagal!', 'Semua field wajib diisi.');
            if (!namaLengkap.value.trim()) namaLengkap.classList.add('error');
            if (!username.value.trim()) username.classList.add('error');
            if (!password.value.trim()) password.classList.add('error');
            if (!confirmPassword.value.trim()) confirmPassword.classList.add('error');
            return;
        }

        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            showToast('Registrasi Gagal!', 'Password dan konfirmasi tidak sama.');
            password.classList.add('error');
            confirmPassword.classList.add('error');
        }
    });

    @if($errors->any())
        showToast('Registrasi Gagal!', '{{ $errors->first() }}');
        @if($errors->has('nama_lengkap'))
            document.getElementById('nama_lengkap').classList.add('error');
        @endif
        @if($errors->has('username'))
            document.getElementById('username').classList.add('error');
        @endif
        @if($errors->has('password'))
            document.getElementById('password').classList.add('error');
            document.getElementById('password_confirmation').classList.add('error');
        @endif
    @endif
</script>

</body>
</html>
