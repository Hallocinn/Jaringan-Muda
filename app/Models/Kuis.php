<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: 1 Kuis punya banyak Soal
    public function soals()
    {
        return $this->hasMany(Soal::class);
    }
}