<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - E-Learning</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'custom-dark-green': '#14532d',
                        'custom-mid-green': '#15803d',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-emerald-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white/80 backdrop-blur-lg rounded-3xl shadow-[0_20px_50px_rgba(21,_128,_61,_0.07)] border border-white p-8 sm:p-10">
        
        <a href="/" 
           class="inline-flex items-center gap-2 text-sm font-semibold text-custom-dark-green hover:text-custom-mid-green transition-colors mb-6">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-custom-mid-green mb-4 shadow-inner">
                <i class="fa-solid fa-graduation-cap text-3xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">Selamat Datang</h1>
            <p class="text-gray-500 mt-2 text-sm sm:text-base">Silakan masuk untuk melanjutkan belajarmu.</p>
        </div>

        <form method="post" action="{{ route('login.auth') }}" class="space-y-5">
            @csrf

            <div>
                <label for="nip_nisn" class="block text-sm font-semibold text-gray-700 mb-1.5">NIP / NISN</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-id-badge text-gray-400"></i>
                    </div>

                    <input type="text" id="nip_nisn" name="nip_nisn" value="{{ old('nip_nisn') }}" required autofocus
                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border @error('nip_nisn') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-custom-mid-green focus:ring-custom-mid-green @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all duration-200 text-gray-800 placeholder-gray-400"
                        placeholder="Masukkan NIP atau NISN">
                </div>

                @error('nip_nisn')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>

                    <input type="password" id="password" name="password" required
                        class="w-full pl-11 pr-12 py-3.5 bg-gray-50/50 border @error('password') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-custom-mid-green focus:ring-custom-mid-green @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all duration-200 text-gray-800 placeholder-gray-400"
                        placeholder="••••••••">
                    
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-custom-mid-green transition-colors" onclick="togglePasswordVisibility()">
                        <i class="fa-regular fa-eye-slash text-lg" id="toggleIcon"></i>
                    </div>
                </div>

                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center pt-1">
                <input id="checkRemember" name="checkRemember" type="checkbox"
                    class="h-4 w-4 text-custom-mid-green focus:ring-custom-mid-green border-gray-300 rounded cursor-pointer transition-colors">

                <label for="checkRemember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                    Ingat Saya
                </label>
            </div>

            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-md text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-custom-mid-green to-custom-dark-green hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-mid-green transform hover:-translate-y-1 transition-all duration-300 mt-2">
                Masuk Sekarang
                <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
            </button>

            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register.show') }}" class="font-semibold text-custom-mid-green hover:text-custom-dark-green transition-colors underline decoration-2 underline-offset-4">
                    Daftar di sini
                </a>
            </p>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash", "text-gray-400");
                toggleIcon.classList.add("fa-eye", "text-custom-mid-green");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye", "text-custom-mid-green");
                toggleIcon.classList.add("fa-eye-slash", "text-gray-400");
            }
        }
    </script>
</body>
</html>