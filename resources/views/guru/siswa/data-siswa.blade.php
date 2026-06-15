@extends('layouts.guru')
@section('content')

<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Data Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar siswa dan buatkan akun login secara otomatis.</p>
        </div>

        <button onclick="openModal('add')"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300"
            style="box-shadow:0 8px 16px rgba(20,83,45,.3);">
            Tambah Data
        </button>
    </div>
<div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6 shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i class="fa-solid fa-circle-info text-[#15803d] text-lg"></i>
        <h3 class="font-bold text-[#14532d]">
            Petunjuk Pengelolaan Data Siswa
        </h3>
    </div>
        <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <li>• Gunakan tombol <strong>Tambah Siswa</strong> untuk menambahkan data siswa baru.</li>
            <li>• Isikan data siswa sesuai dengan informasi yang diperlukan.</li>
            <li>• Gunakan tombol <strong>Edit</strong> untuk memperbarui nama siswa yang telah tersimpan.</li>
            <li>• Gunakan tombol <strong>Hapus</strong> untuk menghapus data siswa yang tidak diperlukan.</li>
            <li>• Pastikan data siswa yang dimasukkan sudah benar sebelum disimpan.</li>
            <li>• Data siswa yang tersimpan akan digunakan dalam proses pembelajaran dan penilaian pada sistem.</li>
        </ul>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-[#15803d] text-white">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($siswa ?? [] as $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-sm mr-3 border border-brand-200">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>
                                <span class="text-sm  text-gray-900">{{ $item->nama }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('edit', {{ $item->id }}, @js($item->nama))" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-colors" title="Edit Nama Siswa">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <button type="button" onclick="confirmDelete({{ $item->id }})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors" title="Hapus Data">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" action="{{ route('guru.siswa.destroy', $item->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Belum ada data</h3>
                            <p class="mt-1 text-sm text-gray-500">Silakan klik tombol "Tambah Akun Siswa" di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="siswaModal" class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto font-sans">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden z-10 transform transition-all">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-2 text-brand-600">
                <i class="fa-solid fa-user-graduate"></i>
                <h3 class="text-lg font-bold text-gray-900" id="modalTitle">Tambah Akun Siswa Baru</h3>
            </div>

            <button onclick="closeModal()" class="text-gray-400 hover:text-rose-500 transition-colors focus:outline-none">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="siswaForm" action="{{ route('guru.siswa.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="nama" id="inputNama" required class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all" placeholder="Masukkan nama siswa">
                    </div>
                </div>

                <div id="akunFields" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="inputEmail" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all" placeholder="contoh@gmail.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">NISN (Nomor Induk Siswa Nasional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" name="nip_nisn" id="inputNipNisn" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all" placeholder="Masukkan NISN untuk login">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="inputPassword" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 outline-none transition-all" placeholder="Buat kata sandi minimal 6 karakter">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 border border-red-600 rounded-xl hover:bg-red-700 hover:border-red-700 transition-colors shadow-sm focus:outline-none">
                    Batal
                </button>

                <button type="submit" id="btnSubmit"
                    class="px-5 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white text-sm font-bold rounded-xl shadow-lg shadow-green-800/30 transition-all flex items-center gap-2">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // SweetAlert untuk Pesan Sukses
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                customClass: {
                    popup: 'logout-swal-popup',
                    title: 'logout-swal-title',
                    htmlContainer: 'logout-swal-text',
                    confirmButton: 'logout-swal-confirm'
                },
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#15803d',
                confirmButtonText: 'Oke',
                backdrop: 'rgba(15, 23, 42, 0.6)'
            });
        });
    @endif

    // SweetAlert untuk Pesan Error
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                customClass: {
                    popup: 'logout-swal-popup',
                    title: 'logout-swal-title',
                    htmlContainer: 'logout-swal-text',
                    confirmButton: 'logout-swal-confirm'
                },
                title: 'Gagal Menyimpan!',
                text: @json($errors->first()),
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Periksa Lagi',
                backdrop: 'rgba(15, 23, 42, 0.6)'
            });
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            customClass: {
                popup: 'logout-swal-popup',
                title: 'logout-swal-title',
                htmlContainer: 'logout-swal-text',
                confirmButton: 'logout-swal-confirm',
                cancelButton: 'logout-swal-cancel'
            },
            title: 'Konfirmasi Hapus',
            text: 'Akun login dan data nilai siswa ini akan terhapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#15803d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            backdrop: 'rgba(15, 23, 42, 0.6)'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function openModal(action, id = null, nama = '') {
        const modal = document.getElementById('siswaModal');
        const form = document.getElementById('siswaForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmit');
        
        const akunFields = document.getElementById('akunFields');
        const inputEmail = document.getElementById('inputEmail');
        const inputNipNisn = document.getElementById('inputNipNisn');
        const inputPassword = document.getElementById('inputPassword');
        const inputNama = document.getElementById('inputNama');
        
        if (action === 'add') {
            title.innerText = 'Tambah Akun Siswa Baru';
            btnSubmit.innerText = 'Buat Akun & Simpan';
            
            form.action = "{{ route('guru.siswa.store') }}";
            method.value = 'POST';
            
            akunFields.style.display = 'block';
            inputEmail.required = true;
            inputNipNisn.required = true;
            inputPassword.required = true;
            
            inputNama.value = '';
            inputEmail.value = '';
            inputNipNisn.value = '';
            inputPassword.value = '';
        } else if (action === 'edit') {
            title.innerText = 'Edit Nama Siswa';
            btnSubmit.innerText = 'Simpan Perubahan';
            
            form.action = `/guru/siswa/${id}`;
            method.value = 'PUT';
            
            akunFields.style.display = 'none';
            inputEmail.required = false;
            inputNipNisn.required = false;
            inputPassword.required = false;
            
            inputNama.value = nama;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('siswaModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection