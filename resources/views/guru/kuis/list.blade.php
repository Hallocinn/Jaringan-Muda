@extends('layouts.guru')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<div style="font-family:'Poppins'; max-width:1100px; margin:auto;">

    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <h2>Daftar Kuis</h2>
        <a href="#" style="background:#3b82f6; color:white; padding:10px 15px; border-radius:8px;">+ Tambah Kuis</a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:15px;">
        
        @foreach($kuis as $k)
        <div style="background:white; padding:15px; border-radius:12px; border:1px solid #e2e8f0;">
            <h4 style="margin-bottom:10px;">{{ $k->nama_kuis }}</h4>

            <a href="{{ route('guru.kuis.index', ['kuis_id' => $k->id]) }}"
               style="display:block; text-align:center; background:#22c55e; color:white; padding:8px; border-radius:6px;">
                Kelola Soal
            </a>
        </div>
        @endforeach

    </div>
</div>
@endsection