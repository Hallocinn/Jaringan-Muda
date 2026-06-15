<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;

class SoalEvaluasiSeeder extends Seeder
{
    public function run()
    {
        $data = [

            // 1 - 10 (C1)
            ['pertanyaan'=>'Jaringan pada tumbuhan yang sel-selnya aktif membelah disebut …','a'=>'Jaringan meristem','b'=>'Jaringan epidermis','c'=>'Jaringan pengangkut','d'=>'Jaringan parenkim','kunci'=>'A','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Meristem yang terdapat di ujung batang dan ujung akar disebut …','a'=>'Meristem lateral','b'=>'Meristem apikal','c'=>'Meristem interkalar','d'=>'Meristem sekunder','kunci'=>'B','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Meristem yang terletak di sisi batang dan akar adalah …','a'=>'Meristem apikal','b'=>'Meristem interkalar','c'=>'Meristem lateral','d'=>'Meristem primer','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Meristem interkalar biasanya terdapat pada bagian …','a'=>'Pangkal ruas batang','b'=>'Ujung akar','c'=>'Daun tua','d'=>'Kulit batang','kunci'=>'A','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Contoh jaringan meristem lateral adalah …','a'=>'Epidermis','b'=>'Kambium','c'=>'Parenkim','d'=>'Korteks','kunci'=>'B','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Xilem berfungsi untuk …','a'=>'Mengangkut hasil fotosintesis','b'=>'Melindungi tumbuhan','c'=>'Mengangkut air dan mineral','d'=>'Menyimpan cadangan makanan','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Floem berfungsi untuk …','a'=>'Menyerap air dari tanah','b'=>'Mengangkut hasil fotosintesis','c'=>'Melindungi batang','d'=>'Menyimpan makanan','kunci'=>'B','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Pertumbuhan yang menyebabkan tumbuhan bertambah panjang disebut …','a'=>'Pertumbuhan sekunder','b'=>'Pertumbuhan vegetatif','c'=>'Pertumbuhan primer','d'=>'Pertumbuhan generatif','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Tumbuhan yang banyak memiliki meristem interkalar adalah …','a'=>'Jagung','b'=>'Mangga','c'=>'Jati','d'=>'Mahoni','kunci'=>'A','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Sel meristem memiliki ciri utama yaitu …','a'=>'Sel besar dan tebal','b'=>'Sel tidak aktif membelah','c'=>'Sel tua dan kaku','d'=>'Sel kecil dan aktif membelah','kunci'=>'D','tipe_soal'=>'pg','kategori'=>'evaluasi'],

            // 11 - 15 (C2)
            ['pertanyaan'=>'Fungsi utama meristem apikal adalah …','a'=>'Menambah diameter batang','b'=>'Membantu penyerapan air','c'=>'Membentuk jaringan pelindung','d'=>'Menyebabkan tumbuhan bertambah panjang','kunci'=>'D','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Meristem lateral berperan dalam proses …','a'=>'Pertumbuhan sekunder','b'=>'Pembentukan daun','c'=>'Penyerapan air','d'=>'Fotosintesis','kunci'=>'A','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Meristem interkalar membantu tumbuhan untuk …','a'=>'Menyerap air dari tanah','b'=>'Menyimpan cadangan makanan','c'=>'Tumbuh kembali setelah dipotong','d'=>'Menghasilkan bunga','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Xilem dan floem dihasilkan oleh aktivitas …','a'=>'Meristem apikal','b'=>'Kambium vaskular','c'=>'Meristem interkalar','d'=>'Epidermis','kunci'=>'B','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Batang pohon yang semakin besar terjadi karena aktivitas …','a'=>'Meristem interkalar','b'=>'Meristem apikal','c'=>'Meristem lateral','d'=>'Jaringan epidermis','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],

            // 16 - 20 (C4)
            ['pertanyaan'=>'Seorang siswa mengamati tanaman yang semakin tinggi setiap minggu. Pertumbuhan tersebut terjadi karena aktivitas …','a'=>'Meristem apikal','b'=>'Meristem lateral','c'=>'Meristem interkalar','d'=>'Jaringan epidermis','kunci'=>'A','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Batang pohon mangga semakin besar seiring bertambahnya usia tanaman. Hal ini menunjukkan adanya aktivitas …','a'=>'Meristem apikal','b'=>'Meristem interkalar','c'=>'Meristem lateral','d'=>'Jaringan parenkim','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Tanaman padi dipotong pada bagian batangnya, tetapi beberapa hari kemudian tumbuh kembali. Hal ini menunjukkan peran …','a'=>'Meristem apikal','b'=>'Meristem lateral','c'=>'Meristem interkalar','d'=>'Jaringan pengangkut','kunci'=>'C','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Jika aktivitas kambium meningkat, maka yang kemungkinan terjadi adalah …','a'=>'Tanaman bertambah tinggi','b'=>'Batang tanaman bertambah besar','c'=>'Daun menjadi lebih hijau','d'=>'Akar menyerap air lebih cepat','kunci'=>'B','tipe_soal'=>'pg','kategori'=>'evaluasi'],
            ['pertanyaan'=>'Jika meristem apikal pada ujung batang rusak, maka kemungkinan yang terjadi adalah …','a'=>'Batang semakin tebal','b'=>'Tanaman lebih cepat berbunga','c'=>'Tanaman tidak dapat bertambah tinggi','d'=>'Akar tidak dapat menyerap air','kunci'=>'D','tipe_soal'=>'pg','kategori'=>'evaluasi'],

        ];
        Soal::insert($data);
    }
}