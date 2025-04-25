<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'candidature_start',
        'candidature_end',
        'status',
        'departement_id',
        'ufr_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'candidature_start' => 'datetime',
        'candidature_end' => 'datetime'
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function ufr()
    {
        return $this->belongsTo(Ufr::class);
    }

    public function candidats()
    {
        return $this->hasMany(Candidat::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }
}