<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Election;
use Illuminate\Support\Facades\Validator;

class CandidatController extends Controller
{
    public function index($electionId)
    {
        $candidates = Candidat::where('election_id', $electionId)
            ->with(['user', 'user.grade', 'user.department'])
            ->get();

        return response()->json($candidates);
    }

    public function store(Request $request, $electionId)
    {
        $user = $request->user();
        $election = Election::findOrFail($electionId);

        // Vérifier que l'utilisateur est PER
        if ($user->type !== 'PER') {
            return response()->json(['message' => 'Seuls les PER peuvent candidater'], 403);
        }

        // Vérifier que la période de candidature est ouverte
        $now = now();
        if ($now < $election->candidature_start || $now > $election->candidature_end) {
            return response()->json(['message' => 'La période de candidature est fermée'], 403);
        }

        // Vérifier que l'utilisateur est éligible pour cette élection
        if ($election->type === 'chef_departement' && $user->departement_id !== $election->department_id) {
            return response()->json(['message' => 'Vous n\'appartenez pas à ce département'], 403);
        }

        if ($election->type === 'directeur_ufr' && $user->ufr_id !== $election->ufr_id) {
            return response()->json(['message' => 'Vous n\'appartenez pas à cette UFR'], 403);
        }

        // Vérifier que l'utilisateur n'a pas déjà candidaté
        $existingCandidate = Candidat::where('user_id', $user->id)
            ->where('election_id', $electionId)
            ->first();

        if ($existingCandidate) {
            return response()->json(['message' => 'Vous avez déjà candidaté à cette élection'], 400);
        }

        $validator = Validator::make($request->all(), [
            'motivation' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $candidate = Candidat::create([
            'user_id' => $user->id,
            'election_id' => $electionId,
            'status' => 'pending',
            'motivation' => $request->motivation,
        ]);

        return response()->json($candidate, 201);
    }

    public function updateStatus(Request $request, $candidateId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $candidate = Candidat::findOrFail($candidateId);
        $candidate->update(['status' => $request->status]);

        return response()->json($candidate);
    }

    public function destroy($candidateId)
    {
        $candidate = Candidat::findOrFail($candidateId);
        $candidate->delete();

        return response()->json(null, 204);
    }
}