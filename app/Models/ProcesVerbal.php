<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcesVerbal extends Model
{
    use HasFactory;

    protected $fillable = ['elections_id', 'contenu', 'date_generation'];
    protected $casts = ['id' => 'string', 'date_generation' => 'datetime'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function genererContenu()
    {
        $this->contenu = "Procès-verbal de l'élection: ".$this->election->title."\n\n";

        // Générer du contenu
        $this->save();
    }

    public function exporterPDF()
    {
        echo Pdf::loadView('pdf.proces-verbal', ['pv' => $this])
            ->stream('proces-verbal-'.$this->election->id.'.pdf');
    }
}

