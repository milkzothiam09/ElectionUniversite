<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ElectionController;
use App\Http\Controllers\API\CandidatController;
use App\Http\Controllers\API\VoteController;
use App\Http\Controllers\API\ProcesVerbalController;
use App\Http\Controllers\API\BulletinController;
use App\Http\Controllers\API\ResultatController;
use App\Http\Controllers\API\PersonnelController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userProfile']);

    //  Routes pour  ElectionController
    Route::get('/elections', [ElectionController::class, 'index']);
    Route::get('/elections/{id}', [ElectionController::class, 'show']);
    Route::get('/elections/current', [ElectionController::class, 'currentElections']);
    Route::get('/elections/eligible', [ElectionController::class, 'eligibleElections']);


    // Routes pour BulletinController
    Route::post('/elections/{electionId}/bulletins', [BulletinController::class, 'store']);


    // Routes pour CandidatController
    Route::get('/elections/{electionId}/candidates', [CandidatController::class, 'index']);
    Route::post('/elections/{electionId}/candidates', [CandidatController::class, 'store']);

     // Routes pour PersonnelController
    Route::get('/personnels', [PersonnelController::class, 'index']);
    Route::post('/personnels', [PersonnelController::class, 'store']);
    Route::get('/personnels/{personnel}', [PersonnelController::class, 'show']);
    Route::put('/personnels/{personnel}', [PersonnelController::class, 'update']);
    Route::delete('/personnels/{personnel}', [PersonnelController::class, 'destroy']);

     // Routes personnalisées pour PersonnelController
    Route::post('/personnels/{personnel}/voter', [PersonnelController::class, 'voter']);
    Route::post('/personnels/{personnel}/se-candidater', [PersonnelController::class, 'seCandidater']);
    Route::get('/personnels/{personnel}/verifier-droit-vote/{election}', [PersonnelController::class, 'verifierDroitVote']);

    //Routes pour  VoteController
    Route::post('/elections/{electionId}/vote', [VoteController::class, 'vote']);

    // Routes pour ResultatController
    Route::get('/elections/{electionId}/results', [ResultatController::class, 'getResults']);

    // Routes pour Procès-verbalController
    Route::post('/elections/{election}/generate-pv', [ProcesVerbalController::class, 'generer']);
    Route::get('/proces-verbaux/{id}/download', [ProcesVerbalController::class, 'telecharger']);

    // Admin routes
    Route::middleware('can:manage-election')->group(function () {

        Route::post('/elections', [ElectionController::class, 'store']);
        Route::put('/elections/{id}', [ElectionController::class, 'update']);
        Route::delete('/elections/{id}', [ElectionController::class, 'destroy']);

        Route::put('/candidates/{candidateId}/status', [CandidatController::class, 'updateStatus']);
        Route::delete('/candidates/{candidateId}', [CandidatController::class, 'destroy']);

        Route::post('/elections/{electionId}/calculate-results', [ResultatController::class, 'calculateResults']);
        Route::get('/elections/{electionId}/pv', [ResultatController::class, 'generatePV']);
    });


});
