<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ukm()
    {
        return $this->belongsTo(Ukm::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }

    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class);
    }
}