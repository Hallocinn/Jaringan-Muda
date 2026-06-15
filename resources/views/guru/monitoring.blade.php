@extends('layouts.guru')

@section('content')
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .tab-btn { background: #f8fafc; color: #64748b; border-color: #e2e8f0; }
    .tab-btn.active { background: #1e293b; color: #fff; border-color: #1e293b; }
    .tab-btn.active i { color: #10b981; }

    #chatMessages::-webkit-scrollbar { width: 6px; }
    #chatMessages::-webkit-scrollbar-track { background: transparent; }
    #chatMessages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        letter-spacing: -0.025em;
    }

    .page-subtitle {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
</style>

<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="page-title">
            Ruang Diskusi
        </h2>

        <p class="page-subtitle">
            Mengelola sesi diskusi dengan membuka atau menutup sesi serta memantau aktivitas diskusi
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6 shadow-sm">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-circle-info text-[#15803d] text-lg"></i>
            <h3 class="font-bold text-[#14532d]">
                Petunjuk Pengelolaan Ruang Diskusi
            </h3>
        </div>

        <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <li>• Gunakan tombol <strong>Buka Sesi</strong> untuk memulai sesi diskusi.</li>
            <li>• Gunakan tombol <strong>Tutup Sesi</strong> untuk mengakhiri sesi diskusi.</li>
            <li>• Guru dapat mengirim pesan, pertanyaan, tanggapan, atau arahan selama sesi diskusi berlangsung.</li>
            <li>• Pesan yang dikirim guru akan ditampilkan kepada seluruh peserta didik yang mengikuti diskusi.</li>
            <li>• Pastikan sesi diskusi dibuka terlebih dahulu agar peserta didik dapat mengirim dan membaca pesan.</li>
        </ul>
    </div>

    <div class="flex gap-3 mb-6 overflow-x-auto pb-2 shrink-0 hide-scrollbar">
        <button onclick="switchTopic('materi1')" id="tab-materi1" class="tab-btn active shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all flex items-center gap-2 border shadow-sm">
            Materi 1
        </button>

        <button onclick="switchTopic('materi2')" id="tab-materi2" class="tab-btn shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all flex items-center gap-2 border shadow-sm">
            Materi 2
        </button>

        <button onclick="switchTopic('materi3')" id="tab-materi3" class="tab-btn shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all flex items-center gap-2 border shadow-sm">
            Materi 3
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden">
        <div class="bg-slate-50 p-5 border-b border-gray-100 flex justify-between items-center flex-wrap gap-4 shrink-0">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2" id="sessionTitle">
                    <i class="fas fa-comments text-brand-500"></i> Diskusi: Jaringan Meristem
                </h3>

                <div id="sessionStatus" class="mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                    <i class="fas fa-lock"></i> Sesi Ditutup
                </div>
            </div>

            <div class="flex gap-3">
                <button id="btnStart"
                    onclick="toggleSession('start')"
                    class="px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white text-sm font-bold rounded-xl shadow-lg shadow-green-800/30 transition-all flex items-center gap-2">
                    <i class="fas fa-play"></i>
                    Buka Sesi
                </button>

                <button id="btnEnd"
                    onclick="toggleSession('end')"
                    class="hidden px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-500/30 transition-all flex items-center gap-2">
                    <i class="fas fa-stop"></i>
                    Tutup Sesi
                </button>
            </div>
        </div>

        <div id="chatMessages" class="flex-1 overflow-y-auto p-6 bg-slate-50/50 space-y-4"></div>

        <div class="p-4 bg-white border-t border-gray-100 flex gap-3 shrink-0">
            <input type="text"
                   id="chatInput"
                   placeholder="Ketik pesan kamu sebagai Guru..."
                   class="flex-1 px-5 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm"
                   onkeypress="handleEnter(event)">

            <button onclick="sendMessage()"
                class="w-12 h-12 rounded-full bg-[#15803d] hover:bg-[#14532d] text-white flex items-center justify-center shadow-md transition-all">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
    let currentTopic = 'materi1';
    let isSessionActive = false;
    let lastMessageCount = 0;

    const authUserName = @json(Auth::user()->name);

    const topicNames = {
        materi1: 'Jaringan Meristem',
        materi2: 'Jaringan Dewasa',
        materi3: 'Struktur & Fungsi'
    };

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

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function switchTopic(topic) {
        currentTopic = topic;

        document.getElementById('sessionTitle').innerHTML =
            `<i class="fas fa-comments text-brand-500"></i> Diskusi: ${topicNames[topic]}`;

        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`tab-${topic}`).classList.add('active');

        document.getElementById('chatMessages').innerHTML =
            '<div class="text-center text-gray-400 text-sm mt-10"><i class="fas fa-circle-notch fa-spin text-2xl mb-2"></i><br>Memuat pesan...</div>';

        lastMessageCount = 0;
        fetchMessages();
    }

    async function fetchMessages() {
        try {
            const response = await fetch(`/messages/${currentTopic}`);

            if (!response.ok) {
                throw new Error('Gagal mengambil pesan.');
            }

            const data = await response.json();

            isSessionActive = data.is_active;
            updateSessionUI();

            if (data.messages.length !== lastMessageCount) {
                renderMessages(data.messages);
                lastMessageCount = data.messages.length;
                scrollToBottom();
            }
        } catch (error) {
            console.error('Gagal mengambil pesan:', error);
        }
    }

    function renderMessages(messages) {
        const container = document.getElementById('chatMessages');
        let html = '';

        if (messages.length === 0) {
            html = `
                <div class="text-center text-gray-400 mt-20">
                    <i class="fas fa-comment-dots text-5xl opacity-30 mb-3"></i>
                    <p class="text-sm">Belum ada diskusi di materi ini.</p>
                </div>
            `;
        } else {
            messages.forEach(msg => {
                const userName = escapeHtml(msg.user_name);
                const message = escapeHtml(msg.message);
                const initial = userName.substring(0, 2).toUpperCase();

                if (msg.user_name === 'Sistem') {
                    html += `
                        <div class="flex justify-center my-4">
                            <span class="px-4 py-1.5 bg-slate-200/70 text-slate-600 text-xs font-bold rounded-full">
                                ${message}
                            </span>
                        </div>
                    `;
                } else if (msg.user_name === authUserName) {
                    html += `
                        <div class="flex justify-end gap-3 mb-2 animate-[fadeInUp_0.2s_ease-out]">
                            <div class="flex flex-col items-end max-w-[80%]">
                                <span class="text-[11px] font-bold text-brand-600 mb-1">Kamu (Guru)</span>
                                <div class="px-4 py-2.5 bg-brand-500 text-white text-sm rounded-2xl rounded-tr-sm shadow-sm leading-relaxed">
                                    ${message}
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs shrink-0 border border-brand-200">
                                GR
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="flex justify-start gap-3 mb-2 animate-[fadeInUp_0.2s_ease-out]">
                            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0 border border-slate-300">
                                ${initial}
                            </div>
                            <div class="flex flex-col items-start max-w-[80%]">
                                <span class="text-[11px] font-bold text-slate-500 mb-1">${userName}</span>
                                <div class="px-4 py-2.5 bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl rounded-tl-sm shadow-sm leading-relaxed">
                                    ${message}
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
        }

        container.innerHTML = html;
    }

    async function sendMessage() {
        const input = document.getElementById('chatInput');
        const text = input.value.trim();

        if (!text) return;

        input.value = '';

        try {
            const response = await fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    topic: currentTopic,
                    message: text
                })
            });

            if (!response.ok) {
                throw new Error('Pesan gagal dikirim.');
            }

            fetchMessages();
        } catch (error) {
            Swal.fire({
                ...swalConfig,
                title: 'Gagal Mengirim!',
                text: 'Pesan tidak berhasil dikirim. Silakan coba lagi.',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });
        }
    }

    function handleEnter(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    }

    function toggleSession(action) {
        const isStart = action === 'start';

        const title = isStart ? 'Buka Sesi Diskusi?' : 'Tutup Sesi Diskusi?';

        const message = isStart
            ? 'Siswa akan bisa mulai mengirim pesan pada ruang diskusi ini.'
            : 'Siswa tidak akan bisa mengirim pesan lagi pada ruang diskusi ini.';

        Swal.fire({
            ...swalConfig,
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,

            // Tombol utama hijau, tombol batal merah
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#dc2626',

            confirmButtonText: isStart ? 'Ya, Buka Sesi' : 'Ya, Tutup Sesi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch('/guru/monitoring/toggle-session', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            topic: currentTopic,
                            action: action
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Gagal mengubah status sesi.');
                    }

                    Swal.fire({
                        ...swalConfig,
                        title: 'Berhasil!',
                        text: isStart
                            ? 'Sesi diskusi berhasil dibuka.'
                            : 'Sesi diskusi berhasil ditutup.',
                        icon: 'success',
                        confirmButtonColor: '#15803d',
                        confirmButtonText: 'Oke'
                    });

                    fetchMessages();
                } catch (error) {
                    Swal.fire({
                        ...swalConfig,
                        title: 'Gagal!',
                        text: 'Status sesi diskusi tidak berhasil diubah. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Oke'
                    });
                }
            }
        });
    }

    function updateSessionUI() {
        const badge = document.getElementById('sessionStatus');
        const btnStart = document.getElementById('btnStart');
        const btnEnd = document.getElementById('btnEnd');

        if (isSessionActive) {
            badge.className = 'mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200';
            badge.innerHTML = '<i class="fas fa-unlock-keyhole"></i> Sesi Terbuka';

            btnStart.classList.add('hidden');
            btnEnd.classList.remove('hidden');
        } else {
            badge.className = 'mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200';
            badge.innerHTML = '<i class="fas fa-lock"></i> Sesi Ditutup';

            btnStart.classList.remove('hidden');
            btnEnd.classList.add('hidden');
        }
    }

    function scrollToBottom() {
        const container = document.getElementById('chatMessages');
        container.scrollTop = container.scrollHeight;
    }

    setInterval(fetchMessages, 3000);
    fetchMessages();
</script>
@endsection