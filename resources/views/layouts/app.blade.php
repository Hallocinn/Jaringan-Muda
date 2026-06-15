<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌿 {{ $title ?? 'Meristem.pedia' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ========================================================
           OVERRIDE TEMA SIDEBAR SISWA MENJADI HIJAU (TEMA GURU)
           ======================================================== */
        
        /* Background Utama Sidebar (Hijau Gelap Dasar) */
        #sidebar {
            background-color: #14532d !important; 
            color: #f0fdf4 !important; /* Teks putih kehijauan cerah */
            border-right: none !important;
        }

        /* Logo Belajar.ID */
        #sidebar .logo {
            color: #ffffff !important;
            font-weight: 800 !important;
            letter-spacing: 1px;
        }

        /* Tombol Toggle Sidebar */
        #sidebar #toggleBtn {
            color: #f0fdf4 !important;
        }

        /* Teks Menu Normal */
        #sidebar .menu a, #sidebar .submenu-toggle {
            color: #bbf7d0 !important; /* Hijau muda pudar agar kontras */
            background-color: transparent !important;
            border-radius: 12px !important;
            transition: all 0.3s ease;
            margin-bottom: 4px;
        }

        /* Icon Menu Normal */
        #sidebar .menu a i, #sidebar .submenu-toggle i {
            color: #bbf7d0 !important; 
        }

        /* Efek Hover (Saat kursor di atas menu - Menggunakan Hijau Perintilan) */
        #sidebar .menu a:hover, #sidebar .submenu-toggle:hover {
            background-color: #15803d !important; 
            color: #ffffff !important;
        }
        
        #sidebar .menu a:hover i, #sidebar .submenu-toggle:hover i {
            color: #ffffff !important;
        }

        /* Menu Aktif / Tombol Nyala (Menggunakan Hijau Perintilan - BAYANGAN DIHAPUS) */
        #sidebar .menu a.active, #sidebar .submenu-toggle.active {
            background-color: #15803d !important; 
            color: #ffffff !important;
            box-shadow: none !important; /* Menghilangkan bayangan di bawah menu aktif */
        }

        /* Icon pada Menu Aktif menjadi putih */
        #sidebar .menu a.active i, #sidebar .submenu-toggle.active i {
            color: #ffffff !important;
        }

        /* ========================================================
           PERBAIKAN KOTAK DROPDOWN SUBMENU (HILANG TOTAL JIKA TERTUTUP)
           ======================================================== */
        #sidebar .submenu {
            display: none !important; /* Sembunyikan total secara default agar tidak meninggalkan sisa kotak hijau */
            background-color: rgba(21, 128, 61, 0.4) !important; /* Transparansi berbasis hijau perintilan */
            border-radius: 12px;
            margin-top: 5px;
            padding: 6px 5px;
        }

        /* Tampilkan kembali kotak hanya ketika subbab dibuka/open */
        #sidebar .submenu.open {
            display: block !important;
        }

        /* Teks Submenu Normal */
        #sidebar .submenu a {
            color: #bbf7d0 !important;
            padding: 10px 15px !important;
        }

        /* Submenu Hover */
        #sidebar .submenu a:hover {
            background-color: #15803d !important; 
            color: #ffffff !important;
        }

        /* Submenu Aktif */
        #sidebar .submenu a.active {
            color: #ffffff !important;
            background-color: #15803d !important; 
            font-weight: 600;
        }
        
        /* Garis Pembatas Tombol Keluar */
        #sidebar .menu li[style*="border-top"] {
            border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
        }

        /* ========================================================
           STYLING TOMBOL KELUAR MERAH SESUAI MINTAAN
           ======================================================== */
        .logout-menu-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: calc(100% - 10px);
            margin: 0 auto;
            padding: 8px 16px;
            background-color: #fee2e2 !important; /* Latar merah muda */
            color: #ef4444 !important; /* Teks merah */
            border: 1px solid #fca5a5 !important; /* Border merah muda */
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-menu-btn i {
            color: #ef4444 !important; /* Ikon merah */
            font-size: 14px;
        }

        .logout-menu-btn:hover {
            background-color: #fecaca !important; /* Merah sedikit gelap saat hover */
            border-color: #f87171 !important;
            transform: translateY(-1px);
        }

        #sidebar .menu li {
            list-style: none;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="logo">MENU</span>
            <button id="toggleBtn" type="button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <ul class="menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span class="menu-text">Beranda</span>
                </a>
            </li>

            <li class="menu-item-has-submenu">
                <button type="button" class="submenu-toggle {{ request()->is('materi*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    <span class="menu-text">Materi</span>
                    <i class="fa-solid fa-chevron-down arrow-icon {{ request()->is('materi*') ? 'rotate' : '' }}"></i>
                </button>

                <div class="submenu {{ request()->is('materi*') ? 'open' : '' }}">
                    <a href="{{ route('materi1') }}" class="{{ request()->routeIs('materi1*') ? 'active' : '' }}">Materi 1</a>
                    <a href="{{ route('materi2') }}" class="{{ request()->routeIs('materi2*') ? 'active' : '' }}">Materi 2</a>
                    <a href="{{ route('materi3') }}" class="{{ request()->routeIs('materi3*') ? 'active' : '' }}">Materi 3</a>
                </div>
            </li>

            <li>
                <a href="{{ route('evaluasi') }}" class="{{ request()->routeIs('evaluasi') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span class="menu-text">Evaluasi</span>
                </a>
            </li>
        </ul>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>

</body>
</html>