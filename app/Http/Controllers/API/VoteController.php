<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Election;
use App\Models\Candidat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VoteController extends Controller
{
    public function vote(Request $request, $electionId)
    {
        $user = $request->user();
        $election = Election::findOrFail($electionId);

        // Vérifier que l'élection est en cours
        $now = Carbon::now();
        if ($now < $election->start_date || $now > $election->end_date) {
            return response()->json(['message' => 'L\'élection n\'est pas ouverte encore au vote'], 403);
        }

        // Vérifier que l'utilisateur est éligible pour voter
        if (!$this->isEligibleToVote($user, $election)) {
            return response()->json(['message' => 'Vous n\'êtes pas éligible pour voter à cette élection'], 403);
        }

        // Vérifier que l'utilisateur n'a pas déjà voté
        $voterHash = $this->generateVoterHash($user->id, $electionId);
        $existingVote = Vote::where('voter_hash', $voterHash)->exists();

        if ($existingVote) {
            return response()->json(['message' => 'Vous avez déjà voté pour cette élection'], 400);
        }

        $validator = Validator::make($request->all(), [
            'candidate_id' => 'nullable|exists:candidates,id,election_id,' . $electionId,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Enregistrer le vote
        $vote = Vote::create([
            'election_id' => $electionId,
            'candidat_id' => $request->candidat_id,
            'voter_hash' => $voterHash,
            'is_null' => $request->candidat_id === null,
        ]);

        return response()->json(['message' => 'Vote enregistré avec succès'], 201);
    }

    private function isEligibleToVote($user, $election)
    {
        switch ($election->type) {
            case 'chef_departement':
                return $user->type === 'PER' && $user->departement_id === $election->departement_id;
            case 'directeur_ufr':
                return $user->type === 'PER' && $user->ufr_id === $election->ufr_id;
            case 'vice_recteur':
                return true; // Tous les PER et PATS peuvent voter
            default:
                return false;
        }
    }

    private function generateVoterHash($userId, $electionId)
    {
        return Hash::make($userId . '|' . $electionId . '|' . config('app.key'));
    }
}
