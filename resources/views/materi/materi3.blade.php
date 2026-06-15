@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ============================================
       TYPOGRAPHY SCALE - BELAJAR.ID
       ============================================ */
    :root {
        /* Font Sizes */
        --fs-h1: 32px;
        --fs-h2: 24px;
        --fs-h3: 18px;
        --fs-h4: 16px;
        --fs-body-l: 16px;
        --fs-body-m: 14px;
        --fs-body-s: 13px;
        --fs-button: 14px;
        --fs-button-small: 13px;
        --fs-badge: 14px;
        --fs-meta: 11px;
        
        /* Font Weights */
        --fw-regular: 400;
        --fw-medium: 500;
        --fw-semibold: 600;
        --fw-bold: 700;
        
        /* Colors */
        --primary: #16a34a;
        --primary-dark: #15803d;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-100: #f1f5f9;
        --border: #e2e8f0;
        --white: #ffffff;
    }

    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .materi-wrapper { 
        max-width: 1200px;
        margin: 0 auto; 
        padding: 16px var(--fs-h2);
        color: var(--slate-800); 
    }
    
    /* Header */
    .materi-header { text-align: center; margin-bottom: 16px; }
    .materi-header h2 { font-size: var(--fs-h1); font-weight: var(--fw-bold); color: var(--slate-800); }
    .header-line { height: 4px; width: 60px; background: var(--primary); margin: 8px auto 0 auto; border-radius: 10px; }

    /* Navigasi */
    .saintifik-nav { display: flex; gap: 10px; background: #e2e8f0; padding: 6px; border-radius: 10px; margin-bottom: 16px; }
    .nav-item { flex: 1; border: none; background: transparent; padding: 10px; cursor: pointer; border-radius: 10px; transition: 0.3s; display: flex; flex-direction: column; align-items: center; }
    .nav-item.active { background: var(--white); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .nav-item.active .num { background: var(--primary); color: white; }
    .num { width: 26px; height: 26px; background: #cbd5e1; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-size: var(--fs-badge); font-weight: var(--fw-bold); margin-bottom: 4px; }
    .label { font-size: var(--fs-badge); font-weight: var(--fw-bold); color: var(--slate-600); }

    /* Cards */
    .card { background: var(--white); border-radius: 10px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 14px; }
    .card h3 { font-size: var(--fs-h3); font-weight: var(--fw-bold); margin-bottom: 12px; }
    .card p { font-size: var(--fs-body-m); font-weight: var(--fw-regular); line-height: 1.5; color: var(--slate-600); }
    
    .intro-card .icon-circle { width: 50px; height: 50px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .intro-card .icon-circle i { font-size: 24px; color: var(--primary); }
    
    .model-3d-container { position: relative; height: 10px; background: #0f172a; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
    .btn-fullscreen { position: absolute; bottom: 33px; right: 30px; background: #f59e0b; color: #0f172a; border: none; padding: 6px 14px; border-radius: 10px; cursor: pointer; font-size: var(--fs-button-small); font-weight: var(--fw-medium); box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4); z-index: 10; transition: 0.2s; display: flex; align-items: center; gap: 6px; }
    .btn-fullscreen:hover { background: #d97706; transform: scale(1.03); }

    /* PENDUKUNG FALLBACK: Jika sistem HTML5 API Browser gagal, class ini menjamin layar penuh melalui CSS */
    .model-3d-container.is-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 999999 !important;
        border-radius: 0 !important;
    }

    /* Chat UI */
    .chat-app { padding: 0 !important; overflow: hidden; display: flex; flex-direction: column; height: 400px; }
    .chat-header { background: var(--slate-800); color: white; padding: 12px 20px; }
    .chat-info { display: flex; align-items: center; gap: 10px; }
    .chat-info h4 { margin: 0; font-size: var(--fs-h4); font-weight: var(--fw-semibold); }
    .chat-info span { font-size: var(--fs-meta); font-weight: var(--fw-regular); color: var(--primary); }
    .chat-body { flex: 1; padding: 16px; overflow-y: auto; background: #f8fafc; display: flex; flex-direction: column; gap: 12px; }
    
    .msg-wrapper { display: flex; gap: 10px; max-width: 80%; }
    .msg-in { align-self: flex-start; }
    .msg-out { align-self: flex-end; flex-direction: row-reverse; }
    .avatar { width: 32px; height: 32px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: var(--fs-meta); font-weight: var(--fw-semibold); flex-shrink: 0; }
    .msg-in .avatar { background: #3b82f6; color: white; }
    .msg-content { display: flex; flex-direction: column; }
    .user-name { font-size: var(--fs-meta); font-weight: var(--fw-semibold); margin-bottom: 2px; color: var(--slate-600); }
    .bubble { padding: 10px 14px; border-radius: 10px; font-size: var(--fs-body-m); font-weight: var(--fw-regular); line-height: 1.4; }
    .msg-in .bubble { background: white; border: 1px solid var(--border); border-top-left-radius: 2px; }
    .msg-out .bubble { background: var(--primary); color: white; border-top-right-radius: 2px; }
    
    .chat-footer { padding: 12px; border-top: 1px solid var(--border); display: flex; gap: 10px; background: white; }
    .chat-footer input { flex: 1; border: 1px solid var(--border); padding: 8px 16px; border-radius: 10px; outline: none; font-size: var(--fs-body-m); }
    .btn-send { background: var(--primary); color: white; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: var(--fs-button); }
    .btn-send:hover { background: var(--primary-dark); transform: scale(1.05); }

    /* Matching Step 3 */
    .matching-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .placeholder-label-img { height: 250px; background: #f1f5f9; border-radius: 10px; position: relative; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; }
    .placeholder-label-img p { font-size: var(--fs-body-m); color: var(--slate-600); margin-top: 200px; }
    .node { position: absolute; width: 26px; height: 26px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: var(--fs-badge); font-weight: var(--fw-bold); border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .n1 { top: 20%; left: 50%; } .n2 { top: 50%; left: 45%; } .n3 { top: 80%; left: 50%; }
    .quiz-card h4 { font-size: var(--fs-h4); font-weight: var(--fw-semibold); margin-bottom: 12px; }
    .match-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .match-row label { font-size: var(--fs-body-m); font-weight: var(--fw-medium); color: var(--slate-600); }
    .match-input { width: 50px; padding: 6px; text-align: center; border-radius: 10px; border: 2px solid var(--border); font-size: var(--fs-body-m); font-weight: var(--fw-medium); transition: all 0.2s; }

    .btn-check-materi { width: 100%; padding: 12px 20px; border-radius: 10px; border: none; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; font-weight: var(--fw-medium); font-size: var(--fs-button); cursor: pointer; transition: 0.3s; margin-top: 6px; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-check-materi:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }

    /* Tables Step 4 */
    .tf-table { width: 100%; border-collapse: collapse; }
    .tf-table th { text-align: left; padding: 12px; background: var(--slate-100); color: var(--slate-600); font-size: var(--fs-badge); text-transform: uppercase; font-weight: var(--fw-semibold); }
    .tf-table td { padding: 14px 12px; border-bottom: 1px solid var(--border); font-size: var(--fs-body-m); }
    .tf-btn-group { display: flex; gap: 8px; }
    .tf-btn { border: 1px solid var(--border); padding: 6px 12px; border-radius: 10px; background: white; cursor: pointer; font-weight: var(--fw-medium); font-size: var(--fs-button-small); flex: 1; transition: 0.3s; }
    
    /* Tambahan efek aktif untuk seleksi menalar */
    .tf-btn.active.btn-b-active { background-color: #d1fae5 !important; color: #065f46 !important; border-color: #10b981 !important; font-weight: 600; }
    .tf-btn.active.btn-s-active { background-color: #fee2e2 !important; color: #991b1b !important; border-color: #f87171 !important; font-weight: 600; }

    /* Step 5 */
    .communication-box h3 { font-size: var(--fs-h3); font-weight: var(--fw-bold); margin-bottom: 14px; }
    .form-item { margin-bottom: 14px; }
    .form-item label { display: block; font-weight: var(--fw-medium); font-size: var(--fs-body-m); margin-bottom: 6px; }
    .modern-input { width: 100%; padding: 10px; border-radius: 10px; border: 1px solid var(--border); resize: none; transition: 0.3s; font-size: var(--fs-body-m); }
    .modern-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
    .btn-submit { width: 100%; padding: 12px; border-radius: 10px; border: none; background: var(--slate-800); color: white; font-weight: var(--fw-medium); cursor: pointer; font-size: var(--fs-button); transition: 0.3s; }
    .btn-submit:hover { background: var(--slate-600); transform: translateY(-2px); }
    .feedback-msg { margin-top: 10px; font-size: var(--fs-body-s); text-align: center; }

    /* Footer Action */
    .footer-action { display: flex; gap: 16px; align-items: center; justify-content: center; margin-top: 16px; }
    .btn-kembali { flex: 1; padding: 12px 20px; border-radius: 10px; border: none; background: #dc2626; color: white; font-weight: var(--fw-medium); cursor: pointer; transition: 0.3s; font-size: var(--fs-button); }
    .btn-kembali:hover { background: #b91c1c; transform: translateY(-2px); }
    
    .btn-locked { flex: 1; padding: 12px 20px; border-radius: 10px; border: none; background: #cbd5e1; color: #64748b; font-weight: var(--fw-medium); cursor: not-allowed; transition: 0.4s; font-size: var(--fs-button); display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-unlocked { background: var(--primary); color: white; cursor: pointer; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
    .btn-unlocked:hover { transform: translateY(-2px); background: var(--primary-dark); }

    .step-content { animation: slideUp 0.4s ease-out; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    /* ========================================================
       SWEETALERT2 STYLE - SAMA DENGAN ALERT LOGOUT
       ======================================================== */
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

    @media (max-width: 700px) { 
        .matching-grid { grid-template-columns: 1fr; } 
        .label { display: none; }
        .footer-action { flex-direction: column; gap: 12px; }
        .btn-kembali, .btn-locked { width: 100%; }
    }
    .intro-card p{
    text-align: justify;
    line-height: 1.8;
    margin-bottom: 12px;
    font-size: 16px;
    }

    .intro-card h4{
        margin-top: 20px;
        margin-bottom: 10px;
        color: #14532d;
        font-weight: 600;
    }

    .intro-card ol{
        padding-left: 22px;
        line-height: 1.8;
    }
</style>

<div class="materi-wrapper">
    {{-- ================= HEADER ================= --}}
    <header class="materi-header">
        <h2>PERKEMBANGAN JARIGAN MUDA TUMBUHAN</h2>
    </header>
    <div class="card intro-card">
        <h3>Petunjuk Pembelajaran</h3>
        <ol>
            <li>
                Kerjakan aktivitas pada setiap tahap pembelajaran secara berurutan, mulai dari
                <strong>Mengamati</strong>, <strong>Menanya</strong>, <strong>Mengumpulkan Informasi</strong>,
                <strong>Menalar</strong>, hingga <strong>Mengomunikasikan</strong>.
            </li>
            <li>
                Gunakan model 3D untuk mempelajari objek dari berbagai sudut pandang dengan cara memutar,
                memperbesar atau memperkecil tampilan, serta menggunakan mode layar penuh agar pengamatan lebih jelas.
            </li>
            <li>
                Pastikan setiap aktivitas telah diselesaikan sebelum melanjutkan ke tahap berikutnya.
            </li>
            <li>
                Kuis dapat diakses setelah seluruh aktivitas pembelajaran selesai dikerjakan.
            </li>
        </ol>
    </div>

    {{-- ================= AREA MODEL 3D ================= --}}
    <div class="model-section card">
        <div id="container3D" class="model-3d-container">
            <div id="model3d" class="viewer-box"></div>
            <button id="fullscreenBtn" class="btn-fullscreen" onclick="toggleFullscreen()">
                <i class="fas fa-expand"></i> Layar Penuh
            </button>
        </div>
    </div>

    {{-- ================= NAVIGASI TABS ================= --}}
    <nav class="saintifik-nav">
        <button class="nav-item active" id="btn-step1" onclick="switchStep(1)">
            <span class="num">1</span> <span class="label">Mengamati</span>
        </button>
        <button class="nav-item" id="btn-step2" onclick="switchStep(2)">
            <span class="num">2</span> <span class="label">Menanya</span>
        </button>
        <button class="nav-item" id="btn-step3" onclick="switchStep(3)">
            <span class="num">3</span> <span class="label">Mencoba</span>
        </button>
        <button class="nav-item" id="btn-step4" onclick="switchStep(4)">
            <span class="num">4</span> <span class="label">Menalar</span>
        </button>
        <button class="nav-item" id="btn-step5" onclick="switchStep(5)">
            <span class="num">5</span> <span class="label">Komunikasi</span>
        </button>
    </nav>

    {{-- ================= KONTEN AKTIVITAS ================= --}}
<main class="activity-viewport">

    {{-- STEP 1: MENGAMATI --}}
    <div class="step-content active" id="step1">

    <div class="card intro-card">
        <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
        <p>Untuk memahami perkembangan jaringan muda pada tumbuhan, lakukan kegiatan berikut:</p>

        <ol>
            <li>Bacalah materi tentang perkembangan jaringan muda atau jaringan meristem pada tumbuhan dengan saksama.</li>
            <li>Amatilah model 3D yang menampilkan proses pertumbuhan primer dan pertumbuhan sekunder pada tumbuhan.</li>
            <li>Identifikasilah peran jaringan meristem dalam pertumbuhan primer dan pertumbuhan sekunder.</li>
            <li>Catatlah informasi penting mengenai perubahan jaringan muda menjadi jaringan dewasa pada tumbuhan.</li>
        </ol>
    </div>
        <div class="card intro-card">
        <h3>TUJUAN PEMBELAJARAN</h3>

        <ol>
            <li>Peserta didik dapat mengidentifikasi jenis pertumbuhan pada tumbuhan.</li>
            <li>Peserta didik memahami proses pertumbuhan primer dan pertumbuhan sekunder pada tumbuhan.</li>
        </ol>

        <h3>PENDAHULUAN</h3>
        <p>
            Tumbuhan mengalami proses pertumbuhan selama hidupnya. Pertumbuhan tersebut terjadi karena adanya aktivitas jaringan meristem yang terus membelah dan menghasilkan sel-sel baru. Pada tumbuhan, pertumbuhan dibedakan menjadi dua jenis, yaitu pertumbuhan primer dan pertumbuhan sekunder. Pertumbuhan primer menyebabkan tumbuhan bertambah panjang atau tinggi, sedangkan pertumbuhan sekunder menyebabkan batang dan akar menjadi lebih besar dan kuat. Kedua jenis pertumbuhan ini sangat penting agar tumbuhan dapat tumbuh dengan baik dan bertahan hidup.
            Pertumbuhan primer terjadi karena aktivitas jaringan meristem primer yang terdapat pada ujung batang dan ujung akar. Sel-sel meristem akan terus membelah dan berkembang menjadi berbagai jaringan tumbuhan. Pertumbuhan ini membantu tumbuhan tumbuh lebih tinggi dan akar tumbuh semakin dalam. Sementara itu, pertumbuhan sekunder terjadi karena aktivitas meristem lateral atau kambium yang menyebabkan batang dan akar bertambah besar serta kuat. Kambium menghasilkan xilem sekunder yang berfungsi mengangkut air dan mineral, serta floem sekunder yang berfungsi mengangkut hasil fotosintesis ke seluruh bagian tumbuhan.
            Pada kegiatan pembelajaran ini, peserta didik akan melakukan berbagai aktivitas bersama teman dan guru, seperti berdiskusi, mengajukan pertanyaan, memberikan tanggapan, mengamati gambar struktur jaringan meristem, serta mengidentifikasi fungsi dari setiap jaringan yang diamati. Peserta didik juga akan mengerjakan latihan benar dan salah, menjawab pertanyaan berdasarkan hasil pengamatan dan diskusi, menuliskan kesimpulan materi, serta mengerjakan kuis tentang pertumbuhan primer dan pertumbuhan sekunder pada tumbuhan.
        </p>
    </div>
    <div class="card intro-card">
        <h3>PERKEMBANGAN JARINGAN MUDA TUMBUHAN</h3>

        <p>
            Tanaman mengalami dua jenis pertumbuhan, yaitu pertumbuhan primer dan pertumbuhan sekunder. Pertumbuhan primer terjadi karena aktivitas jaringan meristem primer yang terdapat di ujung batang dan ujung akar. Pertumbuhan ini menyebabkan batang dan akar bertambah panjang sehingga tanaman dapat tumbuh lebih tinggi dan akarnya semakin dalam. Selain itu, tanaman juga mengalami pertumbuhan sekunder yang disebabkan oleh jaringan meristem sekunder. Pertumbuhan sekunder membuat batang tumbuhan menjadi lebih besar atau menebal, sehingga tanaman menjadi lebih kuat dan kokoh.
        </p>

        <h4>1. Pertumbuhan Primer</h4>

        <p>
            Pertumbuhan primer adalah pertumbuhan yang menyebabkan tumbuhan bertambah panjang atau tinggi. Pertumbuhan ini terjadi karena aktivitas meristem apikal yang terdapat pada ujung batang dan ujung akar. Pada bagian ini, sel-sel meristem aktif membelah sehingga menghasilkan sel baru. Sel-sel tersebut kemudian memanjang dan memisah menjadi jaringan lain seperti jaringan epidermis, jaringan pengangkut, dan jaringan dasar.
        </p>

        <p>
            Untuk memahami proses pertumbuhan primer, amatilah model 3D tanaman tomat yang tersedia pada media pembelajaran. Perhatikan bagian ujung batang dan ujung akar yang menjadi lokasi aktivitas meristem apikal.
        </p>

        <p>
            Contoh pertumbuhan primer dapat dilihat pada tanaman tomat. Pertumbuhan ini ditandai dengan pemanjangan akar dan batang yang menyebabkan tanaman bertambah tinggi. Melalui pertumbuhan tersebut, tanaman dapat memperoleh cahaya matahari serta menyerap air dan unsur hara dari tanah secara lebih optimal.
        </p>

        <h4>2. Pertumbuhan Sekunder</h4>

        <p>
            Pertumbuhan sekunder adalah pertumbuhan yang menyebabkan batang dan akar bertambah besar atau menebal. Pertumbuhan ini terjadi karena aktivitas meristem lateral, yaitu jaringan kambium. Kambium akan menghasilkan:
        </p>

        <ol type="a">
            <li><strong>Xilem sekunder</strong> yang berfungsi mengangkut air dan mineral dari akar ke daun.</li>
            <li><strong>Floem sekunder</strong> yang berfungsi mengangkut hasil fotosintesis ke seluruh bagian tumbuhan.</li>
        </ol>

        <p>
            Pertumbuhan sekunder umumnya terjadi pada tumbuhan dikotil dan tumbuhan berkayu, sehingga batangnya menjadi kuat dan kokoh. Untuk memahami proses ini, amatilah model 3D yang menampilkan penebalan batang akibat aktivitas kambium pada tumbuhan.
        </p>

        <p>
            Contohnya dapat diamati pada pohon cempedak. Batangnya semakin lama semakin besar dan kokoh seiring pertumbuhan tanaman akibat aktivitas meristem lateral.
        </p>
    </div>

</div>
    {{-- STEP 2: MENANYA --}}
    <div class="step-content" id="step2" style="display:none;">
        <div class="card intro-card">
            <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
            <p>Setelah mengamati materi perkembangan jaringan muda tumbuhan, lakukan kegiatan berikut bersama teman dan guru:</p>

            <ol>
                <li>Tunggulah hingga guru membuka fitur chat diskusi.</li>
                <li>Tuliskan pertanyaan atau pendapat tentang perkembangan jaringan muda pada tumbuhan melalui fitur chat.</li>
                <li>Diskusikan perbedaan pertumbuhan primer dan pertumbuhan sekunder bersama teman-temanmu.</li>
                <li>Berikan tanggapan terhadap pertanyaan teman dengan bahasa yang jelas dan sopan.</li>
                <li>Catatlah hasil diskusi mengenai peran jaringan meristem dalam pertumbuhan tumbuhan.</li>
            </ol>
        </div>

        <div class="card chat-app">
            <div class="chat-header">
                <div class="chat-info">
                    <i class="fas fa-comments-alt"></i>
                    <div>
                        <h4>Forum Diskusi Perkembangan Jaringan Muda</h4>
                        <span id="chatStatusText">Menyambungkan...</span>
                    </div>
                </div>
            </div>

            <div class="chat-body" id="chatBox">
                <div class="text-center text-gray-400 mt-10">
                    <i class="fas fa-spinner fa-spin text-2xl mb-2"></i><br>
                    Memuat pesan...
                </div>
            </div>

            <div class="chat-footer">
                <input type="text" id="inputChat" placeholder="Ketik pertanyaan atau tanggapan..." onkeypress="handleChatEnter(event)">
                <button class="btn-send" onclick="sendChat()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- STEP 3: MENCOBA --}}
    <div class="step-content" id="step3" style="display:none;">
        <div class="card intro-card">
            <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
            <p>Amatilah tahapan perkembangan jaringan muda pada tumbuhan, kemudian lakukan identifikasi berikut:</p>

            <ol>
                <li>Perhatikan nomor yang menunjukkan bagian atau proses perkembangan jaringan muda.</li>
                <li>Bacalah setiap keterangan yang tersedia dengan cermat.</li>
                <li>Pilih nomor yang paling sesuai dengan proses pertumbuhan atau perkembangan jaringan muda.</li>
                <li>Klik tombol <strong>Periksa Jawaban</strong> setelah semua jawaban terisi.</li>
                <li>Pelajari kembali bagian yang belum tepat berdasarkan hasil pemeriksaan.</li>
            </ol>
        </div>

        <div class="matching-grid">
            <div class="card visual-card">
                <div class="placeholder-label-img">
                    <div class="node n1">1</div>
                    <div class="node n2">2</div>
                    <div class="node n3">3</div>
                    <p>Diagram Perkembangan Jaringan Muda Tumbuhan</p>
                </div>
            </div>

            <div class="card quiz-card">
                <h4>Identifikasi Perkembangan Jaringan Muda</h4>

                <div class="match-list">
                    <div class="match-row">
                        <div class="match-label">Pertumbuhan Primer</div>
                        <input type="number" class="match-input" data-answer="1" placeholder="?">
                    </div>

                    <div class="match-row">
                        <div class="match-label">Pertumbuhan Sekunder</div>
                        <input type="number" class="match-input" data-answer="2" placeholder="?">
                    </div>

                    <div class="match-row">
                        <div class="match-label">Diferensiasi Sel Menjadi Jaringan Dewasa</div>
                        <input type="number" class="match-input" data-answer="3" placeholder="?">
                    </div>
                </div>

                <button class="btn-check-materi" onclick="checkMatching()">
                    <i class="fas fa-check-circle"></i> Periksa Jawaban
                </button>

                <div id="feedback-mencoba" class="feedback-msg" style="display:none; margin-top:12px;"></div>
            </div>
        </div>
    </div>

    {{-- STEP 4: MENALAR --}}
    <div class="step-content" id="step4" style="display:none;">
        <div class="card intro-card">
            <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
            <p>Perhatikan tabel pernyataan berikut, kemudian analisislah berdasarkan materi perkembangan jaringan muda tumbuhan.</p>

            <ol>
                <li>Bacalah setiap pernyataan dengan teliti.</li>
                <li>Tentukan apakah pernyataan tersebut benar atau salah.</li>
                <li>Pilih jawaban <strong>Benar</strong> atau <strong>Salah</strong> sesuai pemahamanmu.</li>
                <li>Klik tombol <strong>Periksa Analisis</strong> setelah semua jawaban dipilih.</li>
                <li>Pelajari kembali pernyataan yang belum tepat.</li>
            </ol>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="tf-table" id="table-menalar">
                    <thead>
                        <tr>
                            <th>Pernyataan</th>
                            <th>Penilaian</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr data-answer="benar">
                            <td>Pertumbuhan primer menyebabkan tumbuhan bertambah panjang atau tinggi.</td>
                            <td>
                                <div class="tf-btn-group">
                                    <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                    <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                </div>
                            </td>
                        </tr>

                        <tr data-answer="benar">
                            <td>Pertumbuhan sekunder terjadi pada ujung daun tumbuhan.</td>
                            <td>
                                <div class="tf-btn-group">
                                    <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                    <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                </div>
                            </td>
                        </tr>

                        <tr data-answer="salah">
                            <td>Kambium berperan dalam pertumbuhan sekunder pada tumbuhan.</td>
                            <td>
                                <div class="tf-btn-group">
                                    <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                    <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                </div>
                            </td>
                        </tr>
                        <tr data-answer="benar">
                            <td>Floem berfungsi mengangkut air dan mineral dari akar ke daun.</td>
                            <td>
                                <div class="tf-btn-group">
                                    <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                    <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                </div>
                            </td>
                        </tr>

                        <tr data-answer="salah">
                            <td>Pertumbuhan sekunder membuat batang tumbuhan menjadi lebih besar dan kuat.</td>
                            <td>
                                <div class="tf-btn-group">
                                    <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                    <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="btn-periksa-menalar" class="btn-check-materi" onclick="checkAllAnswers()">
                <i class="fas fa-clipboard-check"></i> Periksa Analisis
            </button>

            <div id="feedback-menalar" class="feedback-msg" style="display:none; margin-top:12px;"></div>
        </div>
    </div>

    {{-- STEP 5: KOMUNIKASI --}}
    <div class="step-content" id="step5" style="display:none;">
        <div class="card intro-card">
            <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
            <p>Jawablah pertanyaan berikut berdasarkan materi dan aktivitas yang telah dilakukan.</p>

            <ol>
                <li>Bacalah pertanyaan dengan saksama.</li>
                <li>Jawablah berdasarkan pemahamanmu tentang perkembangan jaringan muda tumbuhan.</li>
                <li>Tuliskan jawaban pada kolom yang tersedia.</li>
                <li>Periksa kembali jawaban sebelum mengirimkan laporan belajar.</li>
                <li>Tuliskan kesimpulan akhir pembelajaran pada kolom kesimpulan.</li>
            </ol>
        </div>

        <div class="card communication-box">
            <div class="form-item">
                <label>Apa yang kamu ketahui tentang pertumbuhan primer pada tumbuhan?</label>
                <textarea id="jawaban1" class="modern-input" rows="2" placeholder="Tulis jawabanmu di sini..."></textarea>
            </div>
            <div class="form-item">
                <label>Apa yang kamu ketahui tentang pertumbuhan sekunder pada tumbuhan?</label>
                <textarea id="jawaban2" class="modern-input" rows="2" placeholder="Tulis jawabanmu di sini..."></textarea>
            </div>

            <div class="form-item conclusion-box">
                <label>Kesimpulan materi yang kamu pelajari:</label>
                <textarea id="finalConclusion" class="modern-input" rows="4" placeholder="Tuliskan kesimpulanmu..."></textarea>
            </div>

            <button class="btn-submit" onclick="submitCommunication()">
                <i class="fas fa-paper-plane"></i> Kirim Laporan Belajar
            </button>

            <div id="commFeedback" class="feedback-msg" style="text-align:center; margin-top:10px; font-weight:500;"></div>
        </div>
    </div>

</main>

{{-- ================= FOOTER ================= --}}
<div class="footer-action">
    <button class="btn-kembali" onclick="window.location.href='{{ route('materi.index') }}'">
        Kembali
    </button>

    <button id="kuisBtn" disabled class="btn-locked">
        <i class="fas fa-lock"></i> Selesaikan Seluruh Aktivitas
    </button>
</div>

<script>
    let visitedSteps = new Set();
    let isSessionOpen = false;
    let messageCount = 0;
    // --- SWEETALERT2 MASTER ALERT - STYLE SAMA DENGAN ALERT LOGOUT ---
    const swalConfig = {
        customClass: {
            popup: 'rounded-2xl',
            title: 'text-lg font-bold',
            htmlContainer: 'text-sm'
        },
        backdrop: 'rgba(15, 23, 42, 0.6)'
    };

    function panggilAlertCustom(opsi) {
        const tipe = opsi.tipe || 'warning';

        Swal.fire({
            ...swalConfig,
            title: opsi.judul || 'Pemberitahuan',
            text: opsi.pesan || '',
            icon: tipe === 'danger' ? 'error' : tipe,
            showCancelButton: !!opsi.isKonfirmasi,
            confirmButtonColor: tipe === 'danger' ? '#ef4444' : '#15803d',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: opsi.teksKonfirm || 'Oke',
            cancelButtonText: opsi.teksBatal || 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (opsi.onKonfirm) opsi.onKonfirm();
            } else if (result.dismiss && opsi.onBatal) {
                opsi.onBatal();
            }
        });
    }

function switchStep(num) {
        document.querySelectorAll('.step-content').forEach(s => s.style.display = 'none');
        document.getElementById('step' + num).style.display = 'block';
        document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
        document.getElementById('btn-step' + num).classList.add('active');
        
        visitedSteps.add(num);
        checkProgress();

        if(num === 2) { 
            const b = document.getElementById('chatBox');
            setTimeout(() => b.scrollTop = b.scrollHeight, 100);
        }
    }

    function checkProgress() {
        if ([1,2,3,4,5].every(n => visitedSteps.has(n))) {
            const k = document.getElementById('kuisBtn');
            k.disabled = false;
            k.className = 'btn-locked btn-unlocked';
            k.innerHTML = '<i class="fas fa-play"></i> Mulai Kuis Sekarang';
            
            k.onclick = () => {
                window.location.href = "{{ route('kuis3') }}";
            };
        }
    }

    // --- CHAT LOGIC (Real-time DB untuk materi3) ---
    async function loadMessages() {
        try {
            const res = await fetch('/messages/materi3');
            if(!res.ok) throw new Error('Network error');
            const data = await res.json();
            
            let pesanArray = [];
            if (Array.isArray(data)) {
                pesanArray = data; 
                isSessionOpen = true; 
            } else {
                pesanArray = data.messages || []; 
                isSessionOpen = data.is_active !== undefined ? data.is_active : true;
            }
            
            document.getElementById('chatStatusText').innerText = isSessionOpen ? "Sesi Terbuka" : "Sesi Ditutup";
            document.getElementById('inputChat').disabled = !isSessionOpen;

            if (pesanArray.length !== messageCount) {
                const box = document.getElementById('chatBox');
                box.innerHTML = '';
                
                if (pesanArray.length === 0) {
                    box.innerHTML = `<div class="text-center text-gray-400 mt-10"><i class="fas fa-comments text-3xl opacity-20 mb-2"></i><br>Belum ada diskusi</div>`;
                } else {
                    pesanArray.forEach(msg => {
                        const isMe = msg.user_name === "{{ Auth::user()->name }}";
                        const wrapperClass = isMe ? 'msg-out' : 'msg-in';
                        
                        if(msg.user_name === 'Sistem') {
                            box.innerHTML += `<div style="text-align:center; font-size:11px; color:#64748b; margin:10px 0;">-- ${msg.message} --</div>`;
                        } else {
                            box.innerHTML += `
                                <div class="msg-wrapper ${wrapperClass}">
                                    ${!isMe ? `<div class="avatar">${msg.user_name.substring(0,2).toUpperCase()}</div>` : ''}
                                    <div class="msg-content">
                                        <span class="user-name">${isMe ? 'Anda' : msg.user_name}</span>
                                        <div class="bubble">${msg.message}</div>
                                    </div>
                                </div>
                            `;
                        }
                    });
                }
                box.scrollTop = box.scrollHeight;
                messageCount = pesanArray.length;
            }
        } catch(e) {}
    }

    function sendChat() {
        const input = document.getElementById('inputChat');
        const message = input.value.trim();
        if (message !== "" && isSessionOpen) {
            input.value = "";
            fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message, topic: 'materi3' })
            }).then(() => loadMessages());
        }
    }

    function handleChatEnter(e) { if (e.key === 'Enter') sendChat(); }

    // --- STEP 3: MATCHING LOGIC (MENCOBA - BISA DIULANG) ---
    function checkMatching() {
        let correct = 0; let total = 0; let adaKosong = false;
        
        document.querySelectorAll('.match-input').forEach(input => {
            total++;
            if(!input.value.trim()) adaKosong = true;
        });

        if (adaKosong) {
            panggilAlertCustom({
                judul: 'Jawaban Belum Lengkap',
                pesan: 'Silakan isi semua kotak identifikasi sebelum melakukan pemeriksaan!',
                tipe: 'warning'
            });
            return;
        }

        document.querySelectorAll('.match-input').forEach(input => {
            if (input.value.trim() === input.getAttribute('data-answer')) {
                input.style.borderColor = "#10b981";
                input.style.backgroundColor = "#ecfdf5";
                correct++;
            } else {
                input.style.borderColor = "#ef4444";
                input.style.backgroundColor = "#fef2f2";
            }
        });

        const feedbackDiv = document.getElementById('feedback-mencoba');
        feedbackDiv.style.display = 'block';
        feedbackDiv.style.padding = '12px';
        feedbackDiv.style.borderRadius = '10px';
        
        if (correct === total) {
            feedbackDiv.style.backgroundColor = '#d1fae5';
            feedbackDiv.style.color = '#14532d';
            feedbackDiv.innerHTML = `<i class="fas fa-award"></i> Luar biasa! Semua jawaban identifikasi benar (${correct}/${total}).`;

            panggilAlertCustom({
                judul: 'Sempurna!',
                pesan: `Luar biasa! Semua jawaban identifikasi Kamu benar (${correct}/${total}).`,
                tipe: 'success'
            });
        } else {
            feedbackDiv.style.backgroundColor = '#fef3c7';
            feedbackDiv.style.color = '#78350f';
            feedbackDiv.innerHTML = `<i class="fas fa-info-circle"></i> Berhasil menjawab ${correct} dari ${total} bagian dengan benar. Silakan perbaiki kotak yang berwarna merah!`;

            panggilAlertCustom({
                judul: 'Periksa Kembali',
                pesan: `Kamu menjawab ${correct} dari ${total} bagian dengan benar. Silakan koreksi kotak input yang berwarna merah!`,
                tipe: 'danger'
            });
        }
    }

    // --- STEP 4: TRUE/FALSE LOGIC (MENALAR - BERKALI-KALI TANPA BATASAN) ---
    function selectAnswer(button, val) {
        const group = button.parentElement;
        const buttons = group.querySelectorAll('.tf-btn');
        
        buttons.forEach(btn => {
            btn.classList.remove('active', 'btn-b-active', 'btn-s-active');
            btn.style.backgroundColor = '';
            btn.style.color = '';
            btn.style.borderColor = '';
        });
        
        button.classList.add('active');
        button.classList.add(val === 'benar' ? 'btn-b-active' : 'btn-s-active');
        group.dataset.chosen = val;
    }

    function checkAllAnswers() {
        const table = document.getElementById('table-menalar');
        const rows = table.querySelectorAll('tbody tr');
        let totalPernyataan = rows.length;
        let jawabanBenarCount = 0;
        let semuaTerisi = true;

        rows.forEach(row => {
            const group = row.querySelector('.tf-btn-group');
            if (!group.dataset.chosen) { semuaTerisi = false; }
        });

        if (!semuaTerisi) {
            panggilAlertCustom({
                judul: 'Penilaian Belum Lengkap',
                pesan: 'Silakan tentukan keputusan (Benar/Salah) pada semua pernyataan ilmiah terlebih dahulu!',
                tipe: 'warning'
            });
            return;
        }

        rows.forEach(row => {
            const keyAnswer = row.dataset.answer;
            const group = row.querySelector('.tf-btn-group');
            const chosenAnswer = group.dataset.chosen;
            const buttons = group.querySelectorAll('.tf-btn');

            buttons.forEach(btn => {
                btn.disabled = false;
                btn.style.cursor = 'pointer';
                
                if (btn.classList.contains('active')) {
                    if (chosenAnswer === keyAnswer) {
                        btn.style.backgroundColor = '#15803d';
                        btn.style.color = '#ffffff';
                        btn.style.borderColor = '#15803d';
                    } else {
                        btn.style.backgroundColor = '#b91c1c';
                        btn.style.color = '#ffffff';
                        btn.style.borderColor = '#b91c1c';
                    }
                }
            });

            if (chosenAnswer === keyAnswer) { jawabanBenarCount++; }
        });

        const feedbackDiv = document.getElementById('feedback-menalar');
        feedbackDiv.style.display = 'block';
        feedbackDiv.style.padding = '12px';
        feedbackDiv.style.borderRadius = '10px';
        
        if (jawabanBenarCount === totalPernyataan) {
            feedbackDiv.style.backgroundColor = '#d1fae5';
            feedbackDiv.style.color = '#14532d';
            feedbackDiv.innerHTML = `<i class="fas fa-award"></i> Luar biasa! Semua analisis logika menalar Mu benar (${jawabanBenarCount}/${totalPernyataan}).`;
            
            panggilAlertCustom({
                judul: 'Analisis Sempurna!',
                pesan: `Hebat! Seluruh penalaran logika ilmiah Mu valid dan benar (${jawabanBenarCount}/${totalPernyataan}).`,
                tipe: 'success'
            });
        } else {
            feedbackDiv.style.backgroundColor = '#fef3c7';
            feedbackDiv.style.color = '#78350f';
            feedbackDiv.innerHTML = `<i class="fas fa-info-circle"></i> Berhasil menjawab ${jawabanBenarCount} dari ${totalPernyataan} analisis dengan benar. Silakan coba kombinasikan kembali!`;
            
            panggilAlertCustom({
                judul: 'Hasil Pemeriksaan',
                pesan: `Kamu berhasil menganalisis ${jawabanBenarCount} dari ${totalPernyataan} pernyataan dengan benar. Silakan ubah pilihan Kamu untuk mencoba lagi!`,
                tipe: 'danger'
            });
        }
    }

    // --- STEP 5: SUBMIT LOGIC KE DATABASE ---
    async function submitCommunication() {
        const jawab1 = document.getElementById('jawaban1').value.trim();
        const kesimpulan = document.getElementById('finalConclusion').value.trim();

        if(!jawab1 || !kesimpulan) {
            panggilAlertCustom({ judul: 'Kolom Belum Lengkap', pesan: 'Harap isi semua kolom analisis dan kesimpulan sebelum mengirim!', tipe: 'warning' });
            return;
        }

        const gabunganJawaban = "1. " + jawab1;
        
        const btn = document.querySelector('.btn-submit');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan Laporan...';
        btn.disabled = true;

        try {
            // 1. Simpan Pemahaman ke Database
            const resPemahaman = await fetch("{{ route('materi.simpan_pemahaman') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    materi_slug: 'materi3',
                    jawaban: gabunganJawaban,
                    kesimpulan: kesimpulan
                })
            });

            if(!resPemahaman.ok) throw new Error('Gagal simpan pemahaman');

            // 2. Tandai Progress Materi Selesai
            await fetch("{{ route('materi.complete', 'materi3') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Sukses
            const fb = document.getElementById('commFeedback');
            fb.innerHTML = "<span style='color:#10b981'>✅ Laporan belajar berhasil dikirim ke Guru! Silakan klik tombol 'Mulai Kuis Sekarang' di bawah.</span>";
            btn.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil Terkirim';
            btn.style.background = "#059669";
            
            panggilAlertCustom({
                judul: 'Berhasil Dikirim!',
                pesan: 'Laporan belajar berhasil dikirim. Silakan lanjut ke kuis setelah semua aktivitas selesai.',
                tipe: 'success'
            });
            
        } catch(e) {
            panggilAlertCustom({ judul: 'Pengiriman Gagal', pesan: 'Gagal mengirim laporan. Periksa koneksi internet Kamu.', tipe: 'danger' });
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Selesaikan Aktivitas';
            btn.disabled = false;
        }
    }

    // --- FULLSCREEN LOGIC ---
    function toggleFullscreen() {
        const e = document.getElementById('container3D');
        const btnIcon = document.querySelector('#fullscreenBtn i');
        const btnText = document.querySelector('#fullscreenBtn');

        if (!document.fullscreenElement) {
            if (e.requestFullscreen) e.requestFullscreen();
            btnIcon.className = 'fas fa-compress';
            btnText.innerHTML = '<i class="fas fa-compress"></i> Perkecil Layar';
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
        }
    }

    document.addEventListener('fullscreenchange', () => {
        const btnText = document.querySelector('#fullscreenBtn');
        if (!document.fullscreenElement) {
            btnText.innerHTML = '<i class="fas fa-expand"></i> Layar Penuh';
        }
    });

    setInterval(loadMessages, 3000);
    window.onload = () => { 
        switchStep(1); 
        loadMessages();
    };
</script>
@endsection