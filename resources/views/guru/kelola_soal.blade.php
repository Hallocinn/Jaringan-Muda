<!-- resources/views/guru/kelola_soal.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kelola Soal</h2>

    <div class="menu-kelola">
        <a href="{{ route('guru.kuis.index') }}" class="card-menu">
            <h3>Kuis</h3>
            <p>Kelola soal kuis (CRUD & acak)</p>
        </a>

        <a href="{{ route('guru.evaluasi.index') }}" class="card-menu">
            <h3>Evaluasi</h3>
            <p>Kelola soal evaluasi (CRUD & acak)</p>
        </a>
    </div>
</div>
@endsection


<!-- ================= HALAMAN KUIS ================= -->
<!-- resources/views/guru/kuis/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kelola Soal Kuis</h2>

    <a href="{{ route('guru.kuis.create') }}" class="btn btn-primary">Tambah Soal</a>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soal as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->pertanyaan }}</td>
                <td>
                    <a href="{{ route('guru.kuis.edit', $s->id) }}">Edit</a>
                    <form action="{{ route('guru.kuis.destroy', $s->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


<!-- ================= FORM TAMBAH / EDIT ================= -->
<!-- resources/views/guru/kuis/form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($soal) ? 'Edit' : 'Tambah' }} Soal</h2>

    <form action="{{ isset($soal) ? route('guru.kuis.update',$soal->id) : route('guru.kuis.store') }}" method="POST">
        @csrf
        @if(isset($soal)) @method('PUT') @endif

        <label>Pertanyaan</label>
        <textarea name="pertanyaan" required>{{ $soal->pertanyaan ?? '' }}</textarea>

        <label>Pilihan A</label>
        <input type="text" name="a" value="{{ $soal->a ?? '' }}">

        <label>Pilihan B</label>
        <input type="text" name="b" value="{{ $soal->b ?? '' }}">

        <label>Pilihan C</label>
        <input type="text" name="c" value="{{ $soal->c ?? '' }}">

        <label>Pilihan D</label>
        <input type="text" name="d" value="{{ $soal->d ?? '' }}">

        <!-- KUNCI JAWABAN (HANYA DI GURU) -->
        <label>Kunci Jawaban</label>
        <select name="kunci">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select>

        <button type="submit">Simpan</button>
    </form>
</div>
@endsection


<!-- ================= RANDOM SOAL ================= -->
<!-- Controller contoh -->

public function tampilKuis()
{
    $soal = Soal::inRandomOrder()->get(); // ACak soal
    return view('siswa.kuis', compact('soal'));
}


<!-- ================= STRUKTUR DATABASE ================= -->

Schema::create('soal', function (Blueprint $table) {
    $table->id();
    $table->text('pertanyaan');
    $table->string('a');
    $table->string('b');
    $table->string('c');
    $table->string('d');
    $table->string('kunci'); // SIMPAN KUNCI DI DATABASE (KHUSUS GURU)
    $table->enum('tipe', ['kuis','evaluasi']);
    $table->timestamps();
});


<!-- ================= CATATAN SISTEM ================= -->

1. Kunci jawaban hanya ditampilkan di halaman guru (form & edit)
2. Halaman siswa TIDAK BOLEH menampilkan field 'kunci'
3. Random soal menggunakan inRandomOrder()
4. CRUD lengkap: create, read, update, delete di halaman guru
5. Bisa dipisah controller: KuisController & EvaluasiController
