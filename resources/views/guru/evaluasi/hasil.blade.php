@extends('layouts.guru')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Hasil Evaluasi Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar nilai akhir siswa khusus untuk soal Evaluasi (KKM: {{ $kkm }}).</p>
        </div>
        
        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
            <button onclick="exportExcel()"
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 bg-[#15803d] hover:bg-[#14532d] text-white font-semibold text-sm rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none">
                <i class="fa-solid fa-download mr-2"></i>
                Unduh Data
            </button>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6 shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i class="fa-solid fa-circle-info text-[#15803d] text-lg"></i>
        <h3 class="font-bold text-[#14532d]">
            Petunjuk Hasil Evaluasi
        </h3>
    </div>
        <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <li>• Hasil evaluasi menampilkan nilai yang diperoleh setiap siswa setelah mengerjakan evaluasi.</li>
            <li>• Sistem menggunakan KKM 75 sebagai batas ketuntasan belajar.</li>
            <li>• Siswa yang memperoleh nilai 75 atau lebih dinyatakan <strong>Tuntas</strong>.</li>
            <li>• Siswa yang memperoleh nilai di bawah 75 akan mendapatkan keterangan <strong>Belum Tuntas</strong>.</li>
            <li>• Guru dapat menggunakan hasil evaluasi untuk memantau tingkat pencapaian belajar siswa.</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10" id="printableArea">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left" id="evaluasiTable">
                <thead class="bg-[#15803d] text-white">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider w-32">Nilai Evaluasi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider w-40">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($siswas as $s)
                        @php
                            // Ambil skor evaluasi khusus
                            $nilaiEvaluasi = $s->ambilSkor('evaluasi');
                            $isLulus = $nilaiEvaluasi >= $kkm;
                        @endphp
                        
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                                {{ $loop->iteration }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-900">{{ $s->nama }}</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-black {{ $isLulus ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $nilaiEvaluasi }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($isLulus)
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-check mr-1.5 mt-0.5"></i> TUNTAS
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-lg bg-rose-100 text-rose-700 border border-rose-200">
                                        <i class="fa-solid fa-xmark mr-1.5 mt-0.5"></i> BELUM TUNTAS
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                    <i class="fa-solid fa-medal text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Belum ada hasil evaluasi</h3>
                                <p class="mt-1 text-sm text-gray-500">Nilai akan muncul setelah siswa mengerjakan evaluasi akhir.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const hasDataEvaluasi = @json(count($siswas) > 0);

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

    function exportPDF() {
        if (!hasDataEvaluasi) {
            Swal.fire({
                ...swalConfig,
                title: 'Data Kosong!',
                text: 'Belum ada hasil evaluasi yang dapat diunduh.',
                icon: 'warning',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });

            return;
        }

        Swal.fire({
            ...swalConfig,
            title: 'Unduh Data PDF?',
            text: 'Data hasil evaluasi siswa akan diunduh dalam format PDF.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Unduh',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                doc.setFontSize(16);
                doc.setFont('helvetica', 'bold');
                doc.text('Laporan Hasil Evaluasi Siswa - BELAJAR.ID', 14, 20);

                const table = document.getElementById('evaluasiTable');
                
                doc.autoTable({
                    html: table,
                    startY: 30,
                    theme: 'grid',
                    headStyles: { 
                        fillColor: [21, 128, 61],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center'
                    },
                    columnStyles: {
                        0: { halign: 'center' }, 
                        1: { halign: 'left', fontStyle: 'bold' },
                        2: { halign: 'center', fontStyle: 'bold' },
                        3: { halign: 'center' } 
                    },
                    styles: {
                        font: 'helvetica',
                        fontSize: 10
                    }
                });

                doc.save('Hasil_Evaluasi_Siswa.pdf');

                Swal.fire({
                    ...swalConfig,
                    title: 'Berhasil!',
                    text: 'Data hasil evaluasi berhasil diunduh.',
                    icon: 'success',
                    confirmButtonColor: '#15803d',
                    confirmButtonText: 'Oke'
                });
            }
        });
    }

    function exportExcel() {
        if (!hasDataEvaluasi) {
            Swal.fire({
                ...swalConfig,
                title: 'Data Kosong!',
                text: 'Belum ada hasil evaluasi yang dapat diunduh.',
                icon: 'warning',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });

            return;
        }

        Swal.fire({
            ...swalConfig,
            title: 'Unduh Data Hasil Evaluasi?',
            text: 'Data hasil evaluasi siswa akan diunduh dalam format Excel.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Unduh',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const wb = XLSX.utils.book_new();
                const table = document.getElementById('evaluasiTable');
                const ws = XLSX.utils.table_to_sheet(table);

                XLSX.utils.book_append_sheet(wb, ws, 'Hasil Evaluasi');
                XLSX.writeFile(wb, 'Hasil_Evaluasi_Siswa.xlsx');

                Swal.fire({
                    ...swalConfig,
                    title: 'Berhasil!',
                    text: 'Data hasil evaluasi berhasil diunduh.',
                    icon: 'success',
                    confirmButtonColor: '#15803d',
                    confirmButtonText: 'Oke'
                });
            }
        });
    }
</script>
@endsection