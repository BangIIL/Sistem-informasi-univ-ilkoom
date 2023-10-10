<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\View\View;

class PencarianController extends Controller
{
    public function index(): View
    {
      return view('pencarian');
    }

    public function proses(Request $request): View
    {

      if ($request->kategori == 'dosen') {
          $result = Dosen::where('nama','LIKE','%'.$request->s.'%')
                    ->orderBy('nama')->paginate(10);
      }

      if ($request->kategori == 'mahasiswa') {
          $result = Mahasiswa::where('nama','LIKE','%'.$request->s.'%')
                    ->orderBy('nama')->paginate(10);
      }

      if ($request->kategori == 'matakuliah') {
          $result = Matakuliah::where('nama','LIKE','%'.$request->s.'%')
                    ->orderBy('nama')->paginate(10);
      }

	  return view('pencarian',[
          'result' => $result,
          'kategori' => $request->kategori,
          's' => $request->s,
          ]);
    }
}
