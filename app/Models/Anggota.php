<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $guarded = ['id'];

    public function ukm()
    {
        return $this->belongsTo(Ukm::class);
    }
}
