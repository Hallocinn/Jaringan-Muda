<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemahaman extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel tidak salah menebak nama tabel!
    protected $table = 'pemahamans';

    protected $fillable = [
        'user_id', 
        'materi_slug', 
        'jawaban', 
        'kesimpulan', 
        'nilai', 
        'feedback'
    ];

    // Relasi untuk menarik nama siswa dari tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}