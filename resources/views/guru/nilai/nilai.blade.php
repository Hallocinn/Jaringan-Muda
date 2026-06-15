@extends('layouts.guru')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Nilai Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Monitoring nilai kuis dan evaluasi siswa secara keseluruhan.</p>
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
                Petunjuk Rekap Nilai
            </h3>
        </div>

        <ul class="space-y-2 text-sm text-gray-700 leading-relaxed">
            <li>• Rekap nilai menampilkan hasil belajar setiap siswa secara lengkap.</li>
            <li>• Data yang ditampilkan meliputi nilai Kuis 1, Kuis 2, Kuis 3, Evaluasi, dan nilai rata-rata.</li>
            <li>• Guru dapat melihat perkembangan hasil belajar siswa melalui tabel rekap nilai.</li>
            <li>• Pastikan seluruh penilaian telah selesai dikerjakan agar data yang ditampilkan lengkap.</li>
            <li>• Rekap nilai dapat diunduh untuk keperluan dokumentasi dan pelaporan hasil belajar.</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10" id="printableArea">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left" id="nilaiTable">
                <thead class="bg-[#15803d] text-white">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider w-16">
                            No
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">
                            Nama Siswa
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                            Kuis 1
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                            Kuis 2
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                            Kuis 3
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                            Evaluasi
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                            Rata-rata
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($siswas as $s)
                        @php
                            $k1 = $s->ambilSkor('kuis1');
                            $k2 = $s->ambilSkor('kuis2');
                            $k3 = $s->ambilSkor('kuis3');
                            $ev = $s->ambilSkor('evaluasi');

                            $rata = ($k1 + $k2 + $k3 + $ev) / 4;
                        @endphp
                        
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm text-gray-700">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $s->nama }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-amber-100 text-amber-700 border border-amber-200 min-w-[40px] justify-center">
                                    {{ $k1 }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-amber-100 text-amber-700 border border-amber-200 min-w-[40px] justify-center">
                                    {{ $k2 }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-amber-100 text-amber-700 border border-amber-200 min-w-[40px] justify-center">
                                    {{ $k3 }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200 min-w-[40px] justify-center">
                                    {{ $ev }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-black text-[#15803d]">
                                    {{ number_format($rata, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                    <i class="fa-solid fa-chart-pie text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Belum ada data nilai</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Nilai akan otomatis terisi setelah siswa mengerjakan kuis atau evaluasi.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const hasDataNilai = @json(count($siswas) > 0);

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
        if (!hasDataNilai) {
            Swal.fire({
                ...swalConfig,
                title: 'Data Kosong!',
                text: 'Belum ada data nilai yang dapat diunduh.',
                icon: 'warning',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });

            return;
        }

        Swal.fire({
            ...swalConfig,
            title: 'Unduh Data PDF?',
            text: 'Data rekap nilai siswa akan diunduh dalam format PDF.',
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
                doc.text('Laporan Rekap Nilai Siswa - BELAJAR.ID', 14, 20);

                const table = document.getElementById('nilaiTable');
                
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
                        0: { halign: 'center', fontStyle: 'bold' },
                        1: { halign: 'left', fontStyle: 'bold' },
                        2: { halign: 'center' },
                        3: { halign: 'center' },
                        4: { halign: 'center' },
                        5: { halign: 'center' },
                        6: { halign: 'center', fontStyle: 'bold', textColor: [21, 128, 61] }
                    },
                    styles: { 
                        font: 'helvetica', 
                        fontSize: 10 
                    }
                });

                doc.save('Rekap_Nilai_Siswa.pdf');

                Swal.fire({
                    ...swalConfig,
                    title: 'Berhasil!',
                    text: 'Data rekap nilai berhasil diunduh.',
                    icon: 'success',
                    confirmButtonColor: '#15803d',
                    confirmButtonText: 'Oke'
                });
            }
        });
    }

    function exportExcel() {
        if (!hasDataNilai) {
            Swal.fire({
                ...swalConfig,
                title: 'Data Kosong!',
                text: 'Belum ada data nilai yang dapat diunduh.',
                icon: 'warning',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke'
            });

            return;
        }

        Swal.fire({
            ...swalConfig,
            title: 'Unduh Data Rekap Nilai?',
            text: 'Data rekap nilai siswa akan diunduh dalam format Excel.',
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
                const table = document.getElementById('nilaiTable');
                const ws = XLSX.utils.table_to_sheet(table);

                XLSX.utils.book_append_sheet(wb, ws, "Rekap Nilai");
                XLSX.writeFile(wb, 'Data_Rekap_Nilai_Siswa.xlsx');

                Swal.fire({
                    ...swalConfig,
                    title: 'Berhasil!',
                    text: 'Data rekap nilai berhasil diunduh.',
                    icon: 'success',
                    confirmButtonColor: '#15803d',
                    confirmButtonText: 'Oke'
                });
            }
        });
    }
</script>
@endsection