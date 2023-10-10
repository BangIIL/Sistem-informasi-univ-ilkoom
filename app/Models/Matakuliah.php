<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matakuliah extends Model
{
    use HasFactory;
    protected $fillable = ['kode','nama','jurusan_id','dosen_id','jumlah_sks'];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo('App\Models\Jurusan');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo('App\Models\Dosen');
    }

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Mahasiswa')->withTimestamps();
    }
}
