<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NVet Klinik Hewan</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-[linear-gradient(135deg,#ffffff,#f5f5f5)] font-sans">

    <div
        class="flex flex-col md:flex-row w-full max-w-[900px] bg-white rounded-2xl shadow-[0_20px_60px_rgba(133,94,65,0.15)] overflow-hidden animate-[slideUp_0.8s_ease-out]">

        <!-- LEFT -->
        <div class="md:flex-1 bg-gradient-to-br bg-white md:p-10 md:pt-0 pt-10 flex flex-col justify-center items-center">
            <div class="logo-animation flex items-center justify-center w-64 h-64 object-contain">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
            </div>
        </div>

        <!-- RIGHT -->
        <div class="flex-1 p-10 flex flex-col justify-center animate-[slideRight_0.8s_ease-out]">

            <div class="mb-10 justify-center text-center">
                <h2 class="text-2xl font-bold text-primary mb-2">NVet Clinic & Lab</h2>
                <p class="text-gray-500 text-sm">Sistem manajemen karyawan dan absensi</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label class="block font-semibold text-primary mb-2 text-sm">Email Address</label>
                    <input
                        class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 placeholder:text-gray-300"
                        type="email" id="email" name="email" placeholder="Email Anda">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-primary mb-2 text-sm">Password</label>
                    <input
                        class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 placeholder:text-gray-300"
                        type="password" id="password" name="password" placeholder="Password">
                </div>

                <div class="flex justify-between items-center mb-6 text-sm">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-primary"> Ingat saya
                    </label>
                    <a class="text-primary hover:opacity-80" href="#">Lupa password?</a>
                </div>

                <button
                    class="w-full py-4 bg-gradient-to-br from-primary to-primaryDark text-white rounded-xl font-semibold tracking-wide uppercase hover:-translate-y-1 transition shadow-lg">
                    Masuk
                </button>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a class="text-primary font-semibold hover:underline" href="{{ route('register') }}">Daftar</a>
                </p>
            </form>

        </div>
    </div>

</body>

</html>
