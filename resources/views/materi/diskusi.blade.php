@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-slate-50 min-h-screen p-4 sm:p-8 font-sans">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 flex flex-col h-[85vh] overflow-hidden">
        
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-5 flex items-center gap-4 shrink-0">
            <a href="{{ route('materi.index') }}" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-white tracking-wide">Forum Diskusi Kelas</h2>
                <div id="statusSesi" class="text-sm text-emerald-100 flex items-center gap-1.5 mt-0.5">
                    <i class="fas fa-spinner fa-spin"></i> Mengecek status sesi...
                </div>
            </div>
            <select id="topicSelect" onchange="gantiTopik()" class="bg-white/10 text-white border border-white/30 rounded-xl px-4 py-2 outline-none focus:bg-white focus:text-emerald-800 transition-colors cursor-pointer font-semibold text-sm">
                <option value="materi1" class="text-gray-800">Materi 1: Meristem</option>
                <option value="materi2" class="text-gray-800">Materi 2: Dewasa</option>
                <option value="materi3" class="text-gray-800">Materi 3: Struktur</option>
            </select>
        </div>

        <div id="chatBox" class="flex-1 overflow-y-auto p-6 bg-[#f8fafc] space-y-4">
            </div>

        <div class="p-4 bg-white border-t border-gray-100 flex gap-3 shrink-0">
            <input type="text" id="pesanInput" placeholder="Sesi ditutup. Kamu tidak dapat mengirim pesan." disabled class="flex-1 px-5 py-3 bg-gray-100 border border-gray-200 rounded-full focus:outline-none transition-all text-sm disabled:opacity-60 disabled:cursor-not-allowed" onkeypress="if(event.key === 'Enter') kirimPesan()">
            <button id="btnKirim" disabled onclick="kirimPesan()" class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

    </div>
</div>

<script>
    let currentTopic = 'materi1';
    let isSessionOpen = false;
    let jumlahPesanLama = 0;

    function gantiTopik() {
        currentTopic = document.getElementById('topicSelect').value;
        document.getElementById('chatBox').innerHTML = '<div class="text-center mt-10 text-gray-400"><i class="fas fa-circle-notch fa-spin text-2xl"></i></div>';
        jumlahPesanLama = 0;
        tarikPesan();
    }

    async function tarikPesan() {
        try {
            const res = await fetch(`/messages/${currentTopic}`);
            const data = await res.json();
            
            // Atur Status Sesi
            isSessionOpen = data.is_active;
            const inputEl = document.getElementById('pesanInput');
            const btnEl = document.getElementById('btnKirim');
            const statusEl = document.getElementById('statusSesi');

            if (isSessionOpen) {
                statusEl.innerHTML = '<i class="fas fa-circle text-[10px] text-green-300"></i> Sesi Dibuka oleh Guru';
                inputEl.disabled = false;
                btnEl.disabled = false;
                inputEl.placeholder = "Ketik pertanyaan atau tanggapan Kamu di sini...";
                inputEl.classList.add('bg-white', 'focus:ring-2', 'focus:ring-emerald-500', 'focus:border-emerald-500');
            } else {
                statusEl.innerHTML = '<i class="fas fa-lock text-[10px] text-rose-300"></i> Sesi Ditutup oleh Guru';
                inputEl.disabled = true;
                btnEl.disabled = true;
                inputEl.placeholder = "Sesi ditutup. Kamu tidak dapat mengirim pesan.";
                inputEl.classList.remove('bg-white', 'focus:ring-2');
            }

            // Render Pesan Jika Ada Baru
            if (data.messages.length !== jumlahPesanLama) {
                renderPesan(data.messages);
                jumlahPesanLama = data.messages.length;
                const chatBox = document.getElementById('chatBox');
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        } catch (err) { console.log("Gagal menarik pesan"); }
    }

    function renderPesan(messages) {
        let html = '';
        if(messages.length === 0) {
            html = `<div class="text-center text-gray-400 mt-20"><i class="fas fa-comments text-5xl opacity-20 mb-3"></i><p>Belum ada diskusi di materi ini.</p></div>`;
        } else {
            messages.forEach(msg => {
                if(msg.user_name === 'Sistem') {
                    html += `<div class="flex justify-center my-4"><span class="px-4 py-1.5 bg-gray-200 text-gray-600 text-[11px] font-bold rounded-full">${msg.message}</span></div>`;
                } else if (msg.user_name === '{{ Auth::user()->name }}') {
                    html += `
                    <div class="flex justify-end mb-2">
                        <div class="bg-emerald-500 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm max-w-[75%] text-sm shadow-sm">${msg.message}</div>
                    </div>`;
                } else if (msg.user_name === 'Guru Sarah' || msg.user_id === 3) { // Asumsi ID Guru / Nama Guru
                    html += `
                    <div class="flex justify-start gap-2 mb-2">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs shrink-0 border border-amber-200">GR</div>
                        <div class="flex flex-col items-start max-w-[75%]">
                            <span class="text-[11px] font-bold text-amber-600 mb-1">${msg.user_name}</span>
                            <div class="bg-white border border-gray-200 px-4 py-2.5 rounded-2xl rounded-tl-sm text-sm text-gray-700 shadow-sm">${msg.message}</div>
                        </div>
                    </div>`;
                } else {
                    html += `
                    <div class="flex justify-start gap-2 mb-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0 border border-slate-300">${msg.user_name.substring(0,2).toUpperCase()}</div>
                        <div class="flex flex-col items-start max-w-[75%]">
                            <span class="text-[11px] font-bold text-slate-500 mb-1">${msg.user_name}</span>
                            <div class="bg-white border border-gray-200 px-4 py-2.5 rounded-2xl rounded-tl-sm text-sm text-gray-700 shadow-sm">${msg.message}</div>
                        </div>
                    </div>`;
                }
            });
        }
        document.getElementById('chatBox').innerHTML = html;
    }

    async function kirimPesan() {
        const input = document.getElementById('pesanInput');
        const text = input.value.trim();
        if(!text || !isSessionOpen) return;
        
        input.value = '';
        await fetch('/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ topic: currentTopic, message: text })
        });
        tarikPesan();
    }

    setInterval(tarikPesan, 2500); // Polling tiap 2.5 detik
    tarikPesan();
</script>
@endsection