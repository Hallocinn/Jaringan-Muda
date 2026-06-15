<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌿 {{ $title ?? 'Meristem.pedia' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        #sidebar {
            background-color: #14532d !important;
            color: #f0fdf4 !important;
            border-right: none !important;
        }

        #sidebar a,
        #sidebar button {
            box-shadow: none !important;
            font-size: 13px;
        }

        #sidebar.sidebar-mini {
            width: 90px !important;
            min-width: 90px !important;
        }

        #sidebar.sidebar-mini .sidebar-brand,
        #sidebar.sidebar-mini .menu-label,
        #sidebar.sidebar-mini .menu-text,
        #sidebar.sidebar-mini .arrow-icon,
        #sidebar.sidebar-mini .submenu {
            display: none !important;
        }

        #sidebar.sidebar-mini nav {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }

        #sidebar.sidebar-mini .menu-link-item,
        #sidebar.sidebar-mini .submenu-toggle-btn {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .menu-label {
            color: rgba(187, 247, 208, 0.65) !important;
            font-size: 11px;
        }

        .menu-link {
            color: #bbf7d0 !important;
            background-color: transparent !important;
        }

        .menu-link i {
            color: #bbf7d0 !important;
            font-size: 14px;
        }

        .menu-link:hover,
        .menu-active {
            background-color: #15803d !important;
            color: #ffffff !important;
        }

        .menu-link:hover i,
        .menu-active i {
            color: #ffffff !important;
        }

        .submenu {
            display: none !important;
            background-color: rgba(21, 128, 61, 0.4) !important;
            border-radius: 12px;
            margin-top: 5px;
            padding: 6px 5px;
        }

        .submenu.open {
            display: block !important;
        }

        .submenu a {
            color: #bbf7d0 !important;
            padding: 10px 15px !important;
            font-size: 13px;
            border-radius: 8px;
        }

        .submenu a:hover,
        .submenu-active {
            background-color: #15803d !important;
            color: #ffffff !important;
            font-weight: 600;
        }

        .arrow-icon {
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        .arrow-icon.rotate {
            transform: rotate(180deg);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: #fee2e2 !important;
            color: #ef4444 !important;
            border: 1px solid #fca5a5 !important;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn i {
            color: #ef4444 !important;
            font-size: 14px;
        }

        .logout-btn:hover {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            border-color: #ef4444 !important;
            transform: translateY(-1px);
        }

        .logout-btn:hover i {
            color: #ffffff !important;
        }

        .swal2-popup.logout-swal-popup,
        .swal2-popup.success-swal-popup {
            border-radius: 16px !important;
            font-family: 'Poppins', sans-serif !important;
            padding: 24px !important;
        }

        .swal2-title.logout-swal-title,
        .swal2-title.success-swal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
        }

        .swal2-html-container.logout-swal-text,
        .swal2-html-container.success-swal-text {
            font-size: 14px !important;
            color: #475569 !important;
            line-height: 1.6 !important;
        }

        .swal2-confirm.logout-swal-confirm,
        .swal2-cancel.logout-swal-cancel,
        .swal2-confirm.success-swal-confirm {
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 12px 20px !important;
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>

<body class="bg-[#f0fdf4] text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <div id="mobileOverlay"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden"
         onclick="toggleSidebar()">
    </div>

    <aside id="sidebar"
           class="w-[260px] min-w-[260px] flex flex-col fixed inset-y-0 left-0 z-50 -translate-x-full transition-all duration-300 ease-in-out lg:translate-x-0 lg:static">

        <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
            <span class="sidebar-brand text-xl font-extrabold tracking-wider text-white">
                MENU
            </span>

            <button type="button"
                    class="w-10 h-10 flex items-center justify-center border border-white/15 rounded-xl text-[#bbf7d0] hover:text-white hover:bg-white/10 transition-all"
                    onclick="toggleSidebar()">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <nav class="sidebar-scroll flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <p class="menu-label px-3 font-bold tracking-widest uppercase mb-3 mt-2">Menu Utama</p>

            <a href="{{ route('guru.dashboard') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.dashboard') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-house"></i>
                <span class="menu-text">Beranda</span>
            </a>

            <a href="{{ route('guru.siswa') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.siswa') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-user-group w-5 text-center"></i>
                <span class="menu-text">Data Siswa</span>
            </a>

            <p class="menu-label px-3 font-bold tracking-widest uppercase mb-3 mt-6">Akademik</p>

            @php
                $isSoalActive = request()->is('guru/kuis*') || request()->is('guru/evaluasi*');
            @endphp

            <div class="space-y-2">
                <button type="button"
                        onclick="toggleSubmenu('soalSubmenu', 'soalArrow')"
                        class="submenu-toggle-btn w-full flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ $isSoalActive ? 'menu-active' : 'menu-link' }}">
                    <i class="fa-solid fa-book w-5 text-center"></i>
                    <span class="menu-text flex-1 text-left">Bank Soal</span>
                    <i id="soalArrow" class="fa-solid fa-chevron-down arrow-icon {{ $isSoalActive ? 'rotate' : '' }}"></i>
                </button>

                <div id="soalSubmenu" class="submenu {{ $isSoalActive ? 'open' : '' }} mt-2 pl-5 space-y-2">
                    <a href="{{ route('guru.kuis.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('guru.kuis.*') ? 'submenu-active' : '' }}">
                        <i class="fa-solid fa-stopwatch w-4 text-center text-xs"></i>
                        <span>Kelola Kuis</span>
                    </a>

                    <a href="{{ route('guru.evaluasi.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('guru.evaluasi.*') ? 'submenu-active' : '' }}">
                        <i class="fa-solid fa-clipboard-check w-4 text-center text-xs"></i>
                        <span>Kelola Evaluasi</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('guru.monitoring') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.monitoring') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span class="menu-text">Ruang Diskusi</span>
            </a>

            <a href="{{ route('guru.nilai.index') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.nilai.*') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span class="menu-text">Rekap Nilai</span>
            </a>

            <a href="{{ route('guru.hasil_evaluasi') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.hasil_evaluasi') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-medal w-5 text-center"></i>
                <span class="menu-text">Hasil Evaluasi</span>
            </a>

            <a href="{{ route('guru.mengkomunikasikan') }}"
               class="menu-link-item flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('guru.mengkomunikasikan') ? 'menu-active' : 'menu-link' }}">
                <i class="fa-solid fa-brain w-5 text-center"></i>
                <span class="menu-text">Pemahaman Siswa</span>
            </a>

            <div class="mt-6 pt-4 border-t border-white/10">
                <button type="button"
                        onclick="konfirmasiKeluar()"
                        class="w-full flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all bg-red-100 text-red-600 hover:bg-red-500 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="menu-text">Keluar</span>
                </button>

                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 bg-[#f0fdf4] relative transition-all duration-300">
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative z-10">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('sidebar-mini');

                const soalSubmenu = document.getElementById('soalSubmenu');
                const soalArrow = document.getElementById('soalArrow');

                if (sidebar.classList.contains('sidebar-mini')) {
                    if (soalSubmenu) soalSubmenu.classList.remove('open');
                    if (soalArrow) soalArrow.classList.remove('rotate');
                }
            } else {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        function toggleSubmenu(submenuId, arrowId) {
            const sidebar = document.getElementById('sidebar');
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById(arrowId);

            if (sidebar.classList.contains('sidebar-mini')) {
                return;
            }

            submenu.classList.toggle('open');
            arrow.classList.toggle('rotate');
        }

        function konfirmasiKeluar() {
            Swal.fire({
                customClass: {
                    popup: 'logout-swal-popup',
                    title: 'logout-swal-title',
                    htmlContainer: 'logout-swal-text',
                    confirmButton: 'logout-swal-confirm',
                    cancelButton: 'logout-swal-cancel'
                },
                title: 'Konfirmasi Keluar',
                text: 'Apakah kamu yakin ingin keluar dari akun dan menyudahi sesi mengajar ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#15803d',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Kembali Mengajar',
                reverseButtons: true,
                backdrop: 'rgba(15, 23, 42, 0.6)'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.setItem('logout_success_message', 'Berhasil keluar!');
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                customClass: {
                    popup: 'success-swal-popup',
                    title: 'success-swal-title',
                    htmlContainer: 'success-swal-text',
                    confirmButton: 'success-swal-confirm'
                },
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#15803d',
                confirmButtonText: 'Oke',
                backdrop: 'rgba(15, 23, 42, 0.6)'
            });
        </script>
    @endif

</body>
</html>