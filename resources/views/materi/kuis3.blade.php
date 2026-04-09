@extends('layouts.app')

@section('content')
<div class="materi-container">
    <h2><i class="fa-solid fa-puzzle-piece"></i> Teka-Teki Silang: Materi 3</h2>
    <p>Isilah kotak-kotak di bawah ini berdasarkan petunjuk tentang Jaringan Meristem!</p>

    <div class="tts-wrapper" style="display: flex; gap: 30px; margin-top: 20px; flex-wrap: wrap;">
        
        <div id="tts-grid" style="display: grid; grid-template-columns: repeat(10, 35px); grid-template-rows: repeat(10, 35px); gap: 2px; background: #14532d; padding: 5px; border-radius: 8px;">
            @for ($row = 1; $row <= 10; $row++)
                @for ($col = 1; $col <= 10; $col++)
                    <div class="cell" id="cell-{{$row}}-{{$col}}" style="width: 35px; height: 35px; background: #0f3d23; display: flex; align-items: center; justify-content: center; position: relative;">
                    </div>
                @endfor
            @endfor
        </div>

        <div class="hints" style="flex: 1; min-width: 300px;">
            <div class="card" style="margin-bottom: 15px;">
                <h4 style="color: #16a34a;">Mendatar</h4>
                <ul style="list-style: none; padding: 0; font-size: 14px;">
                    <li><strong>1.</strong> Jaringan yang sel-selnya aktif membelah (8 Huruf)</li>
                </ul>
            </div>
            <div class="card">
                <h4 style="color: #16a34a;">Menurun</h4>
                <ul style="list-style: none; padding: 0; font-size: 14px;">
                    <li><strong>2.</strong> Meristem yang terletak di ujung (6 Huruf)</li>
                </ul>
            </div>

            <button onclick="checkTTS()" class="btn-belajar" style="width: 100%; margin-top: 20px; cursor: pointer;">
                <i class="fa-solid fa-check-double"></i> Periksa Jawaban
            </button>
        </div>
    </div>
</div>

<script>
    const config = [
        {r:3, c:2, a:'M', n:1}, {r:3, c:3, a:'E'}, {r:3, c:4, a:'R'}, {r:3, c:5, a:'I'}, 
        {r:3, c:6, a:'S'}, {r:3, c:7, a:'T'}, {r:3, c:8, a:'E'}, {r:3, c:9, a:'M'},
        {r:4, c:2, a:'P'}, {r:5, c:2, a:'I'}, {r:6, c:2, a:'K'}, {r:7, c:2, a:'A'}, {r:8, c:2, a:'L', n:2}
    ];

    config.forEach(item => {
        const cell = document.getElementById(`cell-${item.r}-${item.c}`);
        if (cell) {
            cell.innerHTML = `<input type="text" maxlength="1" data-ans="${item.a}" class="tts-input">`;
            if(item.n) {
                cell.innerHTML += `<span>${item.n}</span>`;
            }
        }
    });

    function checkTTS() {
        let inputs = document.querySelectorAll('.tts-input');
        let correct = 0;
        
        inputs.forEach(input => {
            if(input.value.toUpperCase() === input.getAttribute('data-ans')) {
                input.style.background = "#dcfce7";
                correct++;
            } else {
                input.style.background = "#fee2e2";
            }
        });

        if(correct === inputs.length && correct > 0) {
            alert("Selamat! Kamu telah menyelesaikan seluruh materi dan kuis.");
            // Arahkan ke Evaluasi karena ini materi terakhir
            window.location.href = "{{ route('evaluasi') }}";
        } else {
            alert("Jawaban belum lengkap atau masih ada yang salah!");
        }
    }
</script>

<style>
    .tts-input {
        width: 100%;
        height: 100%;
        background: #fff;
        border: none;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 18px;
        border-radius: 4px;
    }
    .cell span {
        position: absolute;
        top: 2px;
        left: 2px;
        font-size: 9px;
        color: #14532d;
        font-weight: bold;
    }
</style>
@endsection