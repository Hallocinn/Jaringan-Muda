<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaringan Muda Tumbuhan | Belajar.ID</title>

    @vite(['resources/css/app.css', 'resources/css/logo.css'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(21, 128, 61, 0.14), transparent 32%),
                radial-gradient(circle at bottom left, rgba(20, 83, 45, 0.10), transparent 34%),
                #f7fbf8;
            color: #111827;
        }

        .navbar-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            background: rgba(247, 251, 248, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(20, 83, 45, 0.10);
        }

        .navbar-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 20px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #14532d;
            font-weight: 700;
            font-size: 22px;
            text-decoration: none;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: #14532d;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .navbar a {
            position: relative;
            text-decoration: none;
            color: #374151;
            font-size: 15px;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .navbar a:not(.nav-login)::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 0;
            height: 3px;
            background: #15803d;
            border-radius: 999px;
            transition: 0.25s ease;
        }

        .navbar a:hover,
        .navbar a.active {
            color: #15803d;
        }

        .navbar a.active::after {
            width: 100%;
        }

        .navbar .nav-login {
            background: #15803d;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 8px 18px rgba(20, 83, 45, 0.18);
        }

        .navbar .nav-login:hover {
            background: #14532d;
            color: #ffffff;
        }

        .section {
            scroll-margin-top: 96px;
        }

        .hero-section {
            min-height: calc(100vh - 74px);
            display: flex;
            align-items: center;
            padding: 70px 36px;
        }

        .hero-container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 54px;
        }

        .hero-content {
            max-width: 640px;
            margin-top: -30px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #dcfce7;
            color: #14532d;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: clamp(42px, 5vw, 62px);
            line-height: 1.08;
            letter-spacing: -0.06em;
            font-weight: 800;
            color: #111827;
            max-width: 660px;
            margin-bottom: 26px;
        }

        .hero-title span {
            color: #14532d;
        }

        .hero-description {
            font-size: 21px;
            line-height: 1.7;
            color: #6b7280;
            max-width: 580px;
            margin-bottom: 42px;
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            background: #15803d;
            color: #ffffff;
            text-decoration: none;
            padding: 17px 30px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 700;
            transition: 0.25s ease;
            box-shadow: 0 12px 24px rgba(20, 83, 45, 0.18);
        }

        .hero-button:hover {
            background: #14532d;
            transform: translateY(-2px);
        }

        .hero-visual {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plant-illustration {
            width: min(520px, 100%);
            height: auto;
        }

        .line {
            fill: none;
            stroke: #111827;
            stroke-width: 8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .green-fill {
            fill: #15803d;
        }

        .dark-green-fill {
            fill: #14532d;
        }

        .light-green-fill {
            fill: #dcfce7;
        }

        .soil {
            fill: #14532d;
        }

        .bubble {
            fill: #ffffff;
            stroke: #111827;
            stroke-width: 6;
        }

        .bubble-text {
            font-size: 34px;
            font-weight: 800;
            fill: #14532d;
        }

        .content-section {
            padding: 40px 36px 90px;
        }

        .content-container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 34px;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(20, 83, 45, 0.12);
            border-radius: 24px;
            padding: 42px;
            box-shadow: 0 24px 60px rgba(20, 83, 45, 0.10);
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #dcfce7;
            color: #14532d;
            padding: 9px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.15;
            letter-spacing: -0.04em;
            color: #111827;
            margin-bottom: 16px;
        }

        .section-title span {
            color: #14532d;
        }

        .section-description {
            color: #6b7280;
            font-size: 17px;
            line-height: 1.8;
            max-width: 860px;
            margin-bottom: 28px;
        }

        .curriculum-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .curriculum-item {
            background: #f0fdf4;
            border: 1px solid rgba(21, 128, 61, 0.16);
            border-radius: 18px;
            padding: 22px;
        }

        .curriculum-number {
            width: 38px;
            height: 38px;
            background: #14532d;
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .curriculum-item h3 {
            font-size: 17px;
            color: #14532d;
            margin-bottom: 10px;
        }

        .curriculum-item p {
            font-size: 14px;
            line-height: 1.7;
            color: #4b5563;
        }

        .info-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-item {
            display: flex;
            gap: 16px;
            background: #f9fafb;
            border: 1px solid rgba(20, 83, 45, 0.10);
            border-radius: 18px;
            padding: 20px;
        }

        .info-icon {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            background: #14532d;
            color: #ffffff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .info-item h3 {
            font-size: 17px;
            color: #14532d;
            margin-bottom: 8px;
        }

        .info-item p {
            font-size: 14px;
            line-height: 1.7;
            color: #4b5563;
        }

        .swal2-popup.success-swal-popup {
            border-radius: 16px !important;
            font-family: 'Poppins', sans-serif !important;
            padding: 24px !important;
        }

        .swal2-title.success-swal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
        }

        .swal2-html-container.success-swal-text {
            font-size: 14px !important;
            color: #475569 !important;
            line-height: 1.6 !important;
        }

        .swal2-confirm.success-swal-confirm {
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 12px 20px !important;
            font-family: 'Poppins', sans-serif !important;
        }

        @media (max-width: 900px) {
            .navbar-container {
                padding: 18px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .navbar {
                width: 100%;
                gap: 16px;
                flex-wrap: wrap;
            }

            .navbar a {
                font-size: 14px;
            }

            .navbar .nav-login {
                padding: 9px 16px;
            }

            .hero-section {
                padding: 20px 10px;
            }

            .hero-container {
                grid-template-columns: 1fr;
                gap: 34px;
            }

            .hero-visual {
                order: -1;
            }

            .plant-illustration {
                max-width: 360px;
            }

            .hero-description {
                font-size: 14px;
            }

            .content-section {
                padding: 24px 20px 70px;
            }

            .section-card {
                padding: 28px;
            }

            .curriculum-grid,
            .info-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .hero-title {
                font-size: 38px;
            }

            .hero-button {
                padding: 14px 22px;
                font-size: 15px;
            }

            .section-card {
                padding: 24px;
                border-radius: 20px;
            }
        }
    </style>
</head>

<body>

    <header class="navbar-wrapper">
        <div class="navbar-container">
            @include('layouts.logo')

            <nav class="navbar">
                <a href="#kurikulum" class="nav-link" data-target="kurikulum">Kurikulum</a>
                <a href="#informasi" class="nav-link" data-target="informasi">Informasi</a>
                <a href="/login" class="nav-login">Masuk</a>
            </nav>
        </div>
    </header>

    <main>
        <section id="beranda" class="hero-section section">
            <div class="hero-container">
                <div class="hero-content">
                    <h2 class="hero-title">
                        <span>Visualisasi 3D </span>Struktur<span>, Fungsi</span>, dan Perkembangan Jaringan <span>Muda</span> Tumbuhan.
                    </h2>

                    <p class="hero-description">
                        Pelajari struktur, fungsi, dan perkembangan jaringan muda tumbuhan melalui materi interaktif yang mudah dipahami.
                    </p>

                    <a href="/login" class="hero-button">
                        Mulai Belajar
                    </a>
                </div>

                <div class="hero-visual">
                    <svg class="plant-illustration" viewBox="0 0 620 520" xmlns="http://www.w3.org/2000/svg">
                        <path class="bubble" d="M105 70c0-35 32-58 74-58s74 23 74 58-32 58-74 58c-7 0-13-1-19-2l-34 35 4-47c-16-10-25-25-25-44Z"/>
                        <text x="145" y="84" class="bubble-text">A+</text>

                        <path class="bubble" d="M390 70c0-32 30-54 70-54s70 22 70 54-30 54-70 54c-6 0-12 0-18-2l-28 31 3-42c-17-10-27-24-27-41Z"/>
                        <path class="line" d="M438 69h44"/>
                        <path class="line" d="M438 91h31"/>

                        <circle cx="510" cy="185" r="46" class="light-green-fill"/>
                        <path class="line" d="M510 115v-28"/>
                        <path class="line" d="M510 283v-28"/>
                        <path class="line" d="M440 185h-28"/>
                        <path class="line" d="M608 185h-28"/>
                        <path class="line" d="M460 135l-20-20"/>
                        <path class="line" d="M560 235l20 20"/>
                        <path class="line" d="M560 135l20-20"/>
                        <path class="line" d="M460 235l-20 20"/>

                        <path d="M230 395h160l-25 95H255l-25-95Z" class="soil"/>
                        <path class="line" d="M210 395h200"/>
                        <path class="line" d="M255 490h110"/>

                        <path class="line" d="M310 395C310 315 310 245 310 165"/>

                        <path d="M310 300C220 275 178 217 198 160c69 3 115 46 112 140Z" class="green-fill"/>
                        <path class="line" d="M310 300C220 275 178 217 198 160c69 3 115 46 112 140Z"/>
                        <path class="line" d="M300 286c-34-38-64-75-91-112"/>

                        <path d="M315 250C405 220 452 165 438 110c-72-1-122 39-123 140Z" class="dark-green-fill"/>
                        <path class="line" d="M315 250C405 220 452 165 438 110c-72-1-122 39-123 140Z"/>
                        <path class="line" d="M326 235c34-38 66-75 100-112"/>

                        <path d="M310 205C250 192 218 158 225 120c47-2 82 25 85 85Z" class="light-green-fill"/>
                        <path class="line" d="M310 205C250 192 218 158 225 120c47-2 82 25 85 85Z"/>

                        <path d="M315 345C385 330 420 286 410 240c-55 0-95 35-95 105Z" class="green-fill"/>
                        <path class="line" d="M315 345C385 330 420 286 410 240c-55 0-95 35-95 105Z"/>

                        <path class="line" d="M310 395c-25 28-48 48-82 60"/>
                        <path class="line" d="M310 395c22 28 50 48 88 60"/>
                        <path class="line" d="M310 395c0 31-2 60-10 88"/>

                        <path class="line" d="M85 230c-18 8-30 20-38 38"/>
                        <path class="line" d="M70 190h-34"/>
                        <path class="line" d="M115 160l-20-24"/>
                    </svg>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="content-container">

                <div id="kurikulum" class="section section-card">
                    <div class="section-label">Kurikulum</div>

                    <h2 class="section-title">
                        Alur pembelajaran <span>jaringan muda tumbuhan</span>
                    </h2>

                    <p class="section-description">
                        Kurikulum disusun bertahap agar siswa memahami konsep jaringan muda tumbuhan mulai dari pengertian, struktur, hingga proses perkembangan pada bagian tumbuhan yang aktif tumbuh.
                    </p>

                    <div class="curriculum-grid">
                        <div class="curriculum-item">
                            <div class="curriculum-number">1</div>
                            <h3>Definisi Jaringan Muda</h3>
                            <p>
                                Siswa memahami pengertian jaringan muda atau jaringan meristem sebagai jaringan yang aktif membelah dan berperan dalam pertumbuhan tumbuhan.
                            </p>
                        </div>

                        <div class="curriculum-item">
                            <div class="curriculum-number">2</div>
                            <h3>Struktur Jaringan Muda</h3>
                            <p>
                                Siswa mengenali ciri-ciri sel penyusun jaringan muda, letak jaringan muda, serta perbedaan bagian meristem pada tumbuhan.
                            </p>
                        </div>

                        <div class="curriculum-item">
                            <div class="curriculum-number">3</div>
                            <h3>Perkembangan Jaringan Muda</h3>
                            <p>
                                Siswa mempelajari peran jaringan muda dalam pertumbuhan akar, batang, daun, serta pembentukan jaringan dewasa.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="informasi" class="section section-card">
                    <div class="section-label">Informasi Pengembang</div>

                    <h2 class="section-title">
                        Informasi <span>Pengembang</span>
                    </h2>

                    <p class="section-description">
                        Media pembelajaran Meristem.pedia dikembangkan sebagai media pembelajaran interaktif untuk membantu siswa memahami materi jaringan muda tumbuhan.
                    </p>

                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-icon">✓</div>
                            <div>
                                <h3>Nama Pengembang</h3>
                                <p>Cindy Junia Putri</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">✓</div>
                            <div>
                                <h3>NIM</h3>
                                <p>2210131320009</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">✓</div>
                            <div>
                                <h3>Program Studi</h3>
                                <p>Pendidikan Komputer S1</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">✓</div>
                            <div>
                                <h3>Universitas</h3>
                                <p>Universitas Lambung Mangkurat</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <script>
        const sections = document.querySelectorAll('.section');
        const navLinks = document.querySelectorAll('.nav-link');

        function setActiveNav(id) {
            navLinks.forEach((link) => {
                link.classList.remove('active');

                if (link.dataset.target === id) {
                    link.classList.add('active');
                }
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    setActiveNav(entry.target.id);
                }
            });
        }, {
            root: null,
            threshold: 0.45
        });

        sections.forEach((section) => {
            observer.observe(section);
        });

        navLinks.forEach((link) => {
            link.addEventListener('click', function () {
                setActiveNav(this.dataset.target);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sessionSuccessMessage = @json(session('success'));
            const logoutUrlSuccess = @json(request('logout') === 'success');
            const logoutStorageMessage = localStorage.getItem('logout_success_message');

            let successMessage = sessionSuccessMessage;

            if (!successMessage && logoutStorageMessage) {
                successMessage = logoutStorageMessage;
            }

            if (!successMessage && logoutUrlSuccess) {
                successMessage = 'Berhasil keluar!';
            }

            if (successMessage) {
                localStorage.removeItem('logout_success_message');

                Swal.fire({
                    customClass: {
                        popup: 'success-swal-popup',
                        title: 'success-swal-title',
                        htmlContainer: 'success-swal-text',
                        confirmButton: 'success-swal-confirm'
                    },
                    title: 'Berhasil!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonColor: '#15803d',
                    confirmButtonText: 'Oke',
                    backdrop: 'rgba(15, 23, 42, 0.6)'
                }).then(() => {
                    if (window.location.search.includes('logout=success')) {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                });
            }
        });
    </script>

</body>
</html>