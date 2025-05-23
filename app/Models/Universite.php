<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universite extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'acronym', 'address', 'city', 'country'];

    public function ufrs()
    {
        return $this->hasMany(Ufr::class);
    }
}