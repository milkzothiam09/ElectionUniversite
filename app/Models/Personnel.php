<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Personnel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'personnel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'email',
        'motDePasse',
        'type',
        'grades_id',
        'departements_id',
        'ufrs_id',
    ];

    protected $hidden = [
        'motDePasse',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    // Relations
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function ufr()
    {
        return $this->belongsTo(Ufr::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidat::class);
    }

    // Méthodes
    public function voter(Election $election, Candidat $candidat)
    {
        if (!$this->verifierDroitVote($election)) {
            throw new \Exception("Ce personnel n'a pas le droit de voter dans cette élection.");
        }

        // Logique pour enregistrer le vote
        $vote = new Vote([
            'elections_id' => $election->id,
            'personnel_id' => $this->id,
            'candidats_id' => $candidat->id,
        ]);

        return $vote->save();
    }

    public function seCandidater(Election $election)
    {
        if ($this->type !== 'PER') {
            throw new \Exception("Seuls les PER peuvent se porter candidats.");
        }

        if (!$election->estOuverte()) {
            throw new \Exception("Les candidatures ne sont pas ouvertes pour cette élection.");
        }

        // Vérifier si déjà candidat
        if ($this->candidatures()->where('election_id', $election->id)->exists()) {
            throw new \Exception("Vous êtes déjà candidat à cette élection.");
        }

        // Créer la candidature
        $candidat = new Candidat([
            'personnel_id' => $this->id,
            'elections_id' => $election->id,
            'date_candidature' => now(),
        ]);

        return $candidat->save();
    }

    public function verifierDroitVote(Election $election)
    {
        // Vérifie si l'élection est ouverte
        if (!$election->estOuverte()) {
            return false;
        }

        // Vérifie si le personnel a déjà voté
        if ($election->aDejaVote($this)) {
            return false;
        }

        // Vérifie si le personnel est éligible (selon les règles de l'élection)
        return $election->estEligible($this);
    }
}
