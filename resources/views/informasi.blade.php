<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petunjuk | BELAJAR.ID</title>
    @vite(['resources/css/app.css', 'resources/css/logo.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f8fafc;
            color: #334155;
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
            color: #ffff;
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
            color: #ffff;
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

        .main-content {
            padding: 36px 32px;
            min-height: calc(100vh - 170px);
            box-sizing: border-box;
        }

        .section-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .section-title h2 {
            color: #0f172a;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .section-title p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .info-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .intro-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 24px 28px;
            margin-bottom: 24px;
            text-align: center;
        }

        .intro-card h3 {
            color: #14532d;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .intro-card p {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }

        .guide-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .guide-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 22px;
            transition: all 0.3s ease;
        }

        .guide-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .guide-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #dcfce7;
            color: #14532d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .guide-card h4 {
            color: #14532d;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .guide-card p {
            color: #475569;
            font-size: 14px;
            line-height: 1.65;
            margin: 0;
        }

        .step-box {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 24px 28px;
            margin-bottom: 24px;
        }

        .step-box h3 {
            color: #14532d;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 18px 0;
            border-left: 4px solid #16a34a;
            padding-left: 12px;
        }

        .step-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .step-list li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }

        .step-number {
            min-width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #15803d;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .note-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 5px solid #16a34a;
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 24px;
        }

        .note-box h4 {
            color: #14532d;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .note-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .note-box li {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
        }

        .btn-area {
            text-align: center;
            margin-top: 28px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-btn {
            display: inline-block;
            box-sizing: border-box;
            width: 100%;
            padding: 12px 24px;
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

        .swal2-popup{
            border-radius:16px !important;
            font-family:'Poppins',sans-serif !important;
            padding:24px !important;
        }

        .swal2-title{
            font-size:18px !important;
            font-weight:700 !important;
            color:#1e293b !important;
        }

        .swal2-html-container{
            font-size:14px !important;
            color:#475569 !important;
            line-height:1.6 !important;
        }

        .swal2-confirm,
        .swal2-cancel{
            border-radius:12px !important;
            font-size:14px !important;
            font-weight:600 !important;
            padding:12px 20px !important;
        }

        @media (max-width: 992px) {
            .guide-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .step-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header { padding: 16px; }
            .main-content { padding: 24px 16px; }
            .section-title h2 { font-size: 22px; }
            .guide-grid { grid-template-columns: 1fr; gap: 16px; }
            .guide-card { padding: 18px; }
            .intro-card { padding: 20px; }
            .step-box { padding: 20px; }
            .note-box { padding: 16px 18px; }
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
            <button type="button" class="logout-btn" onclick="konfirmasiKeluar()">
                <i class="fa-solid fa-right-from-bracket"></i>
                Keluar
            </button>
        </form>
    </div>
</header>

<main class="main-content">
    <div class="section-title">
        <h2>Petunjuk Penggunaan Aplikasi</h2>
        <p>Panduan singkat untuk membantu peserta didik menggunakan media pembelajaran Meristem.pedia.</p>
    </div>

    <div class="info-wrapper">
        <div class="intro-card">
            <h3>Selamat Datang di Meristem.pedia</h3>
            <p>
                Aplikasi ini digunakan untuk mempelajari struktur, fungsi, dan perkembangan jaringan muda tumbuhan.
                Peserta didik dapat membaca materi, mengikuti aktivitas pembelajaran, mengerjakan kuis, dan melihat hasil belajar melalui halaman materi.
            </p>
        </div>

        <div class="guide-grid">
            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-house"></i>
                </div>
                <h4>Beranda</h4>
                <p>
                    Halaman beranda menampilkan menu utama yang dapat digunakan untuk membuka kurikulum, materi pembelajaran, dan informasi petunjuk penggunaan aplikasi.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h4>Materi Pembelajaran</h4>
                <p>
                    Menu materi berisi pembahasan jaringan muda tumbuhan yang disusun secara bertahap agar lebih mudah dipahami.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <h4>Visualisasi</h4>
                <p>
                    Fitur visualisasi digunakan untuk membantu peserta didik memahami bentuk, struktur, dan perkembangan jaringan muda tumbuhan secara lebih jelas.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h4>Kuis</h4>
                <p>
                    Kuis digunakan untuk melatih pemahaman setelah peserta didik mempelajari materi yang tersedia pada aplikasi.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <h4>Hasil Belajar</h4>
                <p>
                    Hasil belajar dapat digunakan untuk melihat perkembangan pemahaman peserta didik setelah menyelesaikan aktivitas pembelajaran.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
                <h4>Keluar Aplikasi</h4>
                <p>
                    Tombol keluar digunakan untuk mengakhiri sesi belajar dan keluar dari akun pengguna dengan aman.
                </p>
            </div>
        </div>

        <div class="step-box">
            <h3>Alur Penggunaan</h3>
            <ul class="step-list">
                <li>
                    <span class="step-number">1</span>
                    <span>Masuk ke aplikasi menggunakan akun yang telah tersedia maupun membuat baru.</span>
                </li>
                <li>
                    <span class="step-number">2</span>
                    <span>Buka halaman materi untuk melihat menu utama pembelajaran.</span>
                </li>
                <li>
                    <span class="step-number">3</span>
                    <span>Baca kurikulum untuk memahami capaian, tujuan, dan ruang lingkup materi.</span>
                </li>
                <li>
                    <span class="step-number">4</span>
                    <span>Pelajari materi jaringan muda tumbuhan secara berurutan.</span>
                </li>
                <li>
                    <span class="step-number">5</span>
                    <span>Gunakan visualisasi untuk membantu memahami struktur dan perkembangan jaringan muda tumbuhan.</span>
                </li>
                <li>
                    <span class="step-number">6</span>
                    <span>Kerjakan kuis atau evaluasi untuk mengetahui tingkat pemahaman terhadap materi.</span>
                </li>
            </ul>
        </div>

        <div class="note-box">
            <h4>Catatan Penggunaan</h4>
            <ul>
                <li>Gunakan aplikasi secara berurutan agar proses belajar lebih mudah dipahami.</li>
                <li>Baca instruksi pada setiap halaman sebelum mengerjakan aktivitas atau kuis.</li>
                <li>Pastikan koneksi internet stabil agar halaman dan visualisasi dapat ditampilkan dengan baik.</li>
                <li>Gunakan tombol keluar setelah selesai belajar untuk menjaga keamanan akun.</li>
            </ul>
        </div>

        <div class="btn-area">
            <a href="{{ route('dashboard') }}" class="card-btn">
                Kembali ke Beranda
            </a>
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
                localStorage.setItem('logout_success_message', 'Berhasil keluar!');
                document.getElementById('logoutForm').submit();
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