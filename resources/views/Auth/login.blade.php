<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Peminjaman</title>
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

        /* Animated background elements */
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

        /* Notification Toast */
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

        /* BAGIAN KIRI - ILUSTRASI */
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

        /* BAGIAN KANAN - FORM LOGIN */
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
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .subtitle {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 45px;
            text-align: center;
            font-weight: 300;
        }

        .input-group {
            width: 100%;
            margin-bottom: 25px;
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
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-signin {
            background: linear-gradient(135deg, #FFA500, #FF8C00);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }

        .btn-signin:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 165, 0, 0.4);
        }

        .btn-signin:active {
            transform: translateY(-1px);
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

        /* Responsive */
        @media (max-width: 768px) {
            .toast-container {
                left: 20px;
                right: 20px;
            }

            .toast {
                min-width: auto;
            }

            .card {
                flex-direction: column;
                max-width: 450px;
            }

            .left, .right {
                width: 100%;
            }

            .left {
                padding: 40px 30px;
                min-height: 300px;
            }

            .brand-section {
                position: static;
                margin-bottom: 30px;
            }

            .features {
                position: static;
                margin-top: 30px;
            }

            .feature-list {
                flex-direction: column;
                gap: 15px;
            }

            .right h1 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<div class="card">
    <!-- BAGIAN KIRI - ILUSTRASI -->
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
                <!-- Background circle -->
                <circle cx="250" cy="250" r="200" fill="#f0f4ff" opacity="0.5"/>
                
                <!-- Main screen/device -->
                <rect x="150" y="150" width="200" height="250" rx="15" fill="#ffffff" stroke="#667eea" stroke-width="4"/>
                
                <!-- Screen header -->
                <rect x="150" y="150" width="200" height="50" rx="15" fill="#667eea"/>
                <rect x="150" y="185" width="200" height="15" fill="#667eea"/>
                
                <!-- Lock icon on header -->
                <circle cx="250" cy="175" r="15" fill="#FFA500"/>
                <rect x="242" y="178" width="16" height="12" rx="2" fill="#FFA500"/>
                <path d="M 245 178 Q 245 172 250 172 Q 255 172 255 178" fill="none" stroke="#ffffff" stroke-width="2.5"/>
                <circle cx="250" cy="185" r="2" fill="#ffffff"/>
                
                <!-- Form elements inside screen -->
                <rect x="170" y="220" width="160" height="15" rx="7" fill="#e0e7ff"/>
                <rect x="170" y="245" width="160" height="15" rx="7" fill="#e0e7ff"/>
                
                <!-- Button -->
                <rect x="200" y="280" width="100" height="30" rx="15" fill="#667eea"/>
                <text x="250" y="300" text-anchor="middle" fill="#ffffff" font-size="12" font-weight="600">Login</text>
                
                <!-- Checkmark icon -->
                <circle cx="320" cy="180" r="18" fill="#4ade80"/>
                <path d="M 313 180 L 318 185 L 327 175" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                
                <!-- Shield icon -->
                <path d="M 200 155 L 200 170 Q 200 180 210 185 Q 200 180 200 190 L 200 205 Q 200 215 190 210 L 190 155 Z" fill="#764ba2" opacity="0.7"/>
                <path d="M 190 155 Q 190 150 195 150 Q 200 150 200 155" fill="#764ba2" opacity="0.7"/>
                
                <!-- Person avatar -->
                <circle cx="210" cy="350" r="28" fill="#667eea"/>
                <circle cx="210" cy="345" r="12" fill="#ffffff"/>
                <path d="M 195 365 Q 195 358 210 358 Q 225 358 225 365 L 225 375 Q 225 380 210 380 Q 195 380 195 375 Z" fill="#ffffff"/>
                
                <!-- Floating elements -->
                <circle cx="380" cy="220" r="10" fill="#FFA500" opacity="0.6">
                    <animate attributeName="cy" values="220;210;220" dur="3s" repeatCount="indefinite"/>
                </circle>
                <circle cx="120" cy="280" r="15" fill="#764ba2" opacity="0.4">
                    <animate attributeName="cy" values="280;270;280" dur="4s" repeatCount="indefinite"/>
                </circle>
                <circle cx="370" cy="340" r="8" fill="#4ade80" opacity="0.5">
                    <animate attributeName="cy" values="340;330;340" dur="3.5s" repeatCount="indefinite"/>
                </circle>
                
                <!-- Document/book icon -->
                <rect x="310" y="360" width="50" height="60" rx="5" fill="#667eea" opacity="0.8"/>
                <line x1="320" y1="375" x2="350" y2="375" stroke="#ffffff" stroke-width="2"/>
                <line x1="320" y1="385" x2="350" y2="385" stroke="#ffffff" stroke-width="2"/>
                <line x1="320" y1="395" x2="340" y2="395" stroke="#ffffff" stroke-width="2"/>
                
                <!-- Stars decoration -->
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

    <!-- BAGIAN KANAN - FORM LOGIN -->
    <div class="right">
        <h1>Selamat Datang!</h1>
        <p class="subtitle">Silakan masuk ke akun Anda</p>

        <form method="POST" action="{{ route('login') }}" style="width: 100%;" id="loginForm">
            @csrf

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="username" id="username" placeholder="Username" class="input" required autofocus>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Password" class="input" required>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-signin">
                <span>Masuk</span>
            </button>

            <div class="form-footer">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Function untuk menampilkan toast notification
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
        
        // Auto close setelah 5 detik
        setTimeout(() => {
            closeToast(toast.querySelector('.toast-close'));
        }, 5000);
    }

    // Function untuk menutup toast
    function closeToast(element) {
        const toast = element.closest('.toast');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 400);
    }

    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-toggle');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Client-side validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');

        // Reset error states
        usernameInput.classList.remove('error');
        passwordInput.classList.remove('error');

        // Validasi kosong
        if (!username || !password) {
            e.preventDefault();
            showToast('Login Gagal!', 'Username dan Password tidak boleh kosong!');
            
            if (!username) usernameInput.classList.add('error');
            if (!password) passwordInput.classList.add('error');
        }
    });

    // Tampilkan toast jika ada error dari Laravel
    @if($errors->any())
        @if($errors->has('login'))
            showToast('Login Gagal!', '{{ $errors->first('login') }}');
        @else
            showToast('Login Gagal!', '{{ $errors->first() }}');
        @endif
        document.getElementById('username').classList.add('error');
        document.getElementById('password').classList.add('error');
    @endif

    // Tampilkan toast jika ada session error
    @if(session('error'))
        showToast('Login Gagal!', '{{ session('error') }}');
        document.getElementById('username').classList.add('error');
        document.getElementById('password').classList.add('error');
    @endif
</script>

</body>
</html>
