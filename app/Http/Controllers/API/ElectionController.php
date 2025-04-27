<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Election;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::with(['departement', 'ufr'])->get();
        return response()->json($elections);
    }

    public function show($id)
    {
        $election = Election::with(['departement', 'ufr', 'candidats.user'])->findOrFail($id);
        return response()->json($election);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:chef_departement,directeur_ufr,vice_recteur',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'candidature_start' => 'required|date|before:start_date',
            'candidature_end' => 'required|date|after:candidature_start|before:start_date',
            'departement_id' => 'required_if:type,chef_departement|exists:departments,id',
            'ufr_id' => 'required_if:type,directeur_ufr|exists:ufrs,id',
        ]);
        

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $election = Election::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'candidature_start' => $request->candidature_start,
            'candidature_end' => $request->candidature_end,
            'status' => 'preparation',
            'department_id' => $request->department_id,
            'ufr_id' => $request->ufr_id,
        ]);

        return response()->json($election, 201);
    }

    public function update(Request $request, $id)
    {
        $election = Election::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'candidature_start' => 'sometimes|date',
            'candidature_end' => 'sometimes|date|after:candidature_start',
            'status' => 'sometimes|in:preparation,candidature,voting,closed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $election->update($request->all());

        return response()->json($election);
    }

    public function destroy($id)
    {
        $election = Election::findOrFail($id);
        $election->delete();

        return response()->json(null, 204);
    }

    public function currentElections()
    {
        $now = Carbon::now();
        $elections = Election::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->with(['departement', 'ufr'])
            ->get();

        return response()->json($elections);
    }

    public function eligibleElections(Request $request)
    {
        $user = $request->user();
        $now = Carbon::now();

        $elections = Election::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function($query) use ($user) {
                $query->whereNull('departement_id')
                    ->orWhere('departement_id', $user->department_id)
                    ->orWhere('ufr_id', $user->ufr_id);
            })
            ->with(['departement', 'ufr'])
            ->get();

        return response()->json($elections);
    }
}