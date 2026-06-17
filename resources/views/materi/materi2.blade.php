@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

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
    /* ================= MODEL 3D SESUAI SKETSA ================= */
    .model-section {
        position: relative;
    }

    .model-3d-container {
        position: relative;
        width: 100%;
        height: 520px;
        background: #0f172a !important;
        background-color: #0f172a !important;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .viewer-box,
    model-viewer.viewer-box,
    #model3d {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
        background: #0f172a !important;
        background-color: #0f172a !important;
        --poster-color: #0f172a !important;
        --progress-bar-color: #f59e0b !important;
        --progress-mask: #0f172a !important;
        color: #ffffff !important;
    }

    #model3d:not(:defined) {
        background: #0f172a !important;
        background-color: #0f172a !important;
    }

    #model3d::part(default-progress-bar) {
        background-color: #f59e0b !important;
    }

    #model3d::part(default-progress-mask) {
        background-color: #0f172a !important;
    }

    .btn-fullscreen {
        position: absolute;
        bottom: 24px;
        right: 24px;
        background: #f59e0b;
        color: #0f172a;
        border: none;
        padding: 8px 14px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);
        z-index: 20;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-fullscreen:hover {
        background: #d97706;
        transform: scale(1.03);
    }

    .model-bottom-panel {
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .model-caption-text {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        text-align: center;
        line-height: 1.6;
    }

    .model-number-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .model-number-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 2px solid #14532d;
        background: white;
        color: #14532d;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .model-number-btn:hover {
        background: #dcfce7;
        transform: scale(1.08);
    }

    .model-number-btn.active {
        background: #14532d;
        color: white;
        box-shadow: 0 4px 10px rgba(20, 83, 45, 0.3);
    }

    .model-section:fullscreen,
    .model-section:-webkit-full-screen {
        width: 100vw !important;
        height: 100vh !important;
        background: #0f172a !important;
        padding: 20px !important;
        border-radius: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .model-section:fullscreen .model-3d-container,
    .model-section:-webkit-full-screen .model-3d-container {
        flex: 1 !important;
        height: auto !important;
        border-radius: 12px !important;
        background: #0f172a !important;
        background-color: #0f172a !important;
    }

    .model-section:fullscreen .viewer-box,
    .model-section:-webkit-full-screen .viewer-box {
        width: 100% !important;
        height: 100% !important;
        background: #0f172a !important;
        background-color: #0f172a !important;
        --poster-color: #0f172a !important;
    }

    .model-section:fullscreen .model-caption-text,
    .model-section:-webkit-full-screen .model-caption-text {
        color: white !important;
    }

    @media (max-width: 700px) {
        .model-3d-container {
            height: 360px;
        }

        .btn-fullscreen {
            bottom: 16px;
            right: 16px;
            padding: 7px 12px;
        }

        .model-number-btn {
            width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .model-number-controls {
            width: 100%;
            text-align: center;
        }
    }

    

    .plant-identification-img {
        width: 100%;
        max-width: 720px;
        height: auto;
        display: block;
        margin: 0 auto;
        border-radius: 12px;
        background: #ffffff;
    }

    .image-caption {
        margin-top: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        text-align: center;
    }

    .info-identifikasi {
        margin-top: 16px;
        padding: 14px;
        border-radius: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .info-identifikasi h4 {
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #14532d;
    }

    .info-identifikasi p {
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.7;
        color: #475569;
        text-align: justify;
    }

    .info-identifikasi p:last-child {
        margin-bottom: 0;
    }
    .plant-image-box {
        width: 100%;
        text-align: center;
    }

    .plant-identification-img {
        width: 100%;
        max-width: 720px;
        height: auto;
        display: block;
        margin: 0 auto;
        border-radius: 12px;
        background: #ffffff;
    }

    .image-caption {
        margin-top: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        text-align: center;
    }

    .info-identifikasi {
        margin-top: 16px;
        padding: 14px;
        border-radius: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .info-identifikasi h4 {
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #14532d;
    }

    .info-identifikasi p {
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.7;
        color: #475569;
        text-align: justify;
    }

    .info-identifikasi p:last-child {
        margin-bottom: 0;
    }
</style>

<div class="materi-wrapper">
    {{-- ================= HEADER ================= --}}
    <header class="materi-header">
        <h2>STRUKTUR JARINGAN MUDA TUMBUHAN</h2>
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
    @php
        $models3D = [
            [
                'src' => asset('models/melati.glb'),
                'caption' => 'Model 3D Tanaman Melati (belum tersedia)'
            ],
            [
                'src' => asset('models/ujung-batang.glb'),
                'caption' => 'Model 3D Detail Ujung Batang - Meristem Apikal (belum tersedia)'
            ],
            [
                'src' => asset('models/ujung-akar.glb'),
                'caption' => 'Model 3D Detail Ujung Akar - Meristem Apikal (belum tersedia)'
            ],
            [
                'src' => asset('models/pohon-mangga.glb'),
                'caption' => 'Model 3D Pohon Mangga'
            ],
            [
                'src' => asset('models/detail-pohon.glb'),
                'caption' => 'Model 3D Detail Pohon Mangga - Meristem Lateral'
            ],
            [
                'src' => asset('models/tebu.glb'),
                'caption' => 'Model 3D Tanaman Tebu'
            ],
            [
                'src' => asset('models/detail-tebu.glb'),
                'caption' => 'Model 3D Detail Pangkal Ruas Tebu - Meristem Interkalar'
            ],
        ];
    @endphp

    <div id="modelSection3D" class="model-section card">
        <div id="container3D" class="model-3d-container">
            <model-viewer
                id="model3d"
                class="viewer-box"
                src="{{ $models3D[0]['src'] }}"
                alt="{{ $models3D[0]['caption'] }}"
                camera-controls
                auto-rotate
                camera-orbit="0deg 65deg 120%"
                field-of-view="45deg"
                min-camera-orbit="auto auto 30%"
                max-camera-orbit="auto auto 400%"
                shadow-intensity="1"
                exposure="1"
                interaction-prompt="none"
                reveal="auto"
                poster="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1200' height='700' viewBox='0 0 1200 700'%3E%3Crect width='1200' height='700' fill='%230f172a'/%3E%3C/svg%3E"
                style="width: 100%; height: 100%; background: #0f172a; background-color: #0f172a; --poster-color: #0f172a; --progress-mask: #0f172a; --progress-bar-color: #f59e0b; color: #ffffff;">
            </model-viewer>

            <button type="button" id="fullscreenBtn" class="btn-fullscreen" onclick="toggleFullscreen(this)">
                <i class="fas fa-expand"></i> Layar Penuh
            </button>
        </div>

        <div class="model-bottom-panel">
            <div class="model-caption-text" data-model-caption>
                {{ $models3D[0]['caption'] }}
            </div>

            <div class="model-number-controls">
                @foreach ($models3D as $index => $model)
                    <button
                        type="button"
                        class="model-number-btn {{ $index === 0 ? 'active' : '' }}"
                        data-model-src="{{ $model['src'] }}"
                        data-model-caption="{{ $model['caption'] }}"
                        onclick="switchModel3D(this)">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
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
                   <p>Untuk membantu memahami materi, lakukan kegiatan berikut:</p> 
                    <ol>
                        <li>Bacalah materi tentang definisi jaringan muda pada tumbuhan dengan saksama.</li>
                        <li>Amatilah model 3D jaringan muda tumbuhan untuk mengenali letak dan bentuk jaringan muda pada tumbuhan.</li>
                        <li>Identifikasilah bagian-bagian tumbuhan yang mengalami pertumbuhan akibat aktivitas jaringan muda berdasarkan hasil pengamatanmu.</li>
                        <li>Catatlah informasi penting yang kamu temukan dari hasil pengamatan model 3D dan materi pembelajaran.</li>
                    </ol>
            </div>
            <div class="card intro-card">
                <h3>TUJUAN PEMBELAJARAN</h3>

                <ol>
                    <li>Peserta didik dapat mengidentifikasi jenis-jenis jaringan meristem pada tumbuhan.</li>
                    <li>Peserta didik memahami fungsi meristem apikal, lateral, dan interkalar dalam pertumbuhan tumbuhan.</li>
                </ol>

                <h3>PENDAHULUAN</h3>

                <p>
                    Tumbuhan dapat tumbuh menjadi lebih tinggi, lebih besar, dan menghasilkan bagian-bagian baru karena adanya jaringan yang selalu aktif membelah. Jaringan tersebut disebut jaringan meristem atau jaringan muda. Jaringan meristem memiliki peran penting dalam proses pertumbuhan dan perkembangan tumbuhan. Sel-selnya terus membelah dan menghasilkan sel baru yang akan berkembang menjadi berbagai jaringan pada tumbuhan. Berdasarkan letaknya, jaringan meristem dibedakan menjadi meristem apikal, meristem lateral, dan meristem interkalar yang masing-masing memiliki fungsi berbeda dalam membantu pertumbuhan tumbuhan.
                    Pada materi ini, peserta didik akan mempelajari pengertian, letak, fungsi, serta peranan jaringan meristem dalam pertumbuhan tumbuhan. Peserta didik juga akan melakukan berbagai kegiatan pembelajaran bersama teman dan guru, seperti berdiskusi, mengajukan pertanyaan, memberikan tanggapan, dan mencatat informasi penting yang diperoleh selama pembelajaran berlangsung. Kegiatan ini bertujuan agar peserta didik dapat memahami materi secara lebih aktif dan melatih kemampuan berpikir kritis serta komunikasi.
                    Selain itu, peserta didik akan mengamati gambar struktur jaringan meristem, mengidentifikasi bagian-bagian yang terdapat pada gambar, serta menjelaskan fungsi dari setiap jaringan meristem yang ditemukan. Peserta didik juga akan mengerjakan latihan benar dan salah, menjawab pertanyaan berdasarkan hasil diskusi dan pengamatan, serta menyimpulkan materi yang telah dipelajari. Di akhir pembelajaran, peserta didik akan mengerjakan kuis untuk mengukur pemahaman tentang pertumbuhan primer, pertumbuhan sekunder, serta jenis-jenis jaringan meristem pada tumbuhan.
                </p>
            </div>
            <div class="card intro-card">
                <h3>STRUKTUR JARINGAN MUDA TUMBUHAN</h3>
                <p>
                    Jaringan meristem adalah jaringan muda pada tumbuhan yang sel-selnya masih aktif membelah. Jaringan ini berperan penting dalam proses pertumbuhan dan perkembangan tumbuhan. Sel-sel meristem memiliki ukuran kecil, dinding sel tipis, inti sel besar, dan tersusun rapat. Sel-sel tersebut akan terus membelah dan menghasilkan sel baru yang kemudian berkembang menjadi berbagai jaringan pada tumbuhan. Berdasarkan letaknya pada tumbuhan, jaringan meristem dibedakan menjadi meristem apikal, meristem lateral, dan meristem interkalar.
                </p>

                <h4>1. Meristem Apikal</h4>
                <p>
                    Meristem apikal adalah jaringan meristem yang terletak di ujung batang dan ujung akar. Meristem ini berperan dalam pertumbuhan primer, yaitu pertumbuhan yang menyebabkan tanaman bertambah panjang atau tinggi. Amati model 3D Tanaman Melati, Detail Ujung Batang, dan Detail Ujung Akar untuk melihat letak meristem apikal pada bagian ujung batang dan ujung akar tumbuhan.
                </p>

                <p>
                    Pada bagian ini, sel-sel meristem aktif membelah sehingga menghasilkan sel-sel baru. Sel-sel tersebut kemudian berkembang menjadi berbagai jaringan seperti jaringan epidermis, jaringan dasar, dan jaringan pengangkut. Contoh aktivitas meristem apikal dapat dilihat pada tanaman Melati, yaitu pada ujung batang yang terus tumbuh ke atas dan ujung akar yang semakin memanjang.
                </p>

                <h4>2. Meristem Lateral</h4>
                <p>
                    Meristem lateral adalah jaringan meristem yang terletak di sisi batang dan akar. Meristem ini berperan dalam pertumbuhan sekunder, yaitu pertumbuhan yang menyebabkan batang dan akar menjadi lebih besar atau menebal. Amati model 3D Pohon Mangga dan Detail Pohon Mangga untuk melihat meristem lateral berupa kambium vaskular dan kambium gabus.
                </p>

                <p>
                    Kambium vaskular menghasilkan jaringan xilem sekunder dan floem sekunder. Xilem berfungsi mengangkut air dan mineral dari akar ke daun, sedangkan floem berfungsi mengangkut hasil fotosintesis dari daun ke seluruh bagian tumbuhan. Sementara itu, kambium gabus menghasilkan jaringan pelindung yang disebut gabus yang berfungsi melindungi batang tumbuhan dari kerusakan dan kehilangan air. Pertumbuhan sekunder umumnya terjadi pada tumbuhan berkayu, seperti mangga, jati, dan mahoni.
                </p>

                <h4>3. Meristem Interkalar</h4>
                <p>
                    Meristem interkalar adalah jaringan meristem yang terletak di antara jaringan yang telah dewasa, biasanya berada di pangkal ruas batang atau pangkal daun. Amati model 3D Tanaman Tebu dan Detail Pangkal Ruas Tebu untuk melihat letak meristem interkalar.
                </p>

                <p>
                    Meristem ini banyak ditemukan pada tumbuhan rumput-rumputan, seperti padi, jagung, dan tebu. Fungsi meristem interkalar adalah membantu pertumbuhan batang atau daun dengan cepat setelah bagian tersebut dipotong atau rusak. Contohnya dapat dilihat pada tanaman tebu. Setelah batang tebu dipotong saat panen, beberapa waktu kemudian akan muncul tunas-tunas baru dari bagian pangkal batang atau ruas yang masih tersisa. Tunas tersebut kemudian tumbuh menjadi batang tebu baru.
                </p>
            </div>
        </div>
        {{-- STEP 2: MENANYA (Terhubung dengan Database Real-time) --}}
        <div class="step-content" id="step2" style="display:none;">
            <div class="card intro-card">
                <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
                <p>Setelah mengamati materi tentang struktur jaringan muda atau jaringan meristem, lakukan kegiatan berikut bersama teman dan guru:</p>
                <ol>
                    <li>Setelah mengikuti aktivitas mengamati, tunggu hingga guru membuka fitur chat diskusi.</li>
                    <li>Tuliskan pertanyaan atau pendapat yang berkaitan dengan materi definisi jaringan meristem pada tumbuhan melalui fitur chat.</li>
                    <li>Bacalah pertanyaan dan tanggapan yang disampaikan oleh teman-temanmu melalui fitur chat diskusi.</li>
                    <li>Berikan jawaban atau tanggapan yang sesuai serta ikutilah diskusi secara aktif selama fitur chat dibuka oleh guru.</li>
                    <li>Setelah guru menutup fitur chat, catatlah informasi penting yang diperoleh dan tuliskan kesimpulan hasil diskusi mengenai jaringan meristem serta perannya dalam pertumbuhan tumbuhan.</li>
                </ol>
            </div>
            <div class="card chat-app">
                <div class="chat-header">
                    <div class="chat-info">
                        <i class="fas fa-comments-alt"></i>
                        <div>
                            <h4>Forum Diskusi Jaringan Epidermis</h4>
                            <span id="chatStatusText">Menyambungkan...</span>
                        </div>
                    </div>
                </div>
                <div class="chat-body" id="chatBox">
                    <div class="text-center text-gray-400 mt-10"><i class="fas fa-spinner fa-spin text-2xl mb-2"></i><br>Memuat pesan...</div>
                </div>
                <div class="chat-footer">
                    <input type="text" id="inputChat" placeholder="Ketik pertanyaan atau tanggapan..." onkeypress="handleChatEnter(event)">
                    <button class="btn-send" onclick="sendChat()"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        {{-- STEP 3: MENCOBA --}}
        <div class="step-content" id="step3" style="display:none;">
            <div class="card intro-card">
                <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
                <p>Amatilah gambar letak jaringan meristem pada tumbuhan berikut dengan saksama.</p>

                <ol>
                    <li>Perhatikan nomor 1, 2, dan 3 yang menjadi penanda bagian tumbuhan.</li>
                    <li>Bacalah penjelasan pada bagian bawah gambar dan identifikasi dengan cermat.</li>
                    <li>Tentukan nomor yang sesuai dengan jenis jaringan meristem yang ditanyakan.</li>
                    <li>Isikan nomor pada kotak jawaban sesuai hasil pengamatanmu.</li>
                    <li>Klik tombol <strong>Periksa Jawaban</strong> untuk memeriksa ketepatan hasil identifikasi.</li>
                </ol>
            </div>

            <div class="matching-grid">
                <div class="card visual-card">
                    <div class="plant-image-box">
                        <img 
                            src="{{ asset('images/mencoba2.png') }}" 
                            alt="Gambar letak jaringan meristem pada tumbuhan"
                            class="plant-identification-img">

                        <p class="image-caption">
                            Gambar pohon rambutan
                        </p>
                    </div>
                </div>

                <div class="card quiz-card">
                    <h4>Identifikasi Jaringan Meristem</h4>              
                    <div class="match-list">
                        <div class="match-row">
                            <label>Meristem Lateral</label>
                            <input type="number" class="match-input" data-answer="1" min="1" max="3" placeholder="?">
                        </div>

                        <div class="match-row">
                            <label>Meristem Apikal</label>
                            <input type="number" class="match-input" data-answer="2" min="1" max="3" placeholder="?">
                        </div>

                        <div class="match-row">
                            <label>Meristem Interkalar</label>
                            <input type="number" class="match-input" data-answer="3" min="1" max="3" placeholder="?">
                        </div>
                        <div class="info-identifikasi">
                        <h4>Keterangan Penanda</h4>
                        <p>
                            <strong>Nomor 1</strong> menunjukkan bagian batang tumbuhan.
                            yang berperan dalam pertumbuhan sekunder, yaitu pertumbuhan yang menyebabkan batang dan akar menjadi lebih besar atau menebal.
                        </p>

                        <p>
                            <strong>Nomor 2</strong> menunjukkan bagian ujung akar.
                           yang menyebabkan tanaman bertambah panjang atau tinggi. 
                        </p>

                        <p>
                            <strong>Nomor 3</strong> menunjukkan bagian pangkal ruas tumbuhan.
                           membantu pertumbuhan batang atau daun dengan cepat setelah bagian tersebut dipotong atau rusak. 
                        </p>
                    </div>
                    </div>

                    <button class="btn-check-materi" onclick="checkMatching()">
                        <i class="fas fa-check-circle"></i> Periksa Jawaban
                    </button>

                    <div id="feedback-mencoba" style="margin-top: 15px; font-weight: 600; display: none;"></div>
                </div>
            </div>
        </div>

        {{-- STEP 4: MENALAR --}}
        <div class="step-content" id="step4" style="display:none;">
            <div class="card intro-card">
                    <h3><i class="fas fa-search"></i> Petunjuk Aktivitas</h3>
                    <p>Perhatikan tabel pernyataan berikut dengan teliti, kemudian lakukan kegiatan berikut:</p>
                    <ol>
                        <li>Bacalah setiap pernyataan yang ditampilkan pada tabel dengan cermat.</li>
                        <li>Analisislah isi setiap pernyataan berdasarkan materi yang telah dipelajari.</li>
                        <li>Pilihlah jawaban <strong>Benar</strong> atau <strong>Salah</strong> pada setiap pernyataan sesuai dengan pemahamanmu.</li>
                        <li>Setelah semua jawaban dipilih, klik tombol <strong>Periksa Jawaban</strong> untuk mengetahui hasil pekerjaanmu.</li>
                        <li>Pelajarilah kembali pernyataan yang belum tepat berdasarkan hasil yang diperoleh.</li>
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
                                <td>Meristem apikal terletak di ujung batang dan ujung akar tumbuhan.</td>
                                <td>
                                    <div class="tf-btn-group">
                                        <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                        <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-answer="salah">
                                <td>Meristem lateral berfungsi membantu tumbuhan bertambah panjang.</td>
                                <td>
                                    <div class="tf-btn-group">
                                        <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                        <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-answer="benar">
                                <td>Meristem interkalar banyak ditemukan pada tumbuhan rumput-rumputan seperti padi dan jagung.</td>
                                <td>
                                    <div class="tf-btn-group">
                                        <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                        <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-answer="salah">
                                <td>Xilem berfungsi mengangkut hasil fotosintesis ke seluruh bagian tumbuhan.</td>
                                <td>
                                    <div class="tf-btn-group">
                                        <button type="button" class="tf-btn btn-b" onclick="selectAnswer(this, 'benar')">Benar</button>
                                        <button type="button" class="tf-btn btn-s" onclick="selectAnswer(this, 'salah')">Salah</button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-answer="benar">
                                <td>Jaringan meristem merupakan jaringan muda yang sel-selnya aktif membelah.</td>
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
                    <p>Jawablah pertanyaan-pertanyaan dibawah ini berdasarkan materi dan hasil kegiatan yang telah dilakukan, gunakan langkah berikut:</p>
                    <ol>
                        <li>Bacalah setiap pertanyaan dengan saksama.</li>
                        <li>Jawablah setiap pertanyaan berdasarkan materi dan hasil kegiatan pembelajaran yang telah kamu lakukan.</li>
                        <li>Tuliskan jawaban dan pendapatmu pada kolom yang telah disediakan.</li>
                        <li>Periksalah kembali jawabanmu sebelum mengirimkan hasil pekerjaan.</li>
                        <li>Tuliskan kesimpulan berdasarkan materi dan kegiatan yang telah dilakukan pada kolom kesimpulan yang tersedia.</li>
                    </ol>
            </div>
            <div class="card communication-box">
                <div class="form-item">
                    <label>Apa yang kamu ketahui tentang pertumbuhan primer pada tumbuhan?</label>
                    <textarea id="jawaban1" class="modern-input" rows="2" placeholder="Tulis analisis singkatmu..."></textarea>
                </div>
                <div class="form-item">
                    <label>Apa yang kamu ketahui tentang pertumbuhan sekunder pada tumbuhan?</label>
                    <textarea id="jawaban2" class="modern-input" rows="2" placeholder="Tulis analisis singkatmu..."></textarea>
                </div>

                <div class="form-item conclusion-box">
                    <label>Kesimpulan materi yang kamu pelajari:</label>
                    <textarea id="finalConclusion" class="modern-input" rows="4" placeholder="Tulis kesimpulanmu..."></textarea>
                </div>

                <button class="btn-submit" onclick="submitCommunication()">
                    <i class="fas fa-paper-plane"></i> Kirim Laporan Belajar
                </button>
                <div id="commFeedback" class="feedback-msg" style="text-align: center; margin-top: 10px; font-weight: 500;"></div>
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
</div>
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
                // FIXED: MENGARAH KE KUIS 2
                window.location.href = "{{ route('kuis2') }}";
            };
        }
    }

    // --- CHAT LOGIC (Real-time DB untuk materi2) ---
    async function loadMessages() {
        try {
            // FIXED: MENGAMBIL CHAT MATERI 2
            const res = await fetch('/messages/materi2');
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
                // FIXED: MENGIRIM CHAT KE MATERI 2
                body: JSON.stringify({ message: message, topic: 'materi2' })
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
        const jawab2 = document.getElementById('jawaban2').value.trim();
        const kesimpulan = document.getElementById('finalConclusion').value.trim();

        if(!jawab1 || !jawab2 || !kesimpulan) {
            panggilAlertCustom({ judul: 'Kolom Belum Lengkap', pesan: 'Harap isi semua kolom analisis dan kesimpulan sebelum mengirim!', tipe: 'warning' });
            return;
        }

        const gabunganJawaban = "1. " + jawab1 + "\n\n2. " + jawab2;
        
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
                    materi_slug: 'materi2', // FIXED: SIMPAN KE MATERI 2
                    jawaban: gabunganJawaban,
                    kesimpulan: kesimpulan
                })
            });

            if(!resPemahaman.ok) throw new Error('Gagal simpan pemahaman');

            // 2. Tandai Progress Materi Selesai
            await fetch("{{ route('materi.complete', 'materi2') }}", { // FIXED: COMPLETE MATERI 2
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

    // --- MODEL 3D LOGIC ---
    function switchModel3D(button) {
        const viewer = document.getElementById('model3d');
        const caption = document.querySelector('[data-model-caption]');

        if (!viewer || !button) return;

        const modelSrc = button.dataset.modelSrc;
        const modelCaption = button.dataset.modelCaption || 'Model 3D';

        if (!modelSrc) return;

        viewer.setAttribute('src', modelSrc);
        viewer.setAttribute('alt', modelCaption);
        viewer.style.background = '#0f172a';
        viewer.style.backgroundColor = '#0f172a';
        viewer.style.setProperty('--poster-color', '#0f172a');
        viewer.style.setProperty('--progress-mask', '#0f172a');
        viewer.style.setProperty('--progress-bar-color', '#f59e0b');

        if (caption) {
            caption.textContent = modelCaption;
        }

        document.querySelectorAll('.model-number-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        button.classList.add('active');

        setTimeout(() => {
            if (typeof viewer.updateFraming === 'function') viewer.updateFraming();
            if (typeof viewer.jumpCameraToGoal === 'function') viewer.jumpCameraToGoal();
        }, 300);
    }

    // --- FULLSCREEN LOGIC MODEL 3D ---
    function toggleFullscreen(button) {
        const section = document.getElementById('modelSection3D');

        if (!section || !button) return;

        if (!document.fullscreenElement) {
            if (section.requestFullscreen) {
                section.requestFullscreen();
            } else if (section.webkitRequestFullscreen) {
                section.webkitRequestFullscreen();
            }

            button.innerHTML = '<i class="fas fa-compress"></i> Perkecil Layar';
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }

            button.innerHTML = '<i class="fas fa-expand"></i> Layar Penuh';
        }

        setTimeout(() => {
            const viewer = document.getElementById('model3d');
            if (viewer && typeof viewer.updateFraming === 'function') viewer.updateFraming();
            if (viewer && typeof viewer.jumpCameraToGoal === 'function') viewer.jumpCameraToGoal();
        }, 300);
    }

    document.addEventListener('fullscreenchange', () => {
        const btnText = document.querySelector('#fullscreenBtn');
        const viewer = document.getElementById('model3d');

        if (btnText) {
            btnText.innerHTML = document.fullscreenElement
                ? '<i class="fas fa-compress"></i> Perkecil Layar'
                : '<i class="fas fa-expand"></i> Layar Penuh';
        }

        setTimeout(() => {
            if (viewer && typeof viewer.updateFraming === 'function') viewer.updateFraming();
            if (viewer && typeof viewer.jumpCameraToGoal === 'function') viewer.jumpCameraToGoal();
        }, 300);
    });

    setInterval(loadMessages, 3000);
    window.onload = () => { 
        switchStep(1); 
        loadMessages();
    };
</script>
@endsection