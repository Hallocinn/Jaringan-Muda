<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Hapus 'kelas' dari sini
    protected $fillable = ['nama', 'nilai'];

    public function nilais() {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function ambilSkor($jenis) {
        $data = $this->nilais->firstWhere('jenis', $jenis);
        return $data ? $data->nilai : 0;
    }

    public function hitungRataRata() {
        $total = $this->ambilSkor('kuis1') + 
                 $this->ambilSkor('kuis2') + 
                 $this->ambilSkor('kuis3') + 
                 $this->ambilSkor('evaluasi');
        return number_format($total / 4, 1);
    }
}