<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'elections_id',
        'candidats_id',
        'voter_hash',
        'is_null'
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function candidats()
    {
        return $this->belongsTo(Candidat::class);
    }
}