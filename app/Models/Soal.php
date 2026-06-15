<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi kecuali id
    protected $guarded = ['id'];

    // Relasi: Soal ini milik sebuah Kuis (Balikan)
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }
}