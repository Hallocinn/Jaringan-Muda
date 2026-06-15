@extends('layouts.guru')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .stat-card, .chart-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #bbf7d0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .stat-icon {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #16a34a;
    }

    .hero-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 10px;
        padding: 20px 30px;
        border: 1px solid #bbf7d0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .hero-content h2 {
        font-size: 32px;
        font-weight: 700;
        color: #14532d;
        margin-bottom: 4px;
    }

    .hero-content .highlight {
        color: #15803d;
    }

    .hero-subtitle {
        color: #64748b;
        font-size: 14px;
        line-height: 1.4;
        max-width: 650px;
    }
</style>

<div class="max-w-7xl mx-auto">

    <div class="hero-section">
        <div class="hero-content">
            <h2>
                Selamat Datang,
                <span class="highlight">{{ Auth::user()->name ?? 'Bapak/Ibu Guru' }}</span>! 👋
            </h2>
            <p class="hero-subtitle">
                Selamat beraktivitas di Halaman Guru. Kelola pembelajaran, pantau perkembangan siswa, dan akses informasi penting dalam satu tempat.
            </p>
        </div>
    </div>

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Ringkasan Sistem</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="stat-card p-6 flex items-center gap-5">
            <div class="stat-icon w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-3xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalSiswa }}</h3>
                <p class="text-gray-500 font-medium text-sm mt-0.5">Total Akun Siswa</p>
            </div>
        </div>

        <div class="stat-card p-6 flex items-center gap-5">
            <div class="stat-icon w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-3xl">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalSoal }}</h3>
                <p class="text-gray-500 font-medium text-sm mt-0.5">Soal Kuis & Evaluasi</p>
            </div>
        </div>

        <div class="stat-card p-6 flex items-center gap-5">
            <div class="stat-icon w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-3xl">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $totalDiskusi }}</h3>
                <p class="text-gray-500 font-medium text-sm mt-0.5">Pesan di Ruang Diskusi</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="chart-card lg:col-span-2 p-6">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Rata-Rata Nilai Kelas</h3>
                    <p class="text-xs text-gray-500">Berdasarkan hasil kuis dan evaluasi seluruh siswa</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <div class="chart-card lg:col-span-1 p-6">
            <div class="mb-4">
                <h3 class="font-bold text-gray-800 text-lg">Ketuntasan Evaluasi</h3>
                <p class="text-xs text-gray-500">KKM Minimum: 75</p>
            </div>

            <div class="relative h-64 w-full flex items-center justify-center">
                @if($lulus == 0 && $remedial == 0)
                    <div class="text-center text-gray-400">
                        <i class="fa-solid fa-chart-pie text-4xl mb-2 opacity-50"></i>
                        <p class="text-sm">Belum ada data evaluasi</p>
                    </div>
                @else
                    <canvas id="pieChart"></canvas>
                @endif
            </div>

            @if($lulus > 0 || $remedial > 0)
                <div class="mt-4 flex justify-center gap-4 text-sm font-semibold">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        Tuntas ({{ $lulus }})
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        Belum Tuntas ({{ $remedial }})
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxBar = document.getElementById('barChart').getContext('2d');

        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Kuis 1 (Meristem)', 'Kuis 2 (Dewasa)', 'Kuis 3 (Struktur)', 'Evaluasi Akhir'],
                datasets: [{
                    label: 'Rata-Rata Kelas',
                    data: [
                        {{ round($avgKuis1, 1) }},
                        {{ round($avgKuis2, 1) }},
                        {{ round($avgKuis3, 1) }},
                        {{ round($avgEvaluasi, 1) }}
                    ],
                    backgroundColor: [
                        'rgba(22, 163, 74, 0.8)',
                        'rgba(21, 128, 61, 0.8)',
                        'rgba(20, 83, 45, 0.8)',
                        'rgba(245, 158, 11, 0.8)'
                    ],
                    borderColor: [
                        'rgb(22, 163, 74)',
                        'rgb(21, 128, 61)',
                        'rgb(20, 83, 45)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: 'Poppins', size: 13 },
                        bodyFont: { family: 'Poppins', size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { borderDash: [4, 4], color: '#f1f5f9' },
                        ticks: { font: { family: 'Poppins' }, color: '#64748b' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Poppins', size: 12 }, color: '#64748b' }
                    }
                }
            }
        });

        @if($lulus > 0 || $remedial > 0)
        const ctxPie = document.getElementById('pieChart').getContext('2d');

        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Tuntas (Lulus)', 'Remedial (Belum Tuntas)'],
                datasets: [{
                    data: [{{ $lulus }}, {{ $remedial }}],
                    backgroundColor: ['#16a34a', '#f43f5e'],
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: 'Poppins', size: 13 },
                        bodyFont: { family: 'Poppins', size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection