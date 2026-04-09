@extends('layouts.app')

@section('content')
<div class="materi-container">

    <h2>PERKEMBANGAN JARINGAN MUDA </h2>

    <div class="model-3d-container">
        <div id="model3d" style="background: #eee; height: 350px; display: flex; align-items: center; justify-content: center; border-radius: 12px; border: 2px dashed #ccc;">
            <p>Area Model 3D (Letakkan Canvas / iframe Three.js di sini)</p>
        </div>
        <button id="fullscreenBtn" class="btn-3d" style="margin-top: 10px;">🔍 Fullscreen</button>
    </div>

    <div class="saintifik-tabs" style="margin-top: 20px; display: flex; gap: 5px;">
        <button class="tab-btn active" onclick="showStep(1, this)">Mengamati</button>
        <button class="tab-btn" onclick="showStep(2, this)">Menanya</button>
        <button class="tab-btn" onclick="showStep(3, this)">Mencoba</button>
        <button class="tab-btn" onclick="showStep(4, this)">Menalar</button>
        <button class="tab-btn" onclick="showStep(5, this)">Mengkomunikasikan</button>
    </div>

    <div class="saintifik-content" style="margin-top: 20px;">
        <div class="step" id="step1" style="display: block;">
            <div class="card">
                <h3><i class="fa-solid fa-eye"></i> Mengamati</h3>
                <p>Amati model 3D jaringan meristem pada ujung akar dan batang. Perhatikan bentuk sel dan kepadatannya.</p>
            </div>
        </div>

        <div class="step" id="step2" style="display: none;">
            <div class="card">
                <h3><i class="fa-solid fa-comments"></i> Menanya (Forum Diskusi)</h3>
                <p>Ajukan minimal satu pertanyaan berdasarkan hasil pengamatan visualisasi 3D Anda.</p>
                
                <div class="soal-box" style="margin-top: 15px; background: #f9f9f9; padding: 15px; border-radius: 10px;">
                    <textarea id="questionInput" class="forum-input" placeholder="Tulis pertanyaan ilmiahmu di sini..." rows="3" style="width: 100%; padding: 10px; border-radius: 8px; border: 2px solid #dcfce7;"></textarea>
                    <button type="button" class="btn-belajar" style="margin-top: 10px; width: 100%; cursor: pointer;" onclick="submitQuestion()">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pertanyaan
                    </button>
                </div>

                <div id="forumFeed" style="margin-top: 25px;">
                    <p style="font-size: 14px; color: #666; font-weight: bold;">Pertanyaan Terkini:</p>
                    <div class="card" style="margin-bottom: 15px; border-left: 4px solid #16a34a; background: #fff;">
                        <small><strong>Siswa A</strong> • 2 menit yang lalu</small>
                        <p style="margin: 5px 0;">Mengapa sel meristem selalu aktif membelah sedangkan jaringan lain tidak?</p>
                        <button class="reaction-btn" onclick="toggleReaction(this)">
                            <i class="fa-regular fa-lightbulb"></i> <span class="count">5</span> Menarik
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="step" id="step3" style="display: none;"><div class="card"><h3>Mencoba</h3><p>Gunakan mouse Anda untuk memutar model 3D...</p></div></div>
        <div class="step" id="step4" style="display: none;"><div class="card"><h3>Menalar</h3><p>Analisislah hubungan antara struktur sel...</p></div></div>
        <div class="step" id="step5" style="display: none;"><div class="card"><h3>Mengkomunikasikan</h3><p>Tuliskan kesimpulan pengamatan Anda...</p></div></div>
    </div>

    <div class="kuis-section" style="margin-top: 40px; text-align: center;">
        <button id="kuisBtn" disabled 
            onclick="window.location.href='{{ route('kuis3') }}'" 
            class="btn-kuis"
            style="padding: 15px 30px; border-radius: 10px; opacity: 0.6; cursor: not-allowed;">
            🔒 Selesaikan 5 Tahap untuk Kuis
        </button>
    </div>

</div>

<script>
    // Variabel global untuk tracking progress
    let completedSteps = new Set();
    completedSteps.add(1); 

    function showStep(step, btn) {
        // 1. Sembunyikan semua step
        const allSteps = document.querySelectorAll('.step');
        allSteps.forEach(el => el.style.display = 'none');

        // 2. Tampilkan yang dipilih
        const targetStep = document.getElementById('step' + step);
        if(targetStep) targetStep.style.display = 'block';

        // 3. Update warna tombol tab
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');

        // 4. Catat progress
        completedSteps.add(step);

        // 5. Unlock Kuis jika sudah 5 tahap
        if (completedSteps.size === 5) {
            const kuisBtn = document.getElementById('kuisBtn');
            kuisBtn.disabled = false;
            kuisBtn.style.opacity = "1";
            kuisBtn.style.cursor = "pointer";
            kuisBtn.style.background = "#16a34a";
            kuisBtn.style.color = "#fff";
            kuisBtn.innerHTML = "✅ Buka Kuis Materi 3";
        }
    }

    function submitQuestion() {
        const input = document.getElementById('questionInput');
        if(input.value.trim() === "") return alert("Tulis pertanyaan dulu!");

        const feed = document.getElementById('forumFeed');
        const newPost = document.createElement('div');
        newPost.className = 'card';
        newPost.style = "margin-bottom: 15px; border-left: 4px solid #16a34a; background: #fff; animation: fadeIn 0.5s;";
        newPost.innerHTML = `
            <small><strong>Kamu</strong> • Baru saja</small>
            <p style="margin: 5px 0;">${input.value}</p>
            <button class="reaction-btn" onclick="toggleReaction(this)">
                <i class="fa-regular fa-lightbulb"></i> <span class="count">0</span> Menarik
            </button>
        `;
        feed.prepend(newPost);
        input.value = "";
    }

    window.toggleReaction = function(btn) {
        const icon = btn.querySelector('i');
        const countSpan = btn.querySelector('.count');
        let count = parseInt(countSpan.innerText);

        btn.classList.toggle('active');

        if (btn.classList.contains('active')) {
            countSpan.innerText = count + 1;
            icon.classList.replace('fa-regular', 'fa-solid');
        } else {
            countSpan.innerText = count - 1;
            icon.classList.replace('fa-solid', 'fa-regular');
        }
    }

    // Fullscreen logic
    const model3d = document.getElementById("model3d");
    const fullscreenBtn = document.getElementById("fullscreenBtn");

    fullscreenBtn.onclick = function() {
        if (model3d.requestFullscreen) model3d.requestFullscreen();
        else if (model3d.webkitRequestFullscreen) model3d.webkitRequestFullscreen();
    }
</script>

<style>
    .tab-btn {
        padding: 10px 15px;
        border: none;
        background: #e2e8f0;
        cursor: pointer;
        border-radius: 8px 8px 0 0;
        transition: 0.3s;
    }
    .tab-btn.active {
        background: #14532d !important;
        color: white !important;
    }
    .reaction-btn {
        background: #f0fdf4;
        border: 1px solid #16a34a;
        color: #16a34a;
        padding: 4px 10px;
        border-radius: 20px;
        cursor: pointer;
    }
    .reaction-btn.active {
        background: #16a34a;
        color: white;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection