@extends('layouts.app')

@section('content') 

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .petunjuk-box{
        max-width: 850px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #dcfce7;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        text-align: left;
    }

    .warning-icon{
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #fef3c7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .warning-icon i{
        font-size: 48px;
        color: #f59e0b;
    }

    .quiz-main-title{
        margin: 0;
        font-size: 38px;
        font-weight: 700;
        color: #14532d;
        line-height: 1.2;
        text-align: center;
    }

    .petunjuk-title{
        margin: 8px 0 30px;
        font-size: 22px;
        font-weight: 500;
        color: #15803d;
        text-align: center;
    }

    .peraturan-title{
        margin: 0 0 20px;
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        color: #14532d;
    }

    .petunjuk-list{
        max-width: 700px;
        margin: 0 auto 24px;
        padding-left: 28px;
        text-align: left;
    }

    .petunjuk-list li{
        display: list-item;
        text-align: left;
        margin-bottom: 12px;
        line-height: 1.8;
        color: #334155;
        font-size: 15px;
    }

    .petunjuk-list li:last-child{
        margin-bottom: 0;
    }

    .btn-center{
        text-align: center;
    }

    .btn-primary-lg{
        padding: 14px 28px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        font-weight: var(--fw-semibold);
        font-size: var(--fs-button);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--primary);
        color: white;
        margin-top: var(--spacing-lg);
    }

    .btn-primary-lg:hover{
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    @media (max-width:768px){
        .petunjuk-box{
            padding: 24px;
        }

        .warning-icon{
            width: 80px;
            height: 80px;
        }

        .warning-icon i{
            font-size: 38px;
        }

        .quiz-main-title{
            font-size: 30px;
        }

        .petunjuk-title{
            font-size: 18px;
            margin-bottom: 20px;
        }

        .peraturan-title{
            font-size: 20px;
        }

        .petunjuk-list{
            padding-left: 22px;
        }
    }

    .petunjuk-list li{
        margin-bottom: 12px;
        line-height: 1.8;
        color: #334155;
        font-size: 15px;
    }

    .petunjuk-list li:last-child{
        margin-bottom: 0;
    }

    .btn-primary-lg{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: #15803d;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease;
    }

    .btn-primary-lg:hover{
        background: #14532d;
    }

    @media (max-width:768px){

        .petunjuk-box{
            padding: 24px;
        }

        .warning-icon{
            width: 80px;
            height: 80px;
        }

        .warning-icon i{
            font-size: 38px;
        }

        .quiz-main-title{
            font-size: 30px;
        }

        .petunjuk-title{
            font-size: 18px;
        }

        .petunjuk-content{
            padding: 18px;
        }
    }
    .btn-primary-lg {
        padding: 14px 28px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        font-weight: var(--fw-semibold);
        font-size: var(--fs-button);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        background: var(--primary);
        color: white;

        margin-top: var(--spacing-lg);
    }

    .btn-primary-lg:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }
    :root {
        --fs-h1: 32px; --fs-h2: 24px; --fs-h3: 18px; --fs-h4: 16px;
        --fs-body-l: 16px; --fs-body-m: 14px; --fs-body-s: 13px;
        --fs-button: 14px; --fs-button-small: 13px; --fs-badge: 11px;
        
        --fw-regular: 400; --fw-medium: 500; --fw-semibold: 600; --fw-bold: 700;
        
        --primary: #16a34a; --primary-dark: #15803d; --secondary: #14532d;
        --slate-800: #1e293b; --slate-600: #475569; --border: #e2e8f0; --white: #ffffff;
        --danger: #dc2626; --warning: #f59e0b;
        
        --spacing-sm: 8px; --spacing-md: 12px; --spacing-lg: 16px; --spacing-xl: 20px; --spacing-2xl: 24px;
    }

    * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { background-color: #f8fafc; }

    .evaluasi-container { max-width: 900px; margin: 30px auto; padding: 0 20px; transition: all 0.3s ease; }
    .quiz-title{
    font-size:32px;
    font-weight:700;
    color:#14532d;
    margin-bottom:4px;
    }

    .quiz-subtitle{
        font-size:18px;
        font-weight:500;
        color:#15803d;
        margin-top:0;
        margin-bottom:18px;
    }
    
    .petunjuk-box, .soal-box, .hasil-box { background: var(--white); padding: var(--spacing-2xl); border-radius: 18px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; transition: all 0.3s ease; }
    
    .petunjuk-box h3 { font-weight: var(--fw-semibold); margin-bottom: var(--spacing-lg); color: var(--slate-800); font-size: var(--fs-h3); display: flex; align-items: center; gap: 8px; }
    .petunjuk-box ol li { margin-bottom: var(--spacing-sm); color: var(--slate-600); font-size: var(--fs-body-m); line-height: 1.6; }
    
    .quiz-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-xl); gap: var(--spacing-lg); flex-wrap: wrap; }
    .timer-box { background: #fef2f2; color: #dc2626; padding: 10px 20px; border-radius: 12px; font-weight: var(--fw-semibold); font-size: var(--fs-button); display: flex; align-items: center; gap: 8px; border: 1px solid #fecaca; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1); }
    .timer-box.warning-time { animation: pulse 1s infinite; background: #dc2626; color: white; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }

    .nomor-grid { display: flex; gap: 8px; flex-wrap: wrap; max-width: 100%; justify-content: flex-end; }
    .nomor-btn { width: 38px; height: 38px; border-radius: 10px; border: 1px solid var(--border); background: var(--white); cursor: pointer; font-weight: var(--fw-medium); font-size: var(--fs-body-s); transition: all 0.2s ease; }
    .nomor-btn:hover { transform: translateY(-2px); border-color: var(--primary); }
    .nomor-btn.sudah { background: var(--primary); color: var(--white); border-color: var(--primary-dark); }
    .nomor-btn.sulit { background: var(--warning); color: var(--white); border-color: #d97706; }
    .nomor-btn.current { background: var(--secondary); color: white; border-color: var(--secondary); transform: scale(1.1); box-shadow: 0 4px 10px rgba(20, 83, 45, 0.3); }
    
    .soal-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-xl); flex-wrap: wrap; gap: var(--spacing-sm); }
    .badge-nomor { background: #f1f5f9; padding: 6px 16px; border-radius: 10px; font-weight: var(--fw-semibold); color: var(--slate-600); font-size: var(--fs-body-s); border: 1px solid var(--border); }
    .btn-sulit { background: transparent; border: 1px solid var(--border); padding: 6px 14px; border-radius: 10px; cursor: pointer; font-size: var(--fs-body-s); font-weight: var(--fw-medium); transition: 0.2s; color: var(--slate-600); }
    .btn-sulit:hover { border-color: var(--warning); background: #fffbeb; color: #d97706; }
    
    .soal-text { font-size: var(--fs-h3); line-height: 1.7; color: var(--slate-800); font-weight: var(--fw-semibold); margin-bottom: var(--spacing-2xl); }
    
    .pilihan-btn-custom { width: 100%; text-align: left; padding: 16px 20px; margin-bottom: var(--spacing-md); border: 2px solid var(--border); border-radius: 14px; background: var(--white); cursor: pointer; transition: all 0.2s ease; font-size: var(--fs-body-m); font-weight: var(--fw-medium); color: var(--slate-600); display: flex; align-items: center; gap: 12px; }
    .pilihan-btn-custom:hover { border-color: var(--primary-light); background: #f0fdf4; transform: translateX(4px); }
    .pilihan-btn-custom.aktif { background: #f0fdf4; border-color: var(--primary); color: var(--primary-dark); font-weight: var(--fw-semibold); box-shadow: 0 4px 12px rgba(22, 163, 74, 0.1); }
    
    .isian-container { background: #f8fafc; padding: 20px; border-radius: 14px; border: 1px dashed #cbd5e1; }
    .isian-input { width: 100%; padding: 16px; border: 2px solid var(--border); border-radius: 12px; font-size: var(--fs-body-m); font-family: 'Poppins', sans-serif; transition: all 0.3s ease; resize: none; background: white; color: var(--slate-800); }
    .isian-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15); }
    
    .nav-btn-container { display: flex; justify-content: space-between; margin-top: var(--spacing-3xl); gap: var(--spacing-lg); }
    .btn-nav { padding: 12px 28px; border-radius: 12px; font-weight: var(--fw-semibold); cursor: pointer; border: none; transition: all 0.3s ease; font-size: var(--fs-button); display: flex; align-items: center; gap: 8px;}
    .btn-prev { background: #e2e8f0; color: var(--slate-600); }
    .btn-prev:hover { background: #cbd5e1; transform: translateX(-3px); }
    .btn-next { background: var(--primary); color: var(--white); box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2); }
    .btn-next:hover { background: var(--primary-dark); transform: translateX(3px); }
    .btn-finish { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); box-shadow: 0 4px 15px rgba(20, 83, 45, 0.3); }
    .btn-finish:hover { transform: translateY(-2px); }
    .nav-right { display: flex; gap: var(--spacing-md); }
    
    .hasil-content { text-align: center; }
    .skor-display { font-size: 5.5rem; font-weight: var(--fw-extrabold); color: var(--primary); margin: 0; text-shadow: 0 4px 15px rgba(22, 163, 74, 0.2); line-height: 1; }
    .icon-success { font-size: 4rem; margin-bottom: var(--spacing-md); animation: bounceIn 0.8s ease; }
    @keyframes bounceIn { 0% { transform: scale(0); } 50% { transform: scale(1.2); } 100% { transform: scale(1); } }

    .hasil-action { display: flex; justify-content: center; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-xl); }
    .btn-secondary, .btn-retry, .btn-next-materi { padding: 14px 28px; border-radius: 12px; border: none; cursor: pointer; font-weight: var(--fw-semibold); font-size: var(--fs-button); transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-secondary { background: #f1f5f9; color: var(--slate-600); border: 1px solid var(--border); }
    .btn-secondary:hover { background: #e2e8f0; transform: translateY(-2px); }
    .btn-retry { background: var(--warning); color: var(--white); box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3); }
    .btn-retry:hover { background: #d97706; transform: translateY(-2px); }
    .btn-next-materi { background: var(--primary); color: var(--white); box-shadow: 0 4px 10px rgba(22, 163, 74, 0.3); }
    .btn-next-materi:hover { background: var(--primary-dark); transform: translateY(-2px); }
    
    /* AREA REVIEW */
    .review-wrapper { margin-top: 40px; padding-top: 30px; border-top: 3px dashed #cbd5e1; text-align: left; }
    .review-title { font-size: var(--fs-h3); font-weight: var(--fw-bold); color: var(--slate-800); margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
    .review-title i { color: var(--primary); }
    
    .review-card { border: 1px solid var(--border); border-radius: 16px; margin-bottom: 20px; overflow: hidden; background: var(--white); box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: 0.3s; }
    .review-card:hover { box-shadow: 0 8px 20px rgba(0,0,0,0.06); transform: translateY(-2px); }
    
    .review-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; border-bottom: 1px solid var(--border); }
    .review-header.benar { background: #ecfdf5; border-bottom-color: #a7f3d0; }
    .review-header.salah { background: #fef2f2; border-bottom-color: #fecaca; }
    .review-header.kosong { background: #f1f5f9; border-bottom-color: #e2e8f0; }
    
    .review-q { font-weight: var(--fw-semibold); font-size: var(--fs-body-l); color: var(--slate-800); margin: 0; line-height: 1.6; flex: 1; }
    .review-badge { padding: 6px 14px; border-radius: 30px; font-size: 12px; font-weight: var(--fw-bold); color: white; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .review-badge.benar { background: var(--primary); }
    .review-badge.salah { background: var(--danger); }
    .review-badge.kosong { background: var(--slate-600); }
    
    .review-body { padding: 20px; }
    .review-ans-box { border: 1px solid var(--border); padding: 14px 16px; border-radius: 12px; background: #f8fafc; }
    .review-ans-label { font-size: 12px; color: var(--slate-600); margin-bottom: 6px; font-weight: var(--fw-bold); text-transform: uppercase; letter-spacing: 0.5px; }
    .review-ans-val { font-size: var(--fs-body-l); font-weight: var(--fw-bold); }
    .review-ans-val.benar { color: var(--primary-dark); }
    .review-ans-val.salah { color: var(--danger-dark); }
    .review-ans-val.kosong { color: var(--slate-500); font-weight: var(--fw-medium); font-style: italic;}
    
    .review-key-box { margin-top: 16px; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px; font-size: var(--fs-body-m); font-weight: var(--fw-medium); }
    .review-key-box.hidden-key { background: #f1f5f9; color: var(--slate-600); border: 1px dashed #cbd5e1; }
    .review-key-box.show-key { background: #ecfdf5; color: var(--primary-dark); border: 1px solid #a7f3d0; }
    .review-key-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.08); font-size: 14px; flex-shrink: 0; }
    
    .evaluasi-container:fullscreen, .evaluasi-container:-webkit-full-screen { background-color: #f8fafc !important; max-width: 100vw !important; width: 100% !important; height: 100vh !important; overflow-y: auto !important; padding: 40px 20px !important; }
    body.mode-evaluasi .sidebar, body.mode-evaluasi nav, body.mode-evaluasi header { display: none !important; }
    
    .pelanggaran-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(10px); display: flex; justify-content: center; align-items: center; z-index: 9999999; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    .pelanggaran-overlay.show { opacity: 1; pointer-events: auto; }
    .pelanggaran-box { background: white; padding: 40px; border-radius: 20px; text-align: center; max-width: 500px; width: 90%; transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 2px solid var(--danger); box-shadow: 0 20px 40px rgba(239, 68, 68, 0.2); }
    .pelanggaran-overlay.show .pelanggaran-box { transform: scale(1); }

    .alert-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 999999; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
    .alert-overlay.show { opacity: 1; pointer-events: auto; }
    .alert-modal { background: var(--white); padding: var(--spacing-2xl); border-radius: 16px; max-width: 420px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid var(--border); transform: scale(0.95); transition: transform 0.2s ease; }
    .alert-overlay.show .alert-modal { transform: scale(1); }
    .alert-icon { font-size: 3.5rem; margin-bottom: var(--spacing-md); }
    .alert-icon.warning { color: var(--warning); }
    .alert-icon.danger { color: var(--danger); }
    .alert-icon.success { color: var(--primary); }
    .alert-title { font-size: var(--fs-h3); font-weight: var(--fw-bold); color: var(--slate-800); margin-bottom: var(--spacing-sm); }
    .alert-message { font-size: var(--fs-body-m); color: var(--slate-600); line-height: 1.6; margin-bottom: var(--spacing-xl); }
    .alert-actions { display: flex; gap: var(--spacing-md); justify-content: center; }
    .btn-alert { flex: 1; padding: 12px var(--spacing-lg); border-radius: 12px; font-size: var(--fs-button); font-weight: var(--fw-semibold); cursor: pointer; border: none; transition: all 0.2s; }
    .btn-alert-primary { background: var(--primary); color: var(--white); }
    .btn-alert-primary:hover { background: var(--primary-dark); }
    .btn-alert-danger { background: var(--danger); color: var(--white); }
    .btn-alert-secondary { background: #f1f5f9; color: var(--slate-600); border: 1px solid var(--border); }
    
    .info-box-blue { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 16px; border-radius: 14px; max-width: 600px; margin: 0 auto 24px auto; font-size: var(--fs-body-m); font-weight: var(--fw-medium); display: flex; align-items: center; justify-content: center; gap: 12px; text-align: left; }
    .info-box-blue i { font-size: 24px; color: #3b82f6; }
    .motivasi-text { color: var(--slate-600); margin-bottom: 24px; font-weight: var(--fw-medium); font-size: var(--fs-body-l); line-height: 1.6; padding: 0 20px; }
</style>
{{-- ================= AREA PETUNJUK KUIS ================= --}}
<h2 class="quiz-main-title">KUIS</h2>
<h3 class="petunjuk-title">Struktur Jaringan Muda Tumbuhan</h3>

<div class="petunjuk-box" id="petunjukBox" style="display:none;">
    <div class="warning-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>

    <h4 class="peraturan-title">Peraturan Kuis</h4>

    <ol class="petunjuk-list">
        <li>Kuis ini terdiri dari soal Pilihan Ganda dan Isian Singkat.</li>
        <li>Waktu pengerjaan adalah <strong>20 menit</strong>.</li>
        <li>Sistem menerapkan <strong>Layar Penuh (Fullscreen) Mutlak</strong>. Jika kamu menekan tombol <strong>ESC</strong>, kuis akan dibekukan.</li>
        <li>Kamu memiliki <strong>Maksimal 3 Kali Percobaan</strong>. Sistem hanya akan menyimpan <strong>Nilai Tertinggi</strong>.</li>
        <li>Kunci jawaban yang benar hanya akan ditampilkan pada <strong>Percobaan Terakhir (Ke-3)</strong>.</li>
    </ol>

    <div class="btn-center">
        <button onclick="mulaiKuis()" class="btn-primary-lg" id="btnMulai">
            <i class="fas fa-play-circle"></i>
            Mulai Kuis
        </button>
    </div>
</div>

    {{-- ================= AREA SOAL ================= --}}
    <div id="areaSoal" style="display:none;">
        <div class="quiz-header">
            <div class="timer-box" id="timerBox">
                <i class="fas fa-stopwatch"></i> Sisa Waktu : <span id="timerText">20:00</span>
            </div>
            <div class="nomor-grid" id="nomorGrid"></div>
        </div>

        <div class="soal-box">
            <div class="soal-meta">
                <span id="soalNomor" class="badge-nomor"></span>
                <button onclick="toggleSulit()" class="btn-sulit" id="btnSulit">
                    <i class="far fa-star"></i> Tandai Ragu / Sulit
                </button>
            </div>
            
            <p id="soalText" class="soal-text">Memuat pertanyaan...</p>
            <div id="areaJawaban" class="jawaban-container"></div>
        </div>

        <div class="nav-btn-container">
            <button type="button" onclick="prevSoal()" class="btn-nav btn-prev" id="btnPrev">
                <i class="fas fa-chevron-left" style="margin-right: 8px;"></i> Sebelumnya
            </button>
            
            <div class="nav-right">
                <button type="button" onclick="nextSoal()" class="btn-nav btn-next" id="btnNext">
                    Selanjutnya <i class="fas fa-chevron-right" style="margin-left: 8px;"></i>
                </button>
                <button type="button" onclick="selesaiKuis()" class="btn-nav btn-finish" id="btnFinish" style="display:none;">
                    Selesai & Kumpulkan <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= HASIL & REVIEW ================= --}}
    <div class="hasil-box" id="hasilBox" style="display:none;">
        <div class="hasil-content">
            <div class="icon-success" id="hasilIcon" style="color: var(--primary);"><i class="fas fa-medal"></i></div>
            <h3 style="font-size: var(--fs-h2); font-weight: var(--fw-bold); color: var(--slate-800); margin-bottom: 8px;">Skor Kuis Kamu</h3>
            
            <h1 id="skorText" class="skor-display"></h1>
            <p id="pesanMotivasi" class="motivasi-text"></p>
            
            <div class="info-box-blue">
                <i class="fas fa-cloud-upload-alt"></i>
                <div>
                    Sistem selalu menyimpan <strong>Nilai Tertinggi</strong> dari seluruh percobaan Kamu.
                    <div id="infoPercobaanTeks" style="font-size: 12px; margin-top: 4px; color: #2563eb;"></div>
                </div>
            </div>

            <div class="hasil-action" id="actionButtons">
                <button onclick="cobaLagiKuis()" class="btn-retry" id="btnCobaLagi" style="display:none;">
                    <i class="fas fa-redo"></i> Coba Lagi (<span id="sisaPercobaan"></span>)
                </button>

                <a href="{{ route('materi.index') }}" class="btn-secondary">
                    <i class="fa-solid fa-book"></i> Halaman Materi
                </a>
                
                <a href="{{ route('materi3') }}" class="btn-next-materi" id="btnMateriSelanjutnya">
                    Lanjut Materi 3 <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>

            <div id="reviewContainer"></div>

        </div>
    </div>

</div>

{{-- ================= OVERLAY ANTI-KECURANGAN ================= --}}
<div id="pelanggaranOverlay" class="pelanggaran-overlay">
    <div class="pelanggaran-box">
        <i class="fas fa-exclamation-triangle" style="color: var(--danger); font-size: 60px; margin-bottom: 16px;"></i>
        <h2 style="font-size: var(--fs-h2); font-weight: var(--fw-bold); color: var(--slate-800); margin-bottom: 8px;">PELANGGARAN SISTEM!</h2>
        <p style="color: var(--slate-600); margin-bottom: 24px;">Kamu terdeteksi keluar dari Mode Layar Penuh. Pengerjaan kuis Kamu dihentikan sementara. Harap segera kembali ke Layar Penuh untuk melanjutkan!</p>
        <button onclick="kembaliKeFullscreen()" class="btn-primary-lg" style="margin-top: 0; background: var(--danger);">
            <i class="fas fa-expand" style="margin-right: 8px;"></i> Kembali ke Layar Penuh
        </button>
    </div>
</div>

{{-- ================= MODAL ALERT ================= --}}
<div id="customAlertOverlay" class="alert-overlay">
    <div class="alert-modal">
        <div id="alertIcon" class="alert-icon"></div>
        <h3 id="alertTitle" class="alert-title"></h3>
        <p id="alertMessage" class="alert-message"></p>
        <div id="alertActions" class="alert-actions"></div>
    </div>
</div>

<script>
    const dataSoal = @json($soal ?? []); 
    let currentSoalIndex = 0;
    let jawabanSiswa = {}; 
    let soalSulit = new Array(dataSoal.length).fill(false);
    let waktuDefault = 20 * 60; 
    let waktu = waktuDefault;
    let timerInterval = null;
    let kuisAktif = false;
    let nilaiDiDB = {{ $nilaiSudahAda !== null ? $nilaiSudahAda : -1 }};

    // MENDAPATKAN ID USER AGAR MEMORI SPESIFIK PER AKUN
    const userId = "{{ auth()->id() }}"; 
    // MENGUBAH VARIABEL UNTUK KUIS 2
    const keyPercobaan = 'percobaanKuis2_user_' + userId;
    const keyJawaban = 'jawabanKuis2_Siswa_user_' + userId;

    const MAX_PERCOBAAN = 3;
    if (!localStorage.getItem(keyPercobaan)) {
        localStorage.setItem(keyPercobaan, '0');
    }

    // ====== LOGIKA TAMPILAN AWAL SANGAT CERDAS ======
    document.addEventListener('DOMContentLoaded', () => {
        let percobaanKe = parseInt(localStorage.getItem(keyPercobaan));
        
        // Cek jika siswa re-load halaman saat kesempatan sudah habis ATAU sudah ada nilai di DB
        if(nilaiDiDB !== -1 || percobaanKe >= MAX_PERCOBAAN) {
            document.getElementById('petunjukBox').style.display = 'none';
            document.getElementById('areaSoal').style.display = 'none';
            document.getElementById('hasilBox').style.display = 'block';
            
            // Ambil Skor (Jika nilai DB ada, jadikan prioritas)
            let skorTampil = nilaiDiDB !== -1 ? nilaiDiDB : 0;
            setupTampilanHasilAkhir(skorTampil, percobaanKe);

            // BONGKAR MEMORI JAWABAN (localStorage) KHUSUS JIKA KESEMPATAN HABIS
            if (percobaanKe >= MAX_PERCOBAAN) {
                let savedAns = localStorage.getItem(keyJawaban);
                let parsedAns = savedAns ? JSON.parse(savedAns) : {};
                generateHtmlReview(parsedAns, true);
            } else {
                document.getElementById('reviewContainer').innerHTML = ''; // Jangan tampilkan review jika belum percobaan terakhir
            }

        } else {
            // Belum pernah mengerjakan, tampilkan petunjuk
            document.getElementById('petunjukBox').style.display = 'block';
            document.getElementById('hasilBox').style.display = 'none';
        }
    });

    function generateHtmlReview(jawabanYangAkanDireview, isLastAttempt) {
        let htmlReview = `<div class="review-wrapper">
                            <h4 class="review-title"><i class="fas fa-clipboard-check"></i> Rincian Evaluasi & Kunci Jawaban</h4>
                            <p class="text-sm text-slate-500 mb-6 italic">*Ini adalah rekaman jawaban dari percobaan kuis terakhir Kamu.</p>
                            <div>`;

        dataSoal.forEach((soal, index) => {
            let isPilihanGanda = (soal.a || soal.b || soal.c || soal.d);
            let jawab = jawabanYangAkanDireview[index];
            let isBenar = false;
            let isKosong = (jawab === undefined || jawab === null || jawab.toString().trim() === "");
            let kunciAsli = soal.kunci.toString().trim();

            if (!isKosong) {
                if (isPilihanGanda) {
                    if (jawab.toString() === kunciAsli) isBenar = true;
                } else {
                    let inputSiswa = jawab.toString().toLowerCase().trim();
                    if (inputSiswa === kunciAsli.toLowerCase()) isBenar = true;
                }
            }

            // Custom CSS Classes untuk UI yang Elegan
            let headerClass = isBenar ? 'benar' : (isKosong ? 'kosong' : 'salah');
            let badgeClass = isBenar ? 'benar' : (isKosong ? 'kosong' : 'salah');
            let badgeText = isBenar ? '<i class="fas fa-check"></i> BENAR' : (isKosong ? '<i class="fas fa-minus"></i> KOSONG' : '<i class="fas fa-times"></i> SALAH');
            let ansValClass = isBenar ? 'benar' : (isKosong ? 'kosong' : 'salah');

            let kunciTampil = '';
            if (!isBenar) {
                if (isLastAttempt) {
                    kunciTampil = `
                    <div class="review-key-box show-key">
                        <div class="review-key-icon"><i class="fas fa-key"></i></div>
                        <div>Kunci Jawaban: <strong style="font-size: 16px;">${kunciAsli}</strong></div>
                    </div>`;
                } else {
                    kunciTampil = `
                    <div class="review-key-box hidden-key">
                        <div class="review-key-icon"><i class="fas fa-lock"></i></div>
                        <div>Kunci jawaban disembunyikan hingga percobaan terakhir.</div>
                    </div>`;
                }
            }
            
            htmlReview += `
                <div class="review-card">
                    <div class="review-header ${headerClass}">
                        <h4 class="review-q"><span style="color: var(--primary); margin-right: 6px;">${index + 1}.</span> ${soal.pertanyaan}</h4>
                        <div class="review-badge ${badgeClass}">${badgeText}</div>
                    </div>
                    <div class="review-body">
                        <div class="review-ans-box">
                            <div class="review-ans-label">Jawaban Kamu:</div>
                            <div class="review-ans-val ${ansValClass}">${!isKosong ? jawab : 'Tidak ada rekaman / Tidak dijawab'}</div>
                        </div>
                        ${kunciTampil}
                    </div>
                </div>
            `;
        });
        htmlReview += `</div></div>`;
        document.getElementById("reviewContainer").innerHTML = htmlReview;
    }

    function panggilAlertCustom(opsi) {
        const overlay = document.getElementById('customAlertOverlay');
        const iconContainer = document.getElementById('alertIcon');
        const titleContainer = document.getElementById('alertTitle');
        const messageContainer = document.getElementById('alertMessage');
        const actionsContainer = document.getElementById('alertActions');

        titleContainer.innerText = opsi.judul || 'Pemberitahuan';
        messageContainer.innerText = opsi.pesan || '';
        iconContainer.className = 'alert-icon ' + (opsi.tipe || 'warning');
        
        if (opsi.tipe === 'success') iconContainer.innerHTML = '<i class="fas fa-check-circle"></i>';
        else if (opsi.tipe === 'danger') iconContainer.innerHTML = '<i class="fas fa-times-circle"></i>';
        else iconContainer.innerHTML = '<i class="fas fa-exclamation-circle"></i>';

        actionsContainer.innerHTML = '';
        if (opsi.isKonfirmasi) {
            const btnBatal = document.createElement('button');
            btnBatal.className = 'btn-alert btn-alert-secondary';
            btnBatal.innerHTML = opsi.teksBatal || 'Batal';
            btnBatal.onclick = () => { overlay.classList.remove('show'); if (opsi.onBatal) opsi.onBatal(); };

            const btnKonfirm = document.createElement('button');
            btnKonfirm.className = 'btn-alert ' + (opsi.tipe === 'danger' ? 'btn-alert-danger' : 'btn-alert-primary');
            btnKonfirm.innerHTML = opsi.teksKonfirm || 'Oke';
            btnKonfirm.onclick = () => { overlay.classList.remove('show'); if (opsi.onKonfirm) opsi.onKonfirm(); };

            actionsContainer.appendChild(btnBatal);
            actionsContainer.appendChild(btnKonfirm);
        } else {
            const btnOke = document.createElement('button');
            btnOke.className = 'btn-alert btn-alert-primary';
            btnOke.innerHTML = opsi.teksKonfirm || 'Oke, Mengerti';
            btnOke.onclick = () => { overlay.classList.remove('show'); if (opsi.onKonfirm) opsi.onKonfirm(); };
            actionsContainer.appendChild(btnOke);
        }

        overlay.classList.add('show');
    }

    async function masukFullscreen() {
        document.body.classList.add("mode-evaluasi");
        let elem = document.documentElement; 
        if (elem.requestFullscreen) { await elem.requestFullscreen(); }
        else if (elem.webkitRequestFullscreen) { await elem.webkitRequestFullscreen(); }
    }

    function keluarFullscreen() {
        document.body.classList.remove("mode-evaluasi");
        if (document.fullscreenElement) { document.exitFullscreen(); }
    }

    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener('webkitfullscreenchange', exitHandler);
    
    function exitHandler() {
        if (!document.fullscreenElement && !document.webkitIsFullScreen) {
            if(kuisAktif) {
                document.getElementById('pelanggaranOverlay').classList.add('show');
            }
        }
    }

    async function kembaliKeFullscreen() {
        await masukFullscreen();
        document.getElementById('pelanggaranOverlay').classList.remove('show');
    }

    async function mulaiKuis() {
        if(dataSoal.length === 0) {
            panggilAlertCustom({ judul: "Opps! Soal Kosong", pesan: "Guru belum menginput soal untuk Kuis 2 ini.", tipe: "danger" });
            return;
        }

        let percobaanKe = parseInt(localStorage.getItem(keyPercobaan));
        if (percobaanKe >= MAX_PERCOBAAN) {
            panggilAlertCustom({ judul: "Batas Percobaan Habis", pesan: "Kamu telah menggunakan semua kesempatan kuis Kamu (3/3).", tipe: "danger" });
            return;
        }

        document.getElementById('petunjukBox').style.display = 'none';
        document.getElementById('areaSoal').style.display = 'block';
        document.getElementById('hasilBox').style.display = 'none';
        
        try { 
            await masukFullscreen(); 
        } catch (e) { 
            alert("Sistem membutuhkan izin Layar Penuh. Silakan gunakan browser terbaru.");
        }

        currentSoalIndex = 0;
        jawabanSiswa = {}; 
        soalSulit = new Array(dataSoal.length).fill(false);
        waktu = waktuDefault;

        kuisAktif = true;
        buatNomorGrid();
        tampilSoal(0);
        mulaiTimer();
    }

    function cobaLagiKuis() {
        let percobaanKe = parseInt(localStorage.getItem(keyPercobaan));
        if (percobaanKe >= MAX_PERCOBAAN) {
            panggilAlertCustom({ judul: "Akses Ditolak", pesan: "Kesempatan Kamu telah habis.", tipe: "danger" });
            return;
        }
        
        // Memunculkan kotak Petunjuk untuk inisiasi Fullscreen
        document.getElementById('hasilBox').style.display = 'none';
        document.getElementById('petunjukBox').style.display = 'block';
    }

    function mulaiTimer() {
        if(timerInterval) clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            if(waktu <= 0) {
                clearInterval(timerInterval);
                eksekusiSelesaiKuis();
            } else {
                waktu--;
                let m = Math.floor(waktu/60);
                let s = waktu%60;
                document.getElementById("timerText").innerText = `${m < 10 ? '0'+m : m}:${s < 10 ? '0'+s : s}`;
                if(waktu <= 180) { document.getElementById('timerBox').classList.add('warning-time'); }
            }
        }, 1000);
    }

    function buatNomorGrid() {
        const grid = document.getElementById("nomorGrid");
        grid.innerHTML = "";
        for(let i = 0; i < dataSoal.length; i++) {
            const btn = document.createElement("button");
            btn.id = "nomor-" + i;
            btn.innerText = i + 1;
            btn.className = "nomor-btn";
            btn.onclick = () => tampilSoal(i);
            grid.appendChild(btn);
        }
        updateNomorGridStatus();
    }

    function updateNomorGridStatus() {
        for(let i = 0; i < dataSoal.length; i++) {
            const btn = document.getElementById("nomor-" + i);
            if(!btn) continue;
            
            let isDijawab = (jawabanSiswa[i] !== undefined && jawabanSiswa[i] !== null && jawabanSiswa[i].toString().trim() !== "");

            if(soalSulit[i]) btn.className = "nomor-btn sulit";
            else if(isDijawab) btn.className = "nomor-btn sudah";
            else btn.className = "nomor-btn";
            
            if(i === currentSoalIndex) btn.classList.add("current");
        }
    }

    function tampilSoal(index) {
        currentSoalIndex = index;
        const soal = dataSoal[index];

        document.getElementById("soalNomor").innerHTML = `Soal ${index + 1} dari ${dataSoal.length}`;
        document.getElementById("soalText").innerText = soal.pertanyaan;

        const areaJawaban = document.getElementById("areaJawaban");
        areaJawaban.innerHTML = "";

        let isPilihanGanda = (soal.a || soal.b || soal.c || soal.d);

        if (isPilihanGanda) {
            const opsi = [
                { label: 'A', text: soal.a }, { label: 'B', text: soal.b }, 
                { label: 'C', text: soal.c }, { label: 'D', text: soal.d }
            ];

            opsi.forEach((item) => {
                if(item.text) {
                    const btn = document.createElement("button");
                    let isDipilih = jawabanSiswa[index] === item.label;
                    btn.className = `pilihan-btn-custom ${isDipilih ? 'aktif' : ''}`;
                    let mark = isDipilih ? "<i class='fas fa-check-circle text-lg'></i> " : `<strong style='width:28px; height:28px; border-radius:50%; border:2px solid ${isDipilih ? 'var(--primary)' : '#cbd5e1'}; display:flex; align-items:center; justify-content:center; font-size:12px;'>${item.label}</strong>`;
                    btn.innerHTML = `${mark} <span style="margin-left: 12px;">${item.text}</span>`;
                    
                    btn.onclick = () => {
                        jawabanSiswa[index] = item.label; 
                        updateNomorGridStatus();
                        tampilSoal(index); 
                    };
                    areaJawaban.appendChild(btn);
                }
            });
        } else {
            const inputContainer = document.createElement("div");
            inputContainer.className = "isian-container";
            inputContainer.innerHTML = `
                <p style="font-size: var(--fs-body-m); color: var(--slate-600); margin-bottom: 12px;"><i class="fas fa-keyboard" style="margin-right:4px;"></i> Ketik jawaban singkat Kamu di bawah ini:</p>
                <textarea id="inputIsian" class="isian-input" rows="4" placeholder="Tulis jawaban di sini...">${jawabanSiswa[index] || ''}</textarea>
            `;
            areaJawaban.appendChild(inputContainer);

            const inputIsian = document.getElementById('inputIsian');
            inputIsian.addEventListener('input', function(e) {
                jawabanSiswa[index] = e.target.value;
                updateNomorGridStatus();
            });
        }

        document.getElementById("btnPrev").style.visibility = index === 0 ? "hidden" : "visible";
        const isLast = index === dataSoal.length - 1;
        document.getElementById("btnNext").style.display = isLast ? "none" : "flex";
        document.getElementById("btnFinish").style.display = isLast ? "flex" : "none";

        updateTombolSulitUI();
        updateNomorGridStatus();
    }

    function nextSoal() { if(currentSoalIndex < dataSoal.length - 1) tampilSoal(currentSoalIndex + 1); }
    function prevSoal() { if(currentSoalIndex > 0) tampilSoal(currentSoalIndex - 1); }

    function toggleSulit() {
        soalSulit[currentSoalIndex] = !soalSulit[currentSoalIndex];
        updateNomorGridStatus();
        updateTombolSulitUI();
    }

    function updateTombolSulitUI() {
        const btn = document.getElementById("btnSulit");
        if(soalSulit[currentSoalIndex]) {
            btn.innerHTML = "<i class='fas fa-star'></i> Batal Tandai";
            btn.style.background = "#fffbeb";
            btn.style.borderColor = "#f59e0b";
            btn.style.color = "#d97706";
        } else {
            btn.innerHTML = "<i class='far fa-star'></i> Tandai Ragu";
            btn.style.background = "transparent";
            btn.style.borderColor = "var(--border)";
            btn.style.color = "var(--slate-600)";
        }
    }

    function selesaiKuis() {
        let terjawab = 0;
        for(let i = 0; i < dataSoal.length; i++) {
            if(jawabanSiswa[i] !== undefined && jawabanSiswa[i] !== null && jawabanSiswa[i].toString().trim() !== "") {
                terjawab++;
            }
        }

        if (terjawab < dataSoal.length) {
            panggilAlertCustom({
                judul: "Belum Selesai!",
                pesan: `Kamu baru menjawab ${terjawab} dari ${dataSoal.length} soal. Yakin ingin mengumpulkan sekarang?`,
                tipe: "danger", isKonfirmasi: true, teksKonfirm: "Ya, Kumpulkan", teksBatal: "Cek Kembali",
                onKonfirm: () => eksekusiSelesaiKuis()
            });
            return;
        }

        panggilAlertCustom({
            judul: "Kumpulkan Jawaban?",
            pesan: "Pastikan semua jawaban sudah benar. Setelah dikumpul, sistem akan me-review jawaban Kamu.",
            tipe: "success", isKonfirmasi: true, teksKonfirm: "Kirim & Review", teksBatal: "Batal",
            onKonfirm: () => eksekusiSelesaiKuis()
        });
    }

    async function eksekusiSelesaiKuis() {
        clearInterval(timerInterval);
        kuisAktif = false;
        keluarFullscreen();

        let percobaanKe = parseInt(localStorage.getItem(keyPercobaan)) + 1;
        localStorage.setItem(keyPercobaan, percobaanKe.toString());

        // SIMPAN JAWABAN KE LOCAL STORAGE AGAR BISA DIREVIEW DI HARI LAIN
        localStorage.setItem(keyJawaban, JSON.stringify(jawabanSiswa));

        document.getElementById("areaSoal").innerHTML = "<div style='text-align:center; padding: 100px 20px;'><i class='fas fa-spinner fa-spin' style='font-size:50px; color:#16a34a;'></i><h3 style='margin-top:20px; font-size:20px; color:#1e293b;'>Menganalisis Jawaban Kamu...</h3></div>";

        let benar = 0;
        let isLastAttempt = (percobaanKe >= MAX_PERCOBAAN);

        dataSoal.forEach((soal, index) => {
            let isPilihanGanda = (soal.a || soal.b || soal.c || soal.d);
            let jawab = jawabanSiswa[index];
            let isBenar = false;
            let kunciAsli = soal.kunci.toString().trim();

            if (jawab !== undefined && jawab !== null) {
                if (isPilihanGanda) {
                    if (jawab.toString() === kunciAsli) isBenar = true;
                } else {
                    let inputSiswa = jawab.toString().toLowerCase().trim();
                    if (inputSiswa === kunciAsli.toLowerCase()) isBenar = true;
                }
            }
            if (isBenar) benar++;
        });

        let skorAkhir = Math.round((benar / dataSoal.length) * 100);

        // Nilai tertinggi adalah perbandingan nilai database sebelumnya dengan nilai saat ini
        nilaiDiDB = Math.max(skorAkhir, nilaiDiDB);

        try {
            // ---- BAGIAN INI YANG DIPERBAIKI (Penambahan Header Accept dan Cek Error) ----
            let response = await fetch("{{ route('kuis2.simpan') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // SANGAT PENTING untuk Laravel!
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ skor: skorAkhir })
            });

            if (!response.ok) {
                throw new Error(`Gagal (Status: ${response.status})`);
            }
            // ----------------------------------------------------------------------------

            document.getElementById("areaSoal").style.display = "none";
            document.getElementById("hasilBox").style.display = "block";
            
            setupTampilanHasilAkhir(nilaiDiDB, percobaanKe);
            generateHtmlReview(jawabanSiswa, isLastAttempt);

        } catch (error) {
            console.error("Error Simpan:", error);
            panggilAlertCustom({
                judul: "Gagal Simpan", 
                pesan: "Gagal menyimpan nilai ke database. Cek internet kamu. Detail: " + error.message, 
                tipe: "danger"
            });
        }
    }

    function setupTampilanHasilAkhir(skor, percobaanKe) {
        document.getElementById("skorText").innerText = skor;
        
        let pesan = document.getElementById("pesanMotivasi");
        let icon = document.getElementById("hasilIcon");
        let info = document.getElementById("infoPercobaanTeks");
        
        if (skor === 100) {
            pesan.innerHTML = "🌟 <strong>Luar Biasa! Sempurna!</strong><br>Kamu sangat menguasai materi ini. Pertahankan prestasimu yang gemilang!";
            icon.innerHTML = '<i class="fas fa-trophy" style="color: #facc15; text-shadow: 0 4px 10px rgba(250,204,21,0.4);"></i>';
        } else if (skor >= 70) {
            pesan.innerHTML = "👍 <strong>Kerja Bagus!</strong><br>Kamu sudah memahami sebagian besar materi. Sedikit lagi menuju nilai sempurna!";
            icon.innerHTML = '<i class="fas fa-medal" style="color: var(--primary); text-shadow: 0 4px 10px rgba(22,163,74,0.4);"></i>';
        } else {
            pesan.innerHTML = "💪 <strong>Jangan Menyerah!</strong><br>Setiap kegagalan adalah langkah menuju kesuksesan. Yuk, baca kembali materinya dan coba lagi dengan lebih baik.";
            icon.innerHTML = '<i class="fas fa-book-reader" style="color: #3b82f6; text-shadow: 0 4px 10px rgba(59,130,246,0.4);"></i>';
        }

        const btnCobaLagi = document.getElementById("btnCobaLagi");
        const sisa = MAX_PERCOBAAN - percobaanKe;

        info.innerText = `Kamu telah menggunakan ${percobaanKe} dari 3 kesempatan.`;

        if (sisa > 0) {
            btnCobaLagi.style.display = "inline-flex";
            document.getElementById("sisaPercobaan").innerText = sisa + "x Lagi";
        } else {
            btnCobaLagi.style.display = "none";
            pesan.innerHTML += "<br><br><span style='display:inline-block; margin-top:12px; padding:8px 16px; background:#ffe4e6; color:#e11d48; border-radius:10px; font-size:13px; font-weight:bold; border:1px solid #fecdd3;'><i class='fas fa-lock' style='margin-right:6px;'></i> Kesempatan Kamu untuk mengulang kuis ini sudah habis.</span>";
        }
    }

    window.onbeforeunload = (e) => { 
        if(kuisAktif) return "Kuis sedang berlangsung! Jawaban Kamu mungkin tidak tersimpan jika Kamu keluar sekarang."; 
    };
</script>
@endsection