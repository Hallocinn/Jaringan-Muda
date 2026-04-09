@extends('layouts.app')

@section('content')
<div class="evaluasi-container">

    <h2>Evaluasi Akhir</h2>

    <!-- PETUNJUK -->
    <div class="petunjuk-box" id="petunjukBox">
        <h3>Petunjuk Pengerjaan</h3>
        <ol>
            <li>Bacalah setiap soal dengan teliti.</li>
            <li>Pilih satu jawaban yang paling benar.</li>
            <li>Setiap soal bernilai 5 poin.</li>
            <li>Pastikan semua soal telah dijawab sebelum menekan tombol selesai.</li>
        </ol>

        <button onclick="mulaiEvaluasi()" class="btn-mulai">
            Mulai Evaluasi
        </button>
    </div>

    <!-- AREA SOAL (DISEMBUNYIKAN DULU) -->
    <div id="areaSoal" style="display:none;">

        <!-- Navigasi Nomor -->
        <div class="nomor-grid" id="nomorGrid"></div>

        <!-- Soal -->
        <div class="soal-box">
            <h3 id="soalNomor"></h3>
            <p id="soalText"></p>
            <div id="pilihanJawaban"></div>
        </div>

        <!-- Tombol Navigasi -->
        <div class="nav-btn">
            <button onclick="prevSoal()">Sebelumnya</button>
            <button onclick="nextSoal()">Selanjutnya</button>
            <button onclick="selesai()">Selesai</button>
        </div>

        <!-- Hasil -->
        <div class="hasil-box" id="hasilBox" style="display:none;">
            <h3>Hasil Evaluasi</h3>
            <p id="skorText"></p>
        </div>

    </div>

</div>

<script>

const soalData = [
    { soal: "Jaringan yang menyebabkan pertumbuhan panjang adalah...", pilihan: ["Epidermis","Meristem Apikal","Parenkim","Xilem"], jawaban: 1 },
    { soal: "Pertumbuhan sekunder disebabkan oleh...", pilihan: ["Kambium","Meristem apikal","Daun","Akar"], jawaban: 0 },
];

// Tambah sampai 20 soal dummy
while (soalData.length < 20) {
    soalData.push({
        soal: "Soal tambahan nomor " + (soalData.length+1),
        pilihan: ["A","B","C","D"],
        jawaban: 0
    });
}

let currentSoal = 0;
let jawabanUser = new Array(20).fill(null);

function mulaiEvaluasi() {
    document.getElementById("petunjukBox").style.display = "none";
    document.getElementById("areaSoal").style.display = "block";
    buatNomor();
    tampilSoal(0);
}

function buatNomor() {
    const nomorGrid = document.getElementById("nomorGrid");
    nomorGrid.innerHTML = "";

    for (let i = 0; i < 20; i++) {
        const btn = document.createElement("button");
        btn.innerText = i+1;
        btn.className = "nomor-btn belum";
        btn.onclick = () => tampilSoal(i);
        btn.id = "nomor"+i;
        nomorGrid.appendChild(btn);
    }
}

function tampilSoal(index) {
    currentSoal = index;

    document.getElementById("soalNomor").innerText = "Soal " + (index+1);
    document.getElementById("soalText").innerText = soalData[index].soal;

    const pilihanDiv = document.getElementById("pilihanJawaban");
    pilihanDiv.innerHTML = "";

    soalData[index].pilihan.forEach((p, i) => {
        const btn = document.createElement("button");
        btn.innerText = p;
        btn.className = "pilihan-btn";
        btn.onclick = () => pilihJawaban(i);
        pilihanDiv.appendChild(btn);
    });
}

function pilihJawaban(index) {
    jawabanUser[currentSoal] = index;
    document.getElementById("nomor"+currentSoal).className = "nomor-btn sudah";
}

function nextSoal() {
    if (currentSoal < 19) tampilSoal(currentSoal+1);
}

function prevSoal() {
    if (currentSoal > 0) tampilSoal(currentSoal-1);
}

function selesai() {

    let belum = jawabanUser.includes(null);
    if (belum) {
        alert("Masih ada soal yang belum dikerjakan!");
        return;
    }

    let skor = 0;
    jawabanUser.forEach((j,i) => {
        if (j === soalData[i].jawaban) skor++;
    });

    document.getElementById("hasilBox").style.display = "block";
    document.getElementById("skorText").innerText =
        "Skor Anda: " + (skor*5) + " / 100";
}

</script>

@endsection