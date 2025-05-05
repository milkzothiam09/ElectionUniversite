<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resultat;
use App\Models\Election;
use App\Models\Candidat;
use App\Models\Vote;
use Carbon\Carbon;

class ResultatController extends Controller
{
    public function calculateResults($electionId)
    {
        $election = Election::findOrFail($electionId);

        // Vérifier que l'élection est terminée
        if (Carbon::now() < $election->end_date) {
            return response()->json(['message' => 'L\'élection n\'est pas encore terminée'], 403);
        }

        // Supprimer les anciens résultats
        Resultat::where('elections_id', $electionId)->delete();

        // Calculer les votes par candidat
        $votesByCandidate = Vote::where('elections_id', $electionId)
            ->where('is_null', false)
            ->selectRaw('candidats_id, count(*) as votes_count')
            ->groupBy('candidats_id')
            ->get();

        // Enregistrer les résultats
        foreach ($votesByCandidate as $vote) {
            Resultat::create([
                'elections_id' => $electionId,
                'candidats_id' => $vote->candidats_id,
                'votes_count' => $vote->votes_count,
            ]);
        }

        // Compter les votes nuls
        $nullVotesCount = Vote::where('elections_id', $electionId)
            ->where('is_null', true)
            ->count();

        if ($nullVotesCount > 0) {
            Resultat::create([
                'elections_id' => $electionId,
                'candidats_id' => null,
                'votes_count' => $nullVotesCount,
            ]);
        }

        // Mettre à jour le statut de l'élection
        $election->update(['status' => 'Fermée!!!']);

        $results = Resultat::where('election_id', $electionId)
            ->with(['candidate.user'])
            ->get();

        return response()->json($results);
    }

    public function getResults($electionId)
    {
        $results = Resultat::where('elections_id', $electionId)
            ->with(['candidate.user'])
            ->orderBy('votes_count', 'desc')
            ->get();

        return response()->json($results);
    }

    public function generatePV($electionId)
    {
        $election = Election::with(['departement', 'ufr'])->findOrFail($electionId);
        $results = Resultat::where('elections_id', $electionId)
            ->with(['candidate.user'])
            ->orderBy('votes_count', 'desc')
            ->get();

        $totalVotes = $results->sum('votes_count');

        $pv = [
            'election' => $election,
            'resultats' => $results,
            'total_votes' => $totalVotes,
            'date' => now()->format('d/m/Y H:i'),
        ];

        return response()->json($pv);
    }
}
