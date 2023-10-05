<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;


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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
