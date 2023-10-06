@extends('layouts.app')

@section('content')
<h1 class="display-4 text-center my-5">Sistem Informasi Universitas ILKOOM</h1>

<div class="text-end pt-5 pb-4">
    @auth
        <a href="{{ route('jurusans.create') }}" class="btn btn-info">
            Tambah Juruasan</a>
    @endauth
</div>

<div class="row row-cols-1 rows-cols-md-2 row-cols-xl-3 g-4">
    @foreach ($jurusans as $jurusan )


    <div class="col" id= card- {{ $jurusan->id }}>
        <div class="card h-100">
            <div class="card-body text-center">
                <h3 class="card-title py-1">{{ $jurusan->nama }}</h3>
                <hr>

                <div class="card-text py-1">Kepala Jurusan:
                    <b>{{ $jurusan->kepala_jurusan }}</b></div>
                <div class="card-text pb-4">Total Mahasiswa: {{ $jurusan->mahasiswas_count }}
                    (daya tampung {{ $jurusan->daya_tampung }})</div>
                <a href="{{ route('jurusan-dosen', ['jurusan_id' => $jurusan->id]) }}"
                    class="btn btn-info d-block">Dosen</a>
                <a href="{{ route('jurusan-mahasiswa', ['jurusan_id' => $jurusan->id]) }}"
                    class="btn btn-success d-block mt-2">Mahasiswa</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
