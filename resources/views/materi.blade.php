@extends('layouts.app')

@section('content')
<div class="materi-container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h1>Pilihan Materi Jaringan Muda</h1>

    <div class="progress-section" style="margin-bottom: 30px; background: #f0f0f0; border-radius: 10px; padding: 15px;">
        <p style="margin-bottom: 5px;">Progress Belajar Kamu: <strong>65%</strong></p>
        <div class="progress-container" style="background: #ddd; border-radius: 20px; height: 20px; width: 100%;">
            <div class="progress-fill" style="background: #28a745; width: 65%; height: 100%; border-radius: 20px; transition: width 0.5s;"></div>
        </div>
    </div>

    <div class="card-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="card">
            <h3>Sub Bab 1</h3>
            <p>Pengertian dan Ciri Jaringan Meristem</p>
            <a href="{{ route('materi1') }}" class="btn-card">Pelajari</a>
        </div>

        <div class="card">
            <h3>Sub Bab 2</h3>
            <p>Klasifikasi Jaringan Meristem</p>
            <a href="{{ route('materi2') }}" class="btn-card">Pelajari</a>
        </div>

        <div class="card">
            <h3>Sub Bab 3</h3>
            <p>Fungsi dan Perkembangan Jaringan Muda</p>
            <a href="{{ route('materi3') }}" class="btn-card">Pelajari</a>
        </div>
    </div>

    <div class="evaluasi-section" style="margin-top: 40px; text-align: center; border-top: 2px solid #eee; padding-top: 20px;">
        <p>Sudah selesai mempelajari semua materi di atas?</p>
        <a href="{{ route('evaluasi') }}" class="btn-evaluasi" style="display: inline-block; background: #007bff; color: white; padding: 15px 40px; border-radius: 30px; text-decoration: none; font-weight: bold; font-size: 1.1em;">
            Mulai Evaluasi Akhir
        </a>
    </div>
</div>
@endsection