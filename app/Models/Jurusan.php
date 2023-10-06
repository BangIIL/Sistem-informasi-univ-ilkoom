<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;
    protected $fillable = ['nama','kepala_jurusan','daya_tampung'];

    public function dosens(): HasMany{
        return $this->hasMany('App\Models\Dosen');
    }

    public function mahasiswas(): HasMany{
        return $this->hasMany('App\Models\Mahasiswa');
    }

    public function matakuliahs(): HasMany{
        return $this->hasMany('App\Models\Matakuliah');
    }
}
