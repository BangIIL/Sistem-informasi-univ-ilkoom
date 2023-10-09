<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\RedirectResponse;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jurusans = Jurusan::withCount('mahasiswas')->orderBy('nama')->get();
        return view('jurusan.index', ['jurusans' => $jurusans]);
    }

    public function jurusanDosen($jurusan_id): View
    {
        $dosens = Dosen::where('jurusan_id', $jurusan_id)->orderBy('nama')->paginate(5);
        $nama_jurusan = Jurusan::find($jurusan_id)->nama;

        return view('dosen.index',[
            'dosens' => $dosens,
            'nama_jurusan' => $nama_jurusan,
        ]);
    }

    public function jurusanMahasiswa($jurusan_id): View
    {
        $mahasiswas = Mahasiswa::where('jurusan_id', $jurusan_id)->orderBy('nama')->paginate(5);
        $nama_jurusan = Jurusan::find($jurusan_id)->nama;

        return view('mahasiswa.index',[
            'mahasiswas' => $mahasiswas,
            'nama_jurusan' => $nama_jurusan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'kepala_jurusan' => 'required',
            'daya_tampung' => 'required|min:10|integer',
        ]);
        $jurusan = Jurusan::create($validateData);
        Alert::success('Berhasil', "Jurusan $request->nama berhasil dibuat");
        return redirect("/jurusans#card-{$jurusan->id}");
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan): View
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan): RedirectResponse
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'kepala_jurusan' => 'required',
            'daya_tampung' => 'required|min:10|integer',
        ]);

        $jurusan->update($validateData);
        Alert::success('Berhasil', "Jurusan $request->nama telah di update");
        return redirect("/jurusans#card-{$jurusan->id}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        //
    }
}
