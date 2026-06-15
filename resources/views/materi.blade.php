@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran | BELAJAR.ID</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* === Variabel CSS Sama Seperti Sebelumnya === */
        :root {
            --fs-h1: 32px; --fs-h2: 24px; --fs-h3: 18px; --fs-h4: 16px;
            --fs-body-l: 16px; --fs-body-m: 14px; --fs-body-s: 13px;
            --fs-button: 14px; --fs-button-small: 13px; --fs-badge: 12px;
            
            --fw-regular: 400; --fw-medium: 500; --fw-semibold: 600; --fw-bold: 700; --fw-extrabold: 800;
            
            --primary: #16a34a; --primary-dark: #15803d; --primary-light: #4ade80;
            --secondary: #14532d; --dark: #1e293b; --gray: #64748b;
            --light-gray: #f8fafc; --border: #e2e8f0; --border-light: #bbf7d0; --white: #ffffff;
            
            --spacing-xs: 4px; --spacing-sm: 8px; --spacing-md: 12px;
            --spacing-lg: 16px; --spacing-xl: 20px; --spacing-2xl: 24px; --spacing-3xl: 32px;
        }

        * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--light-gray); height: 100vh; overflow: hidden; }

        .materi-container {
            max-width: 1200px; margin: 0 auto; padding: var(--spacing-md) var(--spacing-2xl); 
            display: grid; grid-template-rows: auto auto 1fr auto; 
            height: calc(100vh - 70px); gap: var(--spacing-md);
        }

        .card-grid::-webkit-scrollbar { width: 6px; }
        .card-grid::-webkit-scrollbar-track { background: var(--border); border-radius: 10px; }
        .card-grid::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

        .hero-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 10px; padding: 20px 30px; border: 1px solid var(--border-light);
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;
        }
        .hero-content h2 { font-size: var(--fs-h1); font-weight: var(--fw-bold); color: var(--secondary); margin-bottom: var(--spacing-xs); }
        .hero-content .highlight { color: var(--primary); }
        .hero-subtitle { color: var(--gray); font-size: var(--fs-body-m); line-height: 1.4; }
        
        .btn-diskusi {
            background: var(--white); color: var(--primary-dark); border: 2px solid var(--primary);
            padding: 10px 20px; border-radius: 40px; font-weight: var(--fw-bold); font-size: var(--fs-button);
            text-decoration: none; display: flex; align-items: center; gap: 8px; transition: 0.3s;
        }
        .btn-diskusi:hover { background: var(--primary); color: var(--white); transform: translateY(-2px); }

        .progress-card {
            background: var(--white); border-radius: 10px; padding: 16px var(--spacing-2xl);
            border: 1px solid var(--border-light); font-weight: var(--fw-bold); color: var(--dark);
        }
        .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm); }
        .progress-title { display: flex; align-items: center; gap: 10px; font-weight: var(--fw-semibold); font-size: 15px; }
        .progress-title i { color: var(--primary); font-size: 18px; }
        .percentage { font-size: var(--fs-h2); font-weight: var(--fw-extrabold); color: var(--primary); }
        .progress-bar-wrapper { background: var(--border); height: 8px; border-radius: 10px; overflow: hidden; margin-bottom: var(--spacing-md); }
        .progress-bar-fill { background: linear-gradient(90deg, var(--primary), var(--primary-dark)); height: 100%; border-radius: 10px; transition: width 0.5s ease; }
        .progress-stats { display: flex; justify-content: space-between; gap: var(--spacing-xl); flex-wrap: wrap; }
        .stat-item { display: flex; align-items: center; gap: var(--spacing-sm); font-size: var(--fs-body-s); color: var(--gray); }
        .stat-item i { color: var(--primary); }

        .card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-lg); overflow-y: auto; padding-right: 4px; scrollbar-width: thin; }
        .materi-card { background: var(--white); border-radius: 10px; overflow: hidden; transition: 0.3s; border: 1px solid var(--border-light); display: flex; flex-direction: column; justify-content: space-between; }
        .materi-card:hover { transform: translateY(-3px); border-color: #86efac; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        
        .card-header { padding: var(--spacing-lg) var(--spacing-lg) 0 var(--spacing-lg); display: flex; justify-content: space-between; align-items: flex-start; }
        .badge-container { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
        .badge { padding: 4px 10px; border-radius: 6px; font-size: var(--fs-badge); font-weight: var(--fw-bold); text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-warning { background: #fef9c3; color: #a16207; }

        .card-body { padding: var(--spacing-md) var(--spacing-lg) var(--spacing-lg) var(--spacing-lg); display: flex; flex-direction: column; flex-grow: 1; }
        .card-body h3 { font-size: var(--fs-h3); font-weight: var(--fw-bold); color: var(--dark); margin-bottom: var(--spacing-xs); }
        .card-body p { font-size: var(--fs-body-s); color: var(--gray); line-height: 1.4; margin-bottom: var(--spacing-md); flex-grow: 1; }
        .btn-pelajari { display: inline-flex; align-items: center; gap: var(--spacing-sm); background: var(--primary); color: var(--white); text-decoration: none; font-weight: var(--fw-medium); font-size: var(--fs-button-small); padding: 8px var(--spacing-xl); border-radius: 10px; transition: 0.3s; width: 100%; justify-content: center; border: none; cursor: pointer; }
        .btn-pelajari:hover { gap: 10px; transform: translateY(-2px); background: var(--primary-dark); }

        .evaluation-banner { background: linear-gradient(135deg, var(--secondary) 0%, #064e3b 100%); border-radius: 10px; padding: 14px var(--spacing-3xl); position: relative; overflow: hidden; }
        .banner-content { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: var(--spacing-md); position: relative; z-index: 2; }
        .banner-icon { width: 44px; height: 44px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fbbf24; font-size: var(--fs-h3); }
        .banner-text h3 { color: var(--white); font-size: var(--fs-h3); font-weight: var(--fw-bold); margin-bottom: 2px; }
        .banner-text p { color: rgba(255, 255, 255, 0.8); font-size: var(--fs-body-s); }
        .btn-evaluasi { display: inline-flex; align-items: center; gap: var(--spacing-sm); background: var(--primary); color: var(--white); text-decoration: none; font-weight: var(--fw-medium); padding: 8px var(--spacing-xl); border-radius: 10px; transition: 0.3s; font-size: var(--fs-button-small); }
        .btn-evaluasi:hover { background: var(--primary-dark); transform: translateY(-2px); }
        .btn-locked { background: #64748b; color: #cbd5e1; cursor: not-allowed; pointer-events: none; }

        @media (max-width: 900px) { .card-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) {
            body { overflow-y: auto; height: auto; }
            .materi-container { height: auto; display: flex; flex-direction: column; }
            .card-grid { grid-template-columns: 1fr; overflow-y: visible; }
            .banner-content { flex-direction: column; text-align: center; }
            .btn-evaluasi { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>
    <div class="materi-container">
        
        {{-- Row 1: Hero Section + Tombol Diskusi --}}
        <div class="hero-section">
            <div class="hero-content">
                <h2>Pembelajaran <span class="highlight">Jaringan Meristem</span></h2>
                <p class="hero-subtitle">Selesaikan materi, kerjakan kuis, diskusikan bersama Guru dan Temanmu.</p>
            </div>
            <a href="{{ route('siswa.diskusi') }}" class="btn-diskusi">
                <i class="fas fa-comments"></i> Forum Diskusi Kelas
            </a>
        </div>

        {{-- Row 2: Progress Card Aktif --}}
        <div class="progress-card">
            <div class="progress-header">
                <div class="progress-title">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress Belajar</span>
                </div>
                <div class="percentage">{{ round($progressPercent) }}%</div>
            </div>
            <div class="progress-bar-wrapper">
                <div class="progress-bar-fill" style="width: {{ $progressPercent }}%;"></div>
            </div>
            <div class="progress-stats">
                <div class="stat-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $tahapSelesai }} dari {{ $totalTahap }} Tahap Selesai</span>
                </div>
                <div class="stat-item">
                    @if($isEligibleForEvaluasi)
                        <i class="fas fa-unlock text-green-500"></i>
                        <span style="color: var(--primary-dark); font-weight: bold;">Evaluasi Akhir Telah Terbuka!</span>
                    @else
                        <i class="fas fa-lock"></i>
                        <span>Selesaikan semua Materi & Kuis untuk membuka Evaluasi</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Row 3: Card Grid --}}
        <div class="card-grid">
            {{-- Materi 1 --}}
            <div class="materi-card">
                <div class="card-header">
                    <div></div>
                    <div class="badge-container">
                        <span class="badge badge-warning">Materi 1</span>
                        @if(in_array('materi1', $completedSteps)) <span class="badge badge-success"><i class="fas fa-check"></i> Selesai</span> @endif
                        @if(isset($nilais['kuis1'])) <span class="badge badge-primary">Nilai Kuis: {{ $nilais['kuis1'] }}</span> @endif
                    </div>
                </div>
                <div class="card-body">
                    <h3>Definisi Meristem</h3>
                    <p>Mengenal dasar dan karakteristik utama Jaringan Meristem pada tumbuhan.</p>
                    <a href="{{ route('materi1') }}" class="btn-pelajari">Mulai Belajar</a>
                </div>
            </div>

            {{-- Materi 2 --}}
            <div class="materi-card">
                <div class="card-header">
                    <div></div>
                    <div class="badge-container">
                        <span class="badge badge-warning">Materi 2</span>
                        @if(in_array('materi2', $completedSteps)) <span class="badge badge-success"><i class="fas fa-check"></i> Selesai</span> @endif
                        @if(isset($nilais['kuis2'])) <span class="badge badge-primary">Nilai Kuis: {{ $nilais['kuis2'] }}</span> @endif
                    </div>
                </div>
                <div class="card-body">
                    <h3>Struktur Meristem</h3>
                    <p>Pembagian jenis meristem berdasarkan posisi, asal-usul, dan fungsinya.</p>
                    <a href="{{ route('materi2') }}" class="btn-pelajari">Mulai Belajar</a>
                </div>
            </div>

            {{-- Materi 3 --}}
            <div class="materi-card">
                <div class="card-header">
                    <div></div>
                    <div class="badge-container">
                        <span class="badge badge-warning">Materi 3</span>
                        @if(in_array('materi3', $completedSteps)) <span class="badge badge-success"><i class="fas fa-check"></i> Selesai</span> @endif
                        @if(isset($nilais['kuis3'])) <span class="badge badge-primary">Nilai Kuis: {{ $nilais['kuis3'] }}</span> @endif
                    </div>
                </div>
                <div class="card-body">
                    <h3>Perkembangan Meristem</h3>
                    <p>Memahami peran vital jaringan muda dalam pertumbuhan dan perkembangan tumbuhan.</p>
                    <a href="{{ route('materi3') }}" class="btn-pelajari">Mulai Belajar</a>
                </div>
            </div>
        </div>

        {{-- Row 4: Evaluation Banner (Sistem Kunci Gembok Aktif) --}}
        <div class="evaluation-banner">
            <div class="banner-content">
                <div class="flex items-center gap-4">
                    <div class="banner-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="banner-text">
                        <h3>Evaluasi Akhir</h3>
                        @if(isset($nilais['evaluasi']))
                            <p class="text-green-300 font-bold">Telah Dikerjakan. Nilai Akhir Kamu: {{ $nilais['evaluasi'] }}</p>
                        @elseif($isEligibleForEvaluasi)
                            <p>Kamu sudah menyelesaikan semua tahap! Silakan kerjakan Evaluasi.</p>
                        @else
                            <p>Terkunci. Selesaikan materi dan kuis 1-3 terlebih dahulu.</p>
                        @endif
                    </div>
                </div>

                @if(isset($nilais['evaluasi']))
                    <button class="btn-evaluasi btn-locked" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="fas fa-check-circle"></i> Selesai
                    </button>
                @elseif($isEligibleForEvaluasi)
                    <a href="{{ route('evaluasi') }}" class="btn-evaluasi">
                        <i class="fas fa-pencil-alt"></i> Mulai Evaluasi
                    </a>
                @else
                    <button class="btn-evaluasi btn-locked">
                        <i class="fas fa-lock"></i> Terkunci
                    </button>
                @endif
            </div>
            <div class="banner-decoration"></div>
        </div>
    </div>
</body>
</html>
@endsection