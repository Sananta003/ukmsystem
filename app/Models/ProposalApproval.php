<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalApproval extends Model
{
    protected $guarded = ['id'];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
