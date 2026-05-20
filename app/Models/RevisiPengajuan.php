<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisiPengajuan extends Model
{
    protected $guarded = ['id'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanUkm::class, 'pengajuan_ukm_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
