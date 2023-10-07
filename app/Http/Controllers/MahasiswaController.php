<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $mahasiswas = Mahasiswa::with('jurusan')->orderBy('nama')->paginate(10);
        return view('mahasiswa.index', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        return view('mahasiswa.create',compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'nim' => 'required|alpha_num|size:8|unique:mahasiswas,nim',
            'nama' => 'required',
            'jurusan_id' => 'required|exists:App\Models\Jurusan,id',
        ]);

        // Cek apakah daya tampung jurusan masih belum penug
        $daya_tampung = Jurusan::find($request->jurusan_id)->daya_tampung;
        $total_mahasiswa = Mahasiswa::where('jurusan_id', $request->jurusan_id)->count();

        if($total_mahasiswa >= $daya_tampung){
            Alert::error('Pendaftaran Gagal', 'Sudah melebihi daya tampung jurusan');
            return back()->withInput();
        }

        Mahasiswa::create($validateData);
        ALert::success('Berhasil', "Mahasiswa $request->nama berhasil dibuat");
        return redirect($request->url_asal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa) :View
    {
        $matakuliahs = $mahasiswa->matakuliahs->sortBy('nama');
        return view('mahasiswa.show',[
            'mahasiswa' => $mahasiswa,
            'matakuliahs' => $matakuliahs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
