<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Matakuliah;
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

    public function ambilMataKuliah(Mahasiswa $mahasiswa): View
    {
        // Ambil semua daftar mata kuliah dari jurusan yang sama dengan mahasiswa
        $matakuliahs = Matakuliah::where('jurusan_id',$mahasiswa->jurusan_id)->orderBy('nama')->get();
        // Buat array dari daftar jurusan yang sudah di ambil mahasiswa
        // Ini akan dipakai untuk proses repopulate form
        $matakuliahs_sudah_diambil=$mahasiswa->matakuliahs->pluck('id')->all();

        return view('mahasiswa.ambil-matakuliah',[
            'mahasiswa' => $mahasiswa,
            'matakuliahs' => $matakuliahs,
            'matakuliahs_sudah_diambil' => $matakuliahs_sudah_diambil,
        ]);
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

    public function prosesAmbilMatakuliah(Request $request, Mahasiswa $mahasiswa)
    {
        // Ambil semua id matakuliah untuk jurusan yang sama dengan mahasiswa.
        $matakuliah_jurusan=Matakuliah::where('jurusan_id',$mahasiswa->jurusan_id)->pluck('id')->toArray();

        $validateData = $request->validate(['matakuliah.*' => 'distinct|in:'.implode(',',$matakuliah_jurusan),]);

        // Input ke database
        $mahasiswa->matakuliahs()->sync($validateData['matakuliah'] ?? []);
        Alert::success('Berhasil', "Terdapat ".count($validateData['matakuliah'] ?? [])." mata kuliah yang diambil $mahasiswa->nama");
        return redirect(route('mahasiswas.show',['mahasiswa' => $mahasiswa->id]));
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
    public function edit(Mahasiswa $mahasiswa): View
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        return view('mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'jurusans' => $jurusans,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa):RedirectResponse
    {
        $validateData = $request->validate([
            'nim' => 'required|alpha_num|size:8|unique:mahasiswas,nim,' .$mahasiswa->id,
            'nama' => 'required',
            'jurusan_id' => 'required|exists:App\Models\Jurusan,id',
        ]);

        // Antipasi jika ada yang edit inputan jurusan_id yang sudah di hidden
        if (($mahasiswa->matakuliahs()->count() >0) AND ($mahasiswa->jurusan_id != $request->jurusan_id)) {
            Alert::error('Update gagal', "Jurusan tidak bisa diubah!");
            return back()->withInput();
        }

        $mahasiswa->update($validateData);
        Alert::success('Berhasil', "Mahasiswa $request->nama telah di update");
        // Trik agar halaman kembali ke halaman asal
        return redirect($request->url_asal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
