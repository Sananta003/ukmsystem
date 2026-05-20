<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanUkm extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function revisis()
    {
        return $this->hasMany(RevisiPengajuan::class, 'pengajuan_ukm_id')->latest();
    }
}
