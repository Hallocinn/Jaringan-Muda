@extends('layouts.guru')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-7xl mx-auto">
    
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('guru.kuis.index') }}" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                {{ isset($soal) ? 'Edit' : 'Tambah' }} Soal Kuis
            </h2>
        </div>
        <p class="text-sm text-gray-500 ml-11">Manajemen butir soal kuis dengan tampilan terstruktur.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-5 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            <span class="font-bold text-base">Gagal menyimpan! Periksa kesalahan berikut:</span>
        </div>
        <ul class="list-disc list-inside text-sm ml-8 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($soal) ? route('guru.kuis.update', $soal->id) : route('guru.kuis.store') }}" method="POST">
        @csrf
        @if(isset($soal)) @method('PUT') @endif

        <div class="flex flex-col lg:flex-row gap-6 mb-6">
            
            <div class="w-full lg:w-5/12 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Kuis</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-layer-group text-gray-400"></i>
                        </div>
                        <select name="kuis_id" required class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all cursor-pointer appearance-none">
                            <option value="">-- Pilih Kuis --</option>
                            @foreach($kuis as $k)
                                <option value="{{ $k->id }}" {{ (isset($soal) && $soal->kuis_id == $k->id) ? 'selected' : '' }}>{{ $k->nama_kuis }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Soal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-sliders text-gray-400"></i>
                        </div>
                        <select name="tipe_soal" id="tipe_soal" onchange="toggleInputs()" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all cursor-pointer appearance-none">
                            <option value="pg" {{ (isset($soal) && $soal->tipe_soal == 'pg') ? 'selected' : '' }}>Pilihan Ganda</option>
                            <option value="isian" {{ (isset($soal) && $soal->tipe_soal == 'isian') ? 'selected' : '' }}>Isian Singkat</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Butir Pertanyaan</label>
                    <textarea name="pertanyaan" rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all resize-y" placeholder="Tuliskan pertanyaan di sini..." required>{{ $soal->pertanyaan ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kunci Jawaban</label>
                    
                    <div id="kunci-pg" class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                            <i class="fa-solid fa-key text-emerald-600"></i>
                        </div>
                        <select name="kunci_pg" id="input-kunci-pg" class="w-full pl-10 pr-4 py-2.5 bg-emerald-50 border border-emerald-300 text-emerald-700 font-bold text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all cursor-pointer appearance-none">
                            @foreach(['A','B','C','D'] as $k)
                                <option value="{{ $k }}" {{ (isset($soal) && $soal->kunci == $k) ? 'selected' : '' }}>Pilihan {{ $k }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs text-emerald-600"></i>
                        </div>
                    </div>

                    <div id="kunci-isian" class="hidden relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-key text-emerald-600"></i>
                        </div>
                        <input type="text" name="kunci_isian" id="input-kunci-isian" class="w-full pl-10 pr-4 py-2.5 bg-emerald-50 border border-emerald-300 text-emerald-700 font-bold text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" placeholder="Tuliskan jawaban yang benar..." value="{{ $soal->kunci ?? '' }}">
                    </div>
                </div>
            </div>

            <div id="section-pg" class="w-full lg:w-7/12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-6 flex flex-col transition-all duration-300">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-list-ul text-slate-400"></i>
                    <p class="font-bold text-slate-500 text-xs uppercase tracking-wider m-0">Opsi Jawaban (Pilihan Ganda)</p>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                    <div class="flex bg-white rounded-xl border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-all shadow-sm">
                        <div class="bg-slate-100 w-12 flex items-center justify-center font-extrabold text-slate-500 border-r border-gray-200">
                            {{ strtoupper($opsi) }}
                        </div>
                        <textarea name="{{ $opsi }}" rows="2" class="flex-1 w-full p-3 text-sm text-gray-800 bg-transparent border-none outline-none resize-none" placeholder="Tulis opsi {{ strtoupper($opsi) }}...">{{ $soal->$opsi ?? '' }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('guru.kuis.index') }}"
            class="px-6 py-2.5 text-sm font-semibold text-white bg-[#dc2626] hover:bg-[#b91c1c] rounded-xl shadow-lg transition-all duration-200 focus:outline-none">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 text-sm font-semibold text-white bg-[#15803d] hover:bg-[#14532d] rounded-xl shadow-lg transition-all duration-200 focus:outline-none flex items-center gap-2">
                <i class="fa-solid fa-save"></i>
                Simpan Soal
            </button>
        </div>
    </form>
</div>

<script>
    // --- SweetAlert2 Toast untuk Error ---
    @if($errors->any())
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'error',
        title: 'Gagal Menyimpan!',
        text: 'Pastikan semua form telah diisi dengan benar.'
    });
    @endif

    // --- Fungsi Toggle Input PG vs Isian ---
    function toggleInputs() {
        const tipe = document.getElementById('tipe_soal').value;
        const sectionPg = document.getElementById('section-pg');
        
        const kunciPg = document.getElementById('kunci-pg');
        const kunciIsian = document.getElementById('kunci-isian');
        
        const inputPg = document.getElementById('input-kunci-pg');
        const inputIsian = document.getElementById('input-kunci-isian');

        if (tipe === 'pg') {
            // Tampilkan elemen PG, sembunyikan Isian
            sectionPg.classList.remove('hidden');
            sectionPg.classList.add('flex');
            
            kunciPg.classList.remove('hidden');
            kunciIsian.classList.add('hidden');
            
            // Atur properti 'name' agar ditangkap sebagai 'kunci' di Controller
            inputPg.setAttribute('name', 'kunci');
            inputIsian.removeAttribute('name');
            
        } else {
            // Sembunyikan elemen PG, tampilkan Isian
            sectionPg.classList.add('hidden');
            sectionPg.classList.remove('flex');
            
            kunciPg.classList.add('hidden');
            kunciIsian.classList.remove('hidden');
            
            // Atur properti 'name' agar ditangkap sebagai 'kunci' di Controller
            inputIsian.setAttribute('name', 'kunci');
            inputPg.removeAttribute('name');
        }
    }

    // Eksekusi fungsi toggle saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function() {
        toggleInputs();
    });
</script>
@endsection