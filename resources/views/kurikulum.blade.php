<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurikulum | BELAJAR.ID</title>

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
        }

        /* HEADER TETAP */
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

        /* MAIN CONTENT */
        .main-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 36px 32px 42px;
            min-height: calc(100vh - 150px);
        }

        .section-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .section-title h2 {
            color: #0f172a;
            font-size: 30px;
            font-weight: 700;
            margin: 0;
        }

        /* CARD KURIKULUM */
        .kurikulum-wrapper {
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            align-items: stretch;
        }

        .kurikulum-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            padding: 20px;
            min-height: 245px;
        }

        .kurikulum-card h3 {
            color: #14532d;
            font-size: 19px;
            font-weight: 700;
            margin: 0 0 14px 0;
            border-left: 4px solid #16a34a;
            padding-left: 12px;
        }

        .kurikulum-card p,
        .kurikulum-card li {
            color: #475569;
            font-size: 14px;
            line-height: 1.65;
        }

        .kurikulum-card p {
            margin: 0;
        }

        .kurikulum-card ul {
            margin: 0;
            padding-left: 22px;
        }

        .kurikulum-card li {
            margin-bottom: 6px;
        }

        /* TABEL */
        .table-kurikulum {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-kurikulum th {
            background: #14532d;
            color: white;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
        }

        .table-kurikulum td {
            padding: 10px 12px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-kurikulum tr:nth-child(even) {
            background: #f8fafc;
        }

        .table-kurikulum tr:last-child td {
            border-bottom: none;
        }

        /* TOMBOL */
        .btn-area {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 8px;
        }

        .card-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 240px;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            background: #15803d;
            color: white;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 6px 14px rgba(21, 128, 61, 0.18);
        }

        .card-btn:hover {
            background: #16a34a;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(34, 197, 94, 0.22);
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
            font-family: 'Poppins', sans-serif !important;
        }

        .swal2-icon {
            margin-top: 12px !important;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .kurikulum-wrapper {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .header {
                flex-direction: column;
                gap: 12px;
                padding: 16px 20px;
                text-align: center;
            }

            .header-right {
                flex-direction: column;
                gap: 12px;
            }

            .user-info {
                text-align: center;
            }

            .main-content {
                padding: 28px 20px 36px;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .kurikulum-wrapper {
                grid-template-columns: 1fr;
            }

            .kurikulum-card {
                min-height: auto;
                padding: 18px;
            }

            .card-btn {
                width: 100%;
                min-width: unset;
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
                <button type="button" class="logout-btn" onclick="konfirmasiKeluar()">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="main-content">
        <div class="section-title">
            <h2>Kurikulum Pembelajaran</h2>
        </div>

        <div class="kurikulum-wrapper">
            <div class="kurikulum-card">
                <h3>Capaian Pembelajaran</h3>
                <p>
                    Peserta didik mampu menganalisis dan menjelaskan struktur, fungsi, dan peranan jaringan muda pada tumbuhan melalui pendekatan saintifik dengan benar.
                </p>
            </div>

            <div class="kurikulum-card">
                <h3>Tujuan Pembelajaran</h3>
                <ul>
                    <li>Mengidentifikasi jenis jaringan meristem pada tumbuhan melalui pendekatan saintifik.</li>
                    <li>Mendeskripsikan fungsi jaringan meristem dalam proses pertumbuhan tumbuhan.</li>
                    <li>Menganalisis hubungan jaringan meristem dengan pertumbuhan primer dan sekunder pada tumbuhan.</li>
                </ul>
            </div>

            <div class="kurikulum-card">
                <h3>Ruang Lingkup Materi</h3>
                <table class="table-kurikulum">
                    <thead>
                        <tr>
                            <th width="120">Materi</th>
                            <th>Pokok Bahasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Materi 1</td>
                            <td>Definisi Jaringan Muda Tumbuhan</td>
                        </tr>
                        <tr>
                            <td>Materi 2</td>
                            <td>Struktur Jaringan Muda Tumbuhan</td>
                        </tr>
                        <tr>
                            <td>Materi 3</td>
                            <td>Perkembangan Jaringan Muda Tumbuhan</td>
                        </tr>
                    </tbody>
                </table>
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
            backdrop: 'rgba(15, 23, 42, 0.6)'
        };

        function konfirmasiKeluar() {
            Swal.fire({
                ...swalConfig,
                title: 'Konfirmasi Keluar',
                text: 'Apakah kamu yakin ingin keluar dari akun dan menyudahi sesi belajar ini?',
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