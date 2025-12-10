<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NVet Klinik Hewan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #855E41;
            --primary-light: #A67C52;
            --primary-dark: #6B4423;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(133, 94, 65, 0.15);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 48px;
            backdrop-filter: blur(10px);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .logo-section h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .logo-section p {
            font-size: 16px;
            opacity: 0.9;
        }

        .benefits {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 40px;
            width: 100%;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }

        .benefit-item:nth-child(1) {
            animation-delay: 0.2s;
        }

        .benefit-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .benefit-item:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .benefit-text {
            flex: 1;
        }

        .benefit-text h3 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .benefit-text p {
            font-size: 14px;
            opacity: 0.8;
        }

        .register-right {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideInRight 0.8s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-size: 28px;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #999;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(133, 94, 65, 0.1);
        }

        .form-group input::placeholder {
            color: #ccc;
        }

        .form-group.error input {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 20px 0;
            font-size: 13px;
            color: #666;
        }

        .terms input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary-color);
            margin-top: 3px;
            flex-shrink: 0;
        }

        .terms a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(133, 94, 65, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee;
            border: 2px solid #fcc;
            color: #c00;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 100%;
                border-radius: 0;
            }

            .register-left {
                padding: 40px 30px;
                min-height: 300px;
            }

            .register-right {
                padding: 40px 30px;
                max-height: none;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-header h2 {
                font-size: 24px;
            }

            .logo {
                width: 80px;
                height: 80px;
                font-size: 40px;
            }

            .benefits {
                gap: 15px;
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <!-- Left Side -->
        <div class="register-left">
            <div class="logo-section">
                <div class="logo">🐾</div>
                <h1>NVet</h1>
                <p>Klinik Hewan Profesional</p>
            </div>

            <div class="benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">🔒</div>
                    <div class="benefit-text">
                        <h3>Data Aman</h3>
                        <p>Keamanan data Anda adalah prioritas kami</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">⚡</div>
                    <div class="benefit-text">
                        <h3>Cepat & Mudah</h3>
                        <p>Proses registrasi yang sederhana dan cepat</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🎯</div>
                    <div class="benefit-text">
                        <h3>Dukungan 24/7</h3>
                        <p>Tim kami siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="register-right">
            <div class="form-header">
                <h2>Daftar Sekarang</h2>
                <p>Bergabunglah dengan ribuan pengguna NVet</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group @error('name') error @enderror">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name">
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group @error('phone') error @enderror">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                            placeholder="Masukkan nomor telepon" autocomplete="tel">
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group @error('email') error @enderror">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Masukkan email Anda" required autocomplete="email">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group @error('password') error @enderror">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Buat password yang kuat"
                            required autocomplete="new-password">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group @error('password_confirmation') error @enderror">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi password Anda" required autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn-register">Buat Akun</button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
