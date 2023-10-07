<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ['nim','nama','jurusan_id'];

    public function jurusan(): BelongsTo{
        return $this->belongsTo('App\Models\Jurusan');
    }

    public function matakuliahs(): BelongsToMany{
        return $this->belongsToMany('App\Models\Matakuliah')->withTimestamps();
    }
}
