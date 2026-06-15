<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - E-Learning</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white/80 backdrop-blur-lg rounded-3xl shadow-[0_20px_50px_rgba(20,83,45,0.10)] border border-green-100 p-8 sm:p-10 my-8">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-[#15803D] mb-4 shadow-inner">
                <i class="fa-solid fa-user-plus text-3xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#14532D] tracking-tight">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-2 text-sm sm:text-base">Lengkapi data diri untuk memulai belajar.</p>
        </div>

        <form method="post" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="namaInput" class="block text-sm font-semibold text-[#14532D] mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="namaInput" name="namaInput" value="{{ old('namaInput') }}" required
                        class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('namaInput') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 placeholder-gray-400"
                        placeholder="Masukkan nama lengkap">
                </div>
                @error('namaInput')
                    <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="emailInput" class="block text-sm font-semibold text-[#14532D] mb-1.5">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="emailInput" name="emailInput" value="{{ old('emailInput') }}" required
                        class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('emailInput') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 placeholder-gray-400"
                        placeholder="name@example.com">
                </div>
                @error('emailInput')
                    <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nip_nisn" class="block text-sm font-semibold text-[#14532D] mb-1.5">NIP / NISN</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-id-card text-gray-400"></i>
                        </div>
                        <input type="text" id="nip_nisn" name="nip_nisn" value="{{ old('nip_nisn') }}" required
                            class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('nip_nisn') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 placeholder-gray-400"
                            placeholder="Nomor identitas (NIP/NISN)">
                    </div>
                    @error('nip_nisn')
                        <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="roleInput" class="block text-sm font-semibold text-[#14532D] mb-1.5">Sebagai</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user-tag text-gray-400"></i>
                        </div>
                        <select id="roleInput" name="roleInput" required
                            class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('roleInput') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 appearance-none cursor-pointer">
                            <option value="">Pilih</option>
                            <option value="guru" {{ old('roleInput') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('roleInput') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    @error('roleInput')
                        <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="passwordInput" class="block text-sm font-semibold text-[#14532D] mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="passwordInput" name="passwordInput" required
                        class="w-full pl-11 pr-12 py-3 bg-gray-50/50 border @error('passwordInput') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 placeholder-gray-400"
                        placeholder="Buat kata sandi">
                    
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-[#15803D] transition-colors" onclick="togglePasswordVisibility('passwordInput', 'toggleIcon1')">
                        <i class="fa-regular fa-eye-slash text-lg" id="toggleIcon1"></i>
                    </div>
                </div>
                @error('passwordInput')
                    <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="passwordInput_confirmation" class="block text-sm font-semibold text-[#14532D] mb-1.5">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-shield-check text-gray-400"></i>
                    </div>
                    <input type="password" id="passwordInput_confirmation" name="passwordInput_confirmation" required
                        class="w-full pl-11 pr-12 py-3 bg-gray-50/50 border @error('passwordInput_confirmation') border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-[#15803D] focus:ring-[#15803D] @enderror rounded-xl focus:outline-none focus:ring-2 focus:bg-white transition-all text-gray-800 placeholder-gray-400"
                        placeholder="Ulangi kata sandi">
                    
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-[#15803D] transition-colors" onclick="togglePasswordVisibility('passwordInput_confirmation', 'toggleIcon2')">
                        <i class="fa-regular fa-eye-slash text-lg" id="toggleIcon2"></i>
                    </div>
                </div>
                @error('passwordInput_confirmation')
                    <p class="text-red-500 text-xs mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-md text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-[#15803D] to-[#14532D] hover:from-[#14532D] hover:to-[#15803D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#15803D] transform hover:-translate-y-1 transition-all duration-300 mt-6">
                Daftar Sekarang
                <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-[#15803D] hover:text-[#14532D] transition-colors underline decoration-2 underline-offset-4">Masuk di sini</a>
            </p>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash", "text-gray-400");
                toggleIcon.classList.add("fa-eye", "text-[#15803D]");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye", "text-[#15803D]");
                toggleIcon.classList.add("fa-eye-slash", "text-gray-400");
            }
        }
    </script>
</body>
</html>