<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    use HasFactory;
    protected $fillable = ['nid','nama','jurusan_id'];

    public function matakuliahs(): HasMany
    {
        return $this->hasMany('App\Models\Matakuliah');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo('App\Models\Jurusan');
    }
}
