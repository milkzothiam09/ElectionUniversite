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
        'grade_id',
        'departement_id',
        'ufr_id'
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
        return $this->hasMany(Vote::class, 'voter_hash', 'voter_hash');
    }
}