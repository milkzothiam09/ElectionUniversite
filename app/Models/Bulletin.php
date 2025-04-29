<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = ['election_id', 'user_id', 'choix', 'date_vote'];
    protected $casts = ['id' => 'string', 'date_vote' => 'datetime'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function votant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estValide()
    {
        return $this->choix === 'pour';
    }

    public function estNul()
    {
        return $this->choix === 'null';
    }
}
