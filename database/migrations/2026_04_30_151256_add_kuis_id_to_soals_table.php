<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->foreignId('kuis_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropForeign(['kuis_id']); // hapus relasi
            $table->dropColumn('kuis_id');    // hapus kolom
        });
    }
};