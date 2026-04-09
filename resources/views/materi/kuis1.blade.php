@extends('layouts.app')

@section('content')
<div class="materi-container">
    <h2>Kuis Materi 1</h2>

    <form>
        <p>1. Jaringan yang menyebabkan pertumbuhan panjang adalah...</p>
        <input type="radio" name="q1"> Epidermis <br>
        <input type="radio" name="q1"> Meristem Apikal <br>
        <input type="radio" name="q1"> Parenkim <br><br>

        <button type="submit" class="btn-kuis">Kumpulkan</button>
    </form>
</div>
@endsection