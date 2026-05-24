<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'ukm_id',
        'judul',
        'konten',
        'tanggal_kegiatan',
    ];

    public function ukm()
    {
        return $this->belongsTo(Ukm::class);
    }
}
