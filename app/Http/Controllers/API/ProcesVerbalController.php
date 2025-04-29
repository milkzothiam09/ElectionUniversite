<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcesVerbal;
use App\Models\Election;

class ProcesVerbalController extends Controller
{
    public function generer($electionId)
    {
        $election = Election::findOrFail($electionId);
        $pv = ProcesVerbal::create([
            'election_id' => $election->id,
            'date_generation' => now()
        ]);
        
        $pv->genererContenu();
        
        return response()->json($pv);
    }

    public function telecharger($id)
    {
        $pv = ProcesVerbal::findOrFail($id);
        return $pv->exporterPDF();
    }
}
