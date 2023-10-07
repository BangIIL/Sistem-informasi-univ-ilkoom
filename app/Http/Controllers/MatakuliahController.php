<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Jurusan;
Use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;


class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $matakuliahs = Matakuliah::with('dosen', 'jurusan')->orderBy('nama')->paginate(10);
        return view('matakuliah.index', ['matakuliahs' => $matakuliahs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();
        return view('matakuliah.create', [
            'jurusans' => $jurusans,
            'dosens' => $dosens,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'kode' => 'required|alpha_num|size:5|unique:matakuliahs,kode',
            'nama' => 'required',
            'dosen_id' => 'required|exists:App\Models\Dosen,id',
            'jurusan_id' => 'required|exists:App\Models\Jurusan,id',
            'jumlah_sks' => 'required|digits_between:1,6',
        ]);

        Matakuliah::create($validateData);
        Alert::success('Berhasil', "Mata Kuliah $request->nama berhasil dibuat");
        return redirect($request->url_asal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matakuliah $matakuliah): View
    {
        $mahasiswas = $matakuliah->mahasiswas->sortBy('nama');
        return view('matakuliah.show',[
            'matakuliah' => $matakuliah,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matakuliah $matakuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matakuliah $matakuliah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        //
    }
}
