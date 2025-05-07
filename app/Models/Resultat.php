<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'elections_id',
        'candidats_id',
        'votes_count'
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