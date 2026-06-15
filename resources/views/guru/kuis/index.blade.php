@extends('layouts.guru')

@section('content')

<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Soal Kuis</h2>
            <p class="text-sm text-gray-500 mt-1">Soal untuk: <b class="text-[#15803d]">{{ request('kuis_id') ? $kuis->find(request('kuis_id'))->nama_kuis : 'Semua Kuis' }}</b></p>
        </div>
        <a href="{{ route('guru.kuis.create') }}"
        class="inline-flex items-center justify-center px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Soal 
        </a>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6 shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i class="fa-solid fa-circle-info text-[#15803d] text-lg"></i>
        <h3 class="font-bold text-[#14532d]">
            Petunjuk Pengelolaan Soal Kuis
        </h3>
    </div>
        <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <li>
                • Pilih kategori kuis yang sesuai dengan materi pembelajaran (Kuis 1 untuk Materi 1, Kuis 2 untuk Materi 2, dan Kuis 3 untuk Materi 3).
            </li>
            <li>
                • Setiap kategori kuis dapat berisi maksimal 10 soal sesuai dengan ketentuan sistem.
            </li>
            <li>
                • Soal dapat dibuat dalam bentuk Pilihan Ganda (PG) dan Isian Singkat.
            </li>
            <li>
                • Isikan kunci jawaban dengan jelas dan sesuai dengan jawaban yang diharapkan.
            </li>
            <li>
                • Gunakan tombol <strong>Tambah Soal</strong> untuk menambahkan soal baru.
            </li>
            <li>
                • Gunakan tombol <strong>Edit</strong> untuk memperbarui soal yang sudah dibuat.
            </li>
            <li>
                • Gunakan tombol <strong>Hapus</strong> untuk menghapus soal yang tidak diperlukan.
            </li>
        </ul>
    </div>
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6 relative z-20">
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full">
            <label class="text-sm font-semibold text-gray-700 whitespace-nowrap">Pilih Kuis:</label>
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <i class="fa-solid fa-layer-group text-gray-400"></i>
                </div>
                <select name="kuis_id" onchange="this.form.submit()" class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#15803d] focus:border-[#15803d] outline-none transition-all cursor-pointer appearance-none">
                    <option value="">Semua Kuis</option>
                    @foreach($kuis as $k)
                        <option value="{{ $k->id }}" {{ request('kuis_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kuis }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-[#15803d] text-white">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Pertanyaan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-24">Tipe</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-24">Kunci</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($soal as $s)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900 line-clamp-2">
                                {{ Str::limit($s->pertanyaan, 80) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($s->tipe_soal == 'pg')
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-lg bg-sky-100 text-sky-700 border border-sky-200">
                                    PG
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-lg bg-amber-100 text-amber-700 border border-amber-200">
                                    ISIAN
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-sm font-bold rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200">
                                {{ $s->kunci }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('guru.kuis.edit', $s->id) }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Edit Soal">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <button type="button" onclick="confirmDelete({{ $s->id }})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Hapus Soal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                
                                <form id="delete-form-{{ $s->id }}" action="{{ route('guru.kuis.destroy', $s->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                <i class="fa-solid fa-clipboard-question text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Belum ada soal</h3>
                            <p class="mt-1 text-sm text-gray-500">Silakan pilih kuis atau tambahkan soal baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const swalStyle = {
        customClass: {
            popup: 'logout-swal-popup',
            title: 'logout-swal-title',
            htmlContainer: 'logout-swal-text',
            confirmButton: 'logout-swal-confirm',
            cancelButton: 'logout-swal-cancel'
        },
        backdrop: 'rgba(15, 23, 42, 0.6)'
    };

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                ...swalStyle,
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#15803d',
                confirmButtonText: 'Oke'
            });
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                ...swalStyle,
                title: 'Gagal!',
                text: @json(session('error')),
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            ...swalStyle,
            title: 'Hapus Soal Kuis?',
            text: 'Data soal ini akan dihapus permanen dan tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#15803d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection