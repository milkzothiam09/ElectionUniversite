<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ufr extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'universites_id'];

    public function university()
    {
        return $this->belongsTo(Universite::class);
    }

    public function departments()
    {
        return $this->hasMany(Departement::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function elections()
    {
        return $this->hasMany(Election::class);
    }
}