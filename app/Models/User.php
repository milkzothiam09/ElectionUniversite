<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'grades_id',
        'departements_id',
        'ufrs_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class)->withDefault([
            'name' => 'Non attribué'
        ]);;
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
        return $this->hasMany(Vote::class, 'voter_hash', 'voter_hash');
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }

    public function voter(Election $election, $candidatId = null)
    {
        if (!$this->verifierDroitVote($election)) {
            throw new \Exception("Droit de vote non autorisé");
        }

        return Bulletin::create([
            'elections_id' => $election->id,
            'users_id' => $this->id,
            'choix' => $candidatId ? 'pour' : 'null',
            'date_vote' => now()
        ]);
    }

    public function verifierDroitVote(Election $election)
    {
        if ($this->type === 'PER') {
            return $this->departement_id === $election->departement_id;
            
        } elseif ($this->type === 'PATS') {
            return $this->ufr_id === $election->ufr_id;
        }

        return false;
    }

}
