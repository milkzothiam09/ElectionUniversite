<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Election;
class BulletinController extends Controller
{

        public function store(Request $request, $electionId)
        {
            $request->validate([
                'candidat_id' => 'nullable|exists:candidates,id'
            ]);

            $user = Auth::user();
            $election = Election::findOrFail($electionId);

            $bulletin = $user->voter($election, $request->candidate_id);

            return response()->json($bulletin, 201);
        }

}
