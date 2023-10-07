@extends('layouts.app')
@section('content')

<div class="pt-3">
    <h1 class="h2">Tambah Dosen</h1>

    <form action="{{ route('dosens.store') }}" method="post">
        @include('dosen.form', ['tombol' => 'Tambah'])
    </form>
</div>
@endsection
