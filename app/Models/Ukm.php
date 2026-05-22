<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}