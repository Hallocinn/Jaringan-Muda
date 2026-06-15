<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Siswa | Meristem.Pedia</title>
     @vite(['resources/css/app.css', 'resources/css/logo.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        background-color: #f8fafc;
        overflow-x: hidden;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 32px;
        background: #14532d;
        color: white;
        box-shadow: 0 2px 8px rgba(20,83,45,0.15);
        border-bottom: 1px solid #15803d;
    }

    .logo-text {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .user-info {
        text-align: right;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: #ffffff;
    }

    .user-role {
        font-size: 12px;
        color: #bbf7d0;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background-color: #fee2e2;
        color: #ef4444;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .logout-btn:hover {
        background-color: #ef4444;
        color: white;
        border-color: #ef4444;
        transform: translateY(-1px);
    }

    /* ISI HALAMAN */
    .main-content {
        padding: 36px 32px 22px;
        min-height: calc(100vh - 150px);
        box-sizing: border-box;
    }

    .welcome-card {
        background: white;
        border-radius: 22px;
        padding: 22px 28px;
        margin-top: 14px;
        margin-bottom: 18px;
        border: 1px solid #dcfce7;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 18px;
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -45px;
        right: -45px;
        width: 145px;
        height: 145px;
        background: #22c55e;
        border-radius: 50%;
        opacity: 0.05;
        pointer-events: none;
    }

    .avatar {
        width: 64px;
        height: 64px;
        background: #dcfce7;
        color: #16a34a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 600;
        border: 4px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    .welcome-text h1 {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 6px 0;
        line-height: 1.25;
    }

    .welcome-text h1 span {
        color: #16a34a;
    }

    .welcome-text p {
        color: #64748b;
        font-size: 14px;
        max-width: 540px;
        margin: 0;
        line-height: 1.55;
    }

    /* CARD */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #bbf7d0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 315px;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .card-icon {
        height: 125px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 54px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #16a34a;
    }

    .card-content {
        padding: 18px 22px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 17px;
        font-weight: 600;
        color: #14532d;
        margin: 0 0 8px 0;
    }

    .card-desc {
        color: #64748b;
        font-size: 13px;
        margin: 0 0 14px 0;
        line-height: 1.45;
        flex: 1;
    }

    .card-btn {
        display: inline-block;
        box-sizing: border-box;
        width: 100%;
        padding: 11px 20px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        background: #15803d;
        color: white;
        border: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }

    .card-btn:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
    }

    .footer {
        padding: 24px 32px;
        text-align: center;
        color: #f0fdf4;
        font-size: 13px;
        border-top: 1px solid #15803d;
        background: #14532d;
    }

    .footer span {
        font-weight: 600;
        color: #bbf7d0;
    }

    .swal2-popup {
        border-radius: 16px !important;
        font-family: 'Poppins', sans-serif !important;
        padding: 24px !important;
    }

    .swal2-title {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
    }

    .swal2-html-container {
        font-size: 14px !important;
        color: #475569 !important;
        line-height: 1.6 !important;
    }

    .swal2-confirm,
    .swal2-cancel {
        border-radius: 12px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        padding: 12px 20px !important;
    }

    @media (max-width: 992px) {
        .card-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .card {
            min-height: 310px;
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 16px;
            gap: 14px;
        }

        .header-right {
            gap: 14px;
        }

        .user-info {
            display: none;
        }

        .main-content {
            padding: 28px 16px 22px;
            min-height: calc(100vh - 150px);
        }

        .welcome-card {
            flex-direction: column;
            text-align: center;
            padding: 22px;
            margin-top: 10px;
            margin-bottom: 16px;
        }

        .welcome-text h1 {
            font-size: 22px;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .card {
            min-height: auto;
        }

        .card-icon {
            height: 120px;
            font-size: 50px;
        }
    }
</style>    
</head>

<body>
    <header class="header">
        <div class="header-left">
        @include('layouts.logo')
        </div>

        <div class="header-right">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Siswa / Peserta Didik</div>
            </div>

            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf

                <button type="button" onclick="konfirmasiKeluar()" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <main class="main-content">
        <div class="welcome-card">
            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <div class="welcome-text">
                <h1>Halo, <span>{{ Auth::user()->name }}</span>! 👋</h1>
                <p>Selamat datang di dashboard e-learning. Silakan pilih menu di bawah ini untuk memulai aktivitas belajarmu hari ini.</p>
            </div>
        </div>

        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-microscope"></i>
                </div>

                <div class="card-content">
                    <h3 class="card-title">Materi Pembelajaran</h3>
                    <p class="card-desc">Pelajari visualisasi struktur & fungsi jaringan, kerjakan kuis, dan masuk ke ruang diskusi.</p>
                    <a href="{{ route('materi.index') }}" class="card-btn">Materi</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-list-check"></i>
                </div>

                <div class="card-content">
                    <h3 class="card-title">Kurikulum</h3>
                    <p class="card-desc">Lihat rincian capaian pembelajaran dan tujuan instruksional yang harus dicapai.</p>
                    <a href="{{ route('kurikulum') }}" class="card-btn">Kurikulum</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-circle-info"></i>
                </div>

                <div class="card-content">
                    <h3 class="card-title">Petunjuk</h3>
                    <p class="card-desc">Lihat petunjuk penggunaan media pembelajaran agar kegiatan pembelajaran dapat dilakukan secara optimal.</p>
                    <a href="{{ route('informasi') }}" class="card-btn">Petunjuk</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        © {{ date('Y') }} Sistem Pembelajaran | <span>Universitas Lambung Mangkurat</span>
    </footer>

    <script>
        const swalConfig = {
            customClass: {
                popup: 'rounded-2xl',
                title: 'text-lg font-bold',
                htmlContainer: 'text-sm'
            },
            backdrop: 'rgba(15, 23, 42, 0.6)'
        };

        function konfirmasiKeluar() {
            Swal.fire({
                ...swalConfig,
                title: 'Konfirmasi Keluar',
                text: 'Apakah Kamu yakin ingin keluar dari akun dan menyudahi sesi belajar ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#15803d',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Kembali Belajar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const logoutForm = document.getElementById('logoutForm');

                    if (logoutForm) {
                        localStorage.setItem('logout_success_message', 'Berhasil keluar!');
                        logoutForm.submit();
                    }
                }
            });
        }
    </script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#15803d',
                confirmButtonText: 'Oke',
                backdrop: 'rgba(15, 23, 42, 0.6)'
            });
        });
    </script>
@endif

</body>
</html>