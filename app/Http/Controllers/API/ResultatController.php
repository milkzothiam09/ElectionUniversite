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
        Resultat::where('election_id', $electionId)->delete();

        // Calculer les votes par candidat
        $votesByCandidate = Vote::where('election_id', $electionId)
            ->where('is_null', false)
            ->selectRaw('candidate_id, count(*) as votes_count')
            ->groupBy('candidat_id')
            ->get();

        // Enregistrer les résultats
        foreach ($votesByCandidate as $vote) {
            Resultat::create([
                'election_id' => $electionId,
                'candidate_id' => $vote->candidate_id,
                'votes_count' => $vote->votes_count,
            ]);
        }

        // Compter les votes nuls
        $nullVotesCount = Vote::where('election_id', $electionId)
            ->where('is_null', true)
            ->count();

        if ($nullVotesCount > 0) {
            Resultat::create([
                'election_id' => $electionId,
                'candidat_id' => null,
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
        $results = Resultat::where('election_id', $electionId)
            ->with(['candidate.user'])
            ->orderBy('votes_count', 'desc')
            ->get();

        return response()->json($results);
    }

    public function generatePV($electionId)
    {
        $election = Election::with(['departement', 'ufr'])->findOrFail($electionId);
        $results = Resultat::where('election_id', $electionId)
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
