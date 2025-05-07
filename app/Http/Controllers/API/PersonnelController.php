<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Election;
use App\Models\Candidat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use App\Enums\PersonnelType; 



class PersonnelController extends Controller
{
    public function index()
    {
        $personnel = Personnel::with(['departement', 'ufr', 'grade'])->get();
        return response()->json($personnel);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personnel',
            'password' => 'required|string|min:8',
            'type' => ['required', new Enum(PersonnelType::class)],
            'grades_id' => 'nullable|exists:grades,id',
            'departements_id' => 'required|exists:departements,id',
            'ufrs_id' => 'required|exists:ufrs,id',
        ]);

        $validated['motDePasse'] = Hash::make($validated['password']);
        unset($validated['password']);

        $personnel = Personnel::create($validated);

        return response()->json($personnel, 201);
    }

    public function show(Personnel $personnel)
    {
        return response()->json($personnel->load(['departement', 'ufr', 'grade']));
    }

    public function update(Request $request, Personnel $personnel)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:personnel,email,'.$personnel->id,
            'password' => 'sometimes|string|min:8',
            'type' => ['sometimes', new Enum(PersonnelType::class)],
            'grades_id' => 'nullable|exists:grades,id',
            'departements_id' => 'sometimes|exists:departements,id',
            'ufrs_id' => 'sometimes|exists:ufrs,id',
        ]);

        if (isset($validated['password'])) {
            $validated['motDePasse'] = Hash::make($validated['password']);
            unset($validated['password']);
        }

        $personnel->update($validated);

        return response()->json($personnel);
    }

    public function destroy(Personnel $personnel)
    {
        $personnel->delete();
        return response()->json(null, 204);
    }

    // Méthodes spécifiques
    public function voter(Request $request, Personnel $personnel)
    {
        $validated = $request->validate([
            'elections_id' => 'required|exists:elections,id',
            'candidats_id' => 'required|exists:candidats,id',
        ]);

        $election = Election::findOrFail($validated['elections_id']);
        $candidat = Candidat::findOrFail($validated['candidats_id']);

        try {
            $personnel->voter($election, $candidat);
            return response()->json(['message' => 'Vote enregistré avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function seCandidater(Request $request, Personnel $personnel)
    {
        $validated = $request->validate([
            'elections_id' => 'required|exists:elections,id',
        ]);

        $election = Election::findOrFail($validated['elections_id']);

        try {
            $personnel->seCandidater($election);
            return response()->json(['message' => 'Candidature enregistrée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function verifierDroitVote(Personnel $personnel, Election $election)
    {
        try {
            // Vérification du droit de vote
            $droitVote = $personnel->verifierDroitVote($election);
            return response()->json(['droit_vote' => $droitVote]);
        } catch (\Exception $e) {
            // Gestion des exceptions

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}