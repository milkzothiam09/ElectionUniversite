<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|in:PER,PATS',
            'grades_id' => 'required_if:type,PER|exists:grades,id',
            'departements_id' => 'required|exists:departments,id',
            'ufrs_id' => 'required|exists:ufrs,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'grades_id' => $request->grade_id,
            'departments_id' => $request->department_id,
            'ufrs_id' => $request->ufr_id,
        ]);

        // Assign role based on user type
        $role = $request->type === 'PER' ? 'per' : 'pats';
        $user->assignRole($role);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Identifiants invalides!!!'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    public function userProfile(Request $request)
    {
        $user = $request->user();
        $user->load(['grade', 'departement', 'ufr', 'roles']);

        return response()->json($user);
    }
}
