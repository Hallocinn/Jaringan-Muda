@extends('layouts.guru')

@section('title', 'Monitoring Pemahaman Siswa')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body, .poppins { font-family: 'Poppins', sans-serif; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .page-title { font-weight: 700; color: #1e293b; margin: 0; font-size: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .page-subtitle { color: #64748b; margin: 5px 0 0 0; font-size: 0.9rem; }

    .card-custom { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px; }
    .action-bar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); flex-wrap: wrap; gap: 15px; }
    .action-group-filter { display: flex; flex-wrap: wrap; align-items: center; gap: 15px; width: 100%; }

    .form-select-custom { padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: 'Poppins'; font-size: 0.9rem; color: #475569; outline: none; background: #f8fafc; cursor: pointer; margin-left: 8px; }
    .form-input-custom { padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: 'Poppins'; font-size: 0.9rem; color: #475569; outline: none; width: 100%; }

    .btn-success-custom { background: #15803d; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: 0.3s; }
    .btn-success-custom:hover { background: #059669; transform: translateY(-1px); }

    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; transition: 0.2s; display: flex; justify-content: space-between; align-items: center; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
    .stat-icon { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.5rem; }
    .stat-title { color: #64748b; font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; }
    .stat-value { font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0; line-height: 1.2; }

    .text-success { color: #10b981; }
    .bg-success-light { background: #d1fae5; color: #059669; }
    .text-warning { color: #f59e0b; }
    .bg-warning-light { background: #fef3c7; color: #d97706; }
    .text-primary { color: #3b82f6; }
    .bg-primary-light { background: #dbeafe; color: #1d4ed8; }
    .text-info { color: #06b6d4; }
    .bg-info-light { background: #cffafe; color: #0e7490; }
    .text-danger { color: #ef4444; }
    .bg-danger-light { background: #fee2e2; color: #b91c1b; }

    .table-action-group { display: flex; justify-content: center; gap: 8px; }
    .btn-icon { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; text-decoration: none; border: none; cursor: pointer; transition: 0.2s; }
    .btn-delete { color: #ef4444; background: #fef2f2; }
    .btn-delete:hover { background: #ef4444; color: white; }
    .btn-view { color: #15803d; background: #ecfdf5; }
    .btn-view:hover { background: #10b981; color: white; }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom thead tr {
        background: #15803d;
    }

    .table-custom th {
        padding: 16px 20px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .table-custom td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.85rem;
        vertical-align: middle;
    }


    .badge { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-block; }
    .badge-status { font-size: 11px; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; font-weight: 700; }

    .search-wrapper { position: relative; flex: 1; min-width: 250px; }
    .search-wrapper i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .search-wrapper input { padding-left: 38px; }

    .custom-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 999999; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
    .custom-modal-overlay.show { opacity: 1; pointer-events: auto; }
    .custom-modal { background: #ffffff; border-radius: 16px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: scale(0.95); transition: transform 0.2s ease; }
    .custom-modal-overlay.show .custom-modal { transform: scale(1); }

    .modal-header-custom { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px; display: flex; justify-content: space-between; align-items: flex-start; }
    .modal-header-custom h5 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
    .modal-header-custom p { color: #64748b; font-size: 0.85rem; margin: 0; }
    .btn-close-custom { background: transparent; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; transition: 0.2s; }
    .btn-close-custom:hover { color: #ef4444; }

    .modal-body-custom { padding: 25px; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; margin-bottom: 8px; display: block; }
    .text-box-readonly { background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; line-height: 1.6; color: #334155; margin-bottom: 20px; }

    .range-group { display: flex; align-items: center; gap: 15px; margin-bottom: 10px; }
    .range-custom { flex: 1; height: 6px; background: #e2e8f0; border-radius: 5px; outline: none; appearance: none; }
    .range-custom::-webkit-slider-thumb { appearance: none; width: 18px; height: 18px; border-radius: 50%; background: #10b981; cursor: pointer; }
    .input-nilai-custom { width: 80px; text-align: center; font-size: 1.2rem; font-weight: 700; border: 2px solid #cbd5e1; border-radius: 8px; padding: 5px; outline: none; color: #1e293b; }
    .input-nilai-custom:focus { border-color: #10b981; }

    .textarea-custom { width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 15px; font-family: 'Poppins'; font-size: 0.9rem; outline: none; resize: vertical; min-height: 100px; }
    .textarea-custom:focus { border-color: #10b981; }

    .modal-footer-custom { padding: 20px 25px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px; }
    .btn-light-custom { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: 1px solid #cbd5e1; cursor: pointer; transition: 0.2s; }
    .btn-light-custom:hover { background: #e2e8f0; }

</style>

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                Monitoring Pemahaman Siswa
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pantau hasil jawaban dan kesimpulan siswa, berikan penilaian langsung
            </p>
        </div>

        <button
            class="inline-flex items-center justify-center px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1"
            id="btnDownloadRekap">
            <i class="fa-solid fa-download mr-2"></i>
            Unduh Rekap
        </button>
    </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <i class="fa-solid fa-circle-info text-[#15803d] text-lg"></i>
                <h3 class="font-bold text-[#14532d]">
                    Petunjuk Monitoring Pemahaman Siswa
                </h3>
            </div>
            <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
                <li>• Fitur Pemahaman siswa digunakan untuk memantau pemahaman siswa berdasarkan jawaban atau kesimpulan yang telah dikirimkan.</li>
                <li>• Guru dapat melihat rekap hasil jawaban seluruh siswa dari aktivitas mengkomunikasikan</li>
                <li>• Guru dapat memberikan nilai dan umpan balik (feedback).</li>
                <li>• Nilai dan feedback yang diberikan hanya dapat dilihat serta disimpan oleh guru.</li>
                <li>• Hasil monitoring membantu guru dalam menilai tingkat pemahaman siswa terhadap materi yang dipelajari.</li>
                <li>• Rekap hasil monitoring dapat diunduh dalam bentuk file excel</li>
            </ul>
        </div>
    <div class="stat-grid">
        <div class="stat-card">
            <div>
                <p class="stat-title">TOTAL LAPORAN</p>
                <h2 class="stat-value" id="totalSiswa">0</h2>
            </div>
            <div class="stat-icon bg-primary-light">
                <i class="fa-solid fa-file-lines"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-title">SUDAH DINILAI</p>
                <h2 class="stat-value text-success" id="sudahDinilai">0</h2>
            </div>
            <div class="stat-icon bg-success-light">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-title">BELUM DINILAI</p>
                <h2 class="stat-value text-warning" id="belumDinilai">0</h2>
            </div>
            <div class="stat-icon bg-warning-light">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <p class="stat-title">RATA-RATA NILAI</p>
                <h2 class="stat-value text-info" id="rataNilai">0</h2>
            </div>
            <div class="stat-icon bg-info-light">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
    </div>

    <div class="action-bar">
        <div class="action-group-filter">
            <div>
                <label style="font-weight: 600; color: #475569; font-size: 0.85rem;">Pilih Materi:</label>
                <select id="filterMateri" class="form-select-custom">
                    <option value="all">📚 Semua Materi</option>
                    <option value="materi1">📗 Materi 1: Meristem</option>
                    <option value="materi2">📘 Materi 2: Dewasa</option>
                    <option value="materi3">📙 Materi 3: Struktur</option>
                </select>
            </div>

            <div>
                <label style="font-weight: 600; color: #475569; font-size: 0.85rem;">Filter Status:</label>
                <select id="filterPenilaian" class="form-select-custom">
                    <option value="all">📋 Semua Laporan</option>
                    <option value="sudah">✅ Sudah Dinilai</option>
                    <option value="belum">⏳ Belum Dinilai</option>
                </select>
            </div>

            <div class="search-wrapper">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="searchSiswa" class="form-input-custom" placeholder="Cari nama siswa...">
            </div>
        </div>
    </div>

    <div class="card-custom" style="overflow-x: auto;">
        <table class="table-custom">
            <thead class="bg-[#15803d] text-white">
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="min-width: 140px;">Nama Siswa</th>
                    <th style="min-width: 110px;">Sumber</th>
                    <th style="min-width: 250px;">Jawaban Analisis</th>
                    <th style="min-width: 250px;">Kesimpulan Akhir</th>
                    <th style="width: 100px; text-align: center;">Nilai</th>
                    <th style="min-width: 200px;">Feedback Guru</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="siswaTableBody"></tbody>
        </table>
    </div>
</div>

<div id="penilaianModalOverlay" class="custom-modal-overlay">
    <div class="custom-modal">
        <div class="modal-header-custom">
            <div>
                <h5>
                    <i class="fa-solid fa-star text-warning" style="margin-right: 8px;"></i>
                    Penilaian & Feedback
                </h5>
                <p id="modalSiswaName">-</p>
            </div>
            <button type="button" class="btn-close-custom" onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-body-custom">
            <label class="form-label">Jawaban Siswa</label>
            <div class="text-box-readonly" id="modalJawaban"></div>

            <label class="form-label">Kesimpulan Siswa</label>
            <div class="text-box-readonly" style="font-style: italic;" id="modalKesimpulan"></div>

            <label class="form-label">
                <i class="fa-solid fa-graduation-cap text-success"></i>
                Beri Nilai (0 - 100)
            </label>

            <div class="range-group">
                <input type="range" class="range-custom" id="nilaiSlider" min="0" max="100" step="1" value="75">
                <input type="number" class="input-nilai-custom" id="nilaiAngka" min="0" max="100" value="75">
            </div>

            <div style="margin-bottom: 20px;">
                <span class="badge" id="predikatLabel">Baik (B)</span>
            </div>

            <label class="form-label">
                <i class="fa-regular fa-message text-success"></i>
                Feedback / Catatan Guru
            </label>
            <textarea class="textarea-custom" id="feedbackText" placeholder="Tulis feedback atau catatan untuk siswa..."></textarea>
        </div>

        <div class="modal-footer-custom">
            <button type="button"
                    onclick="closeModal()"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-[#dc2626] hover:bg-[#b91c1c] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300">
                Batal
            </button>

            <button type="button"
                    id="simpanPenilaianBtn"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300 gap-2">
                <i class="fa-regular fa-floppy-disk"></i>
                Simpan Penilaian
            </button>
        </div>
    </div>
</div>

<script>
    let siswaData = @json($siswaData ?? []);
    let currentSiswaId = null;

    const swalConfig = {
        customClass: {
            popup: 'logout-swal-popup',
            title: 'logout-swal-title',
            htmlContainer: 'logout-swal-text',
            confirmButton: 'logout-swal-confirm',
            cancelButton: 'logout-swal-cancel'
        },
        backdrop: 'rgba(15, 23, 42, 0.6)'
    };

    function alertBerhasil(pesan) {
        Swal.fire({
            ...swalConfig,
            title: 'Berhasil!',
            text: pesan,
            icon: 'success',
            confirmButtonColor: '#15803d',
            confirmButtonText: 'Oke'
        });
    }

    function alertGagal(pesan) {
        Swal.fire({
            ...swalConfig,
            title: 'Terjadi Kesalahan',
            text: pesan,
            icon: 'error',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Tutup'
        });
    }

    function alertPeringatan(pesan) {
        Swal.fire({
            ...swalConfig,
            title: 'Peringatan',
            text: pesan,
            icon: 'warning',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Mengerti'
        });
    }

    function updateStatistik() {
        const total = siswaData.length;
        const sudah = siswaData.filter(s => s.statusPenilaian === 'sudah').length;
        const belum = total - sudah;

        const siswaSudahDinilai = siswaData.filter(s => s.nilai !== null);
        const totalNilai = siswaSudahDinilai.reduce((sum, s) => sum + Number(s.nilai), 0);
        const rataNilai = siswaSudahDinilai.length > 0 ? Math.round(totalNilai / siswaSudahDinilai.length) : 0;

        document.getElementById('totalSiswa').innerText = total;
        document.getElementById('sudahDinilai').innerText = sudah;
        document.getElementById('belumDinilai').innerText = belum;
        document.getElementById('rataNilai').innerText = rataNilai;
    }

    function getPredikat(nilai) {
        if (nilai >= 85) return { text: 'A (Sangat Baik)', class: 'bg-success-light' };
        if (nilai >= 70) return { text: 'B (Baik)', class: 'bg-primary-light' };
        if (nilai >= 60) return { text: 'C (Cukup)', class: 'bg-warning-light' };
        return { text: 'D (Perlu Bimbingan)', class: 'bg-danger-light' };
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.toString().replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function escapeCsv(value) {
        const text = value === null || value === undefined ? '' : String(value);
        return `"${text.replace(/"/g, '""')}"`;
    }

    function getLabelMateri(slug) {
        if (slug === 'materi1') return '<span class="badge bg-primary-light">Materi 1</span>';
        if (slug === 'materi2') return '<span class="badge bg-info-light">Materi 2</span>';
        if (slug === 'materi3') return '<span class="badge bg-warning-light">Materi 3</span>';
        return escapeHtml(slug);
    }

    function renderTabel() {
        const searchValue = document.getElementById('searchSiswa').value.toLowerCase();
        const filterPenilaianValue = document.getElementById('filterPenilaian').value;
        const filterMateriValue = document.getElementById('filterMateri').value;

        let filteredData = [...siswaData];

        if (searchValue) {
            filteredData = filteredData.filter(s => (s.nama || '').toLowerCase().includes(searchValue));
        }

        if (filterPenilaianValue === 'sudah') {
            filteredData = filteredData.filter(s => s.statusPenilaian === 'sudah');
        } else if (filterPenilaianValue === 'belum') {
            filteredData = filteredData.filter(s => s.statusPenilaian === 'belum');
        }

        if (filterMateriValue !== 'all') {
            filteredData = filteredData.filter(s => s.materi === filterMateriValue);
        }

        const tbody = document.getElementById('siswaTableBody');
        tbody.innerHTML = '';

        if (filteredData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align:center; padding: 40px; color:#94a3b8;">
                        <i class="fa-regular fa-folder-open" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                        <br>Belum ada data laporan / pemahaman dari siswa.
                    </td>
                </tr>
            `;
            return;
        }

        filteredData.forEach((siswa, index) => {
            const predikat = siswa.nilai !== null ? getPredikat(Number(siswa.nilai)) : null;

            const nilaiDisplay = siswa.nilai !== null ? `
                <div style="text-align:center;">
                    <span style="font-weight:700; font-size:1.1rem; color:#1e293b;">${siswa.nilai}</span>
                    <br>
                    <span style="font-size:10px; color:#64748b;">${predikat.text.split(' ')[0]}</span>
                </div>
            ` : `<div style="text-align:center; color:#94a3b8;">-</div>`;

            const feedbackDisplay = siswa.feedback ? `
                <div style="background:#f0fdf4; color:#166534; padding:8px 12px; border-radius:8px; font-size:0.8rem;">
                    <i class="fa-solid fa-quote-left" style="opacity:0.5; margin-right:5px;"></i>
                    ${escapeHtml(siswa.feedback.substring(0, 50))}${siswa.feedback.length > 50 ? '...' : ''}
                </div>
            ` : `<span style="color:#94a3b8; font-style:italic; font-size:0.8rem;">Belum ada feedback</span>`;

            tbody.innerHTML += `
                <tr>
                    <td style="text-align:center; color:#64748b; font-weight:600;">${index + 1}</td>
                    <td style="font-weight:600; color:#1e293b;">${escapeHtml(siswa.nama)}</td>
                    <td>${getLabelMateri(siswa.materi)}</td>
                    <td><div style="font-size:0.85rem;">${escapeHtml(siswa.jawaban)}</div></td>
                    <td><div style="font-size:0.85rem; font-style:italic; color:#475569;">"${escapeHtml(siswa.kesimpulan)}"</div></td>
                    <td>${nilaiDisplay}</td>
                    <td>${feedbackDisplay}</td>
                    <td style="text-align:center;">
                        ${siswa.statusPenilaian === 'sudah'
                            ? `<span class="badge-status bg-success-light"><i class="fa-solid fa-check-circle"></i> Sudah</span>`
                            : `<span class="badge-status bg-warning-light"><i class="fa-solid fa-clock"></i> Belum</span>`
                        }
                    </td>
                    <td>
                        <div class="table-action-group">
                            <button class="btn-icon btn-view" onclick="openPenilaianModal(${siswa.id})" title="Beri Nilai">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            ${siswa.nilai !== null ? `
                                <button class="btn-icon btn-delete" onclick="resetPenilaian(${siswa.id})" title="Reset Penilaian">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function updatePredikatModal(nilai) {
        const predikat = getPredikat(nilai);
        const predikatLabel = document.getElementById('predikatLabel');
        predikatLabel.textContent = predikat.text;
        predikatLabel.className = `badge ${predikat.class}`;
    }

    const modalOverlay = document.getElementById('penilaianModalOverlay');

    function openPenilaianModal(idRow) {
        const siswa = siswaData.find(s => s.id === idRow);
        if (!siswa) return;

        currentSiswaId = idRow;

        document.getElementById('modalSiswaName').innerHTML = `
            <i class="fa-regular fa-user" style="margin-right:5px;"></i>
            ${escapeHtml(siswa.nama)} - Laporan ${escapeHtml(siswa.materi)}
        `;
        document.getElementById('modalJawaban').innerHTML = escapeHtml(siswa.jawaban);
        document.getElementById('modalKesimpulan').innerHTML = `"${escapeHtml(siswa.kesimpulan)}"`;

        const nilaiAwal = siswa.nilai !== null ? Number(siswa.nilai) : 75;
        document.getElementById('nilaiSlider').value = nilaiAwal;
        document.getElementById('nilaiAngka').value = nilaiAwal;
        document.getElementById('feedbackText').value = siswa.feedback || '';

        updatePredikatModal(nilaiAwal);
        modalOverlay.classList.add('show');
    }

    function closeModal() {
        modalOverlay.classList.remove('show');
    }

    async function simpanPenilaian() {
        const nilai = parseInt(document.getElementById('nilaiAngka').value);
        const feedbackText = document.getElementById('feedbackText').value.trim();

        if (isNaN(nilai) || nilai < 0 || nilai > 100) {
            alertPeringatan('Mohon masukkan nilai antara 0 sampai 100.');
            return;
        }

        const btnSave = document.getElementById('simpanPenilaianBtn');
        btnSave.disabled = true;
        btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right:8px;"></i> Menyimpan...';

        try {
            const response = await fetch("{{ route('guru.mengkomunikasikan.simpan') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: currentSiswaId,
                    nilai: nilai,
                    feedback: feedbackText
                })
            });

            if (!response.ok) {
                throw new Error('Gagal merespons server');
            }

            const siswa = siswaData.find(s => s.id === currentSiswaId);

            if (siswa) {
                siswa.nilai = nilai;
                siswa.feedback = feedbackText;
                siswa.statusPenilaian = 'sudah';
            }

            updateStatistik();
            renderTabel();
            closeModal();

            alertBerhasil(`Penilaian untuk ${siswa ? siswa.nama : 'siswa'} berhasil disimpan.`);
        } catch (error) {
            alertGagal('Terjadi kesalahan saat menyimpan data. Silakan cek koneksi Kamu.');
        } finally {
            btnSave.disabled = false;
            btnSave.innerHTML = '<i class="fa-regular fa-floppy-disk" style="margin-right:8px;"></i> Simpan Penilaian';
        }
    }

    async function resetPenilaian(idRow) {
        const siswa = siswaData.find(s => s.id === idRow);

        Swal.fire({
            ...swalConfig,
            title: 'Reset Penilaian?',
            text: `Nilai dan feedback ${siswa ? siswa.nama : 'siswa ini'} akan dikosongkan kembali.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(async (result) => {
            if (!result.isConfirmed) return;

            try {
                const response = await fetch("{{ route('guru.mengkomunikasikan.simpan') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        id: idRow,
                        nilai: null,
                        feedback: null
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal mereset penilaian');
                }

                if (siswa) {
                    siswa.nilai = null;
                    siswa.feedback = null;
                    siswa.statusPenilaian = 'belum';
                }

                updateStatistik();
                renderTabel();

                alertBerhasil(`Penilaian untuk ${siswa ? siswa.nama : 'siswa'} berhasil direset.`);
            } catch (error) {
                alertGagal('Gagal mereset penilaian. Silakan coba lagi.');
            }
        });
    }

    function downloadRekap() {
        if (!siswaData.length) {
            alertPeringatan('Belum ada data yang bisa diunduh.');
            return;
        }

        Swal.fire({
            ...swalConfig,
            title: 'Unduh Rekap Pemahaman?',
            text: 'Data monitoring pemahaman siswa akan diunduh dalam format CSV.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Unduh',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;

            let csv = "No,Nama Siswa,Materi,Jawaban Singkat,Kesimpulan Pembelajaran,Nilai,Feedback,Status\n";

            siswaData.forEach((siswa, index) => {
                csv += [
                    index + 1,
                    escapeCsv(siswa.nama),
                    escapeCsv(siswa.materi),
                    escapeCsv(siswa.jawaban),
                    escapeCsv(siswa.kesimpulan),
                    siswa.nilai !== null ? siswa.nilai : '-',
                    escapeCsv(siswa.feedback || ''),
                    escapeCsv(siswa.statusPenilaian)
                ].join(',') + "\n";
            });

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.href = url;
            link.setAttribute('download', 'rekap_pemahaman_siswa.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            alertBerhasil('Rekap pemahaman siswa berhasil diunduh.');
        });
    }

    function bindNilaiEvents() {
        const slider = document.getElementById('nilaiSlider');
        const angka = document.getElementById('nilaiAngka');

        slider.addEventListener('input', function() {
            angka.value = this.value;
            updatePredikatModal(parseInt(this.value));
        });

        angka.addEventListener('input', function() {
            let val = parseInt(this.value);

            if (isNaN(val)) val = 0;
            if (val > 100) val = 100;
            if (val < 0) val = 0;

            angka.value = val;
            slider.value = val;
            updatePredikatModal(val);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        bindNilaiEvents();
        updateStatistik();
        renderTabel();

        document.getElementById('searchSiswa').addEventListener('keyup', renderTabel);
        document.getElementById('filterPenilaian').addEventListener('change', renderTabel);
        document.getElementById('filterMateri').addEventListener('change', renderTabel);
        document.getElementById('simpanPenilaianBtn').addEventListener('click', simpanPenilaian);
        document.getElementById('btnDownloadRekap').addEventListener('click', downloadRekap);
    });
</script>
@endsection