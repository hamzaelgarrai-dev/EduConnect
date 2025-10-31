<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


   


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $user = auth()->user();

        // Check permission using Spatie
        if (!$user->hasPermissionTo('list users')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $users = User::with('roles')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasPermissionTo('create user')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,enseignant,etudiant'
        ]);

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign the selected role
        $newUser->assignRole($validated['role']);

        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'data' => $newUser
        ],);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
    $user = auth()->user();

    // Check if the authenticated user has permission
    if (!$user->hasPermissionTo('update user')) {
        return response()->json(['message' => 'Unauthorized'], );
    }

    $userToUpdate = User::findOrFail($id);

    // Validate only name, email, and password
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|unique:users,email,' . $id,
        'password' => 'sometimes|string|min:8',
    ]);

    // Hash password if provided
    if (isset($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    }

    // Update user info
    $userToUpdate->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Utilisateur mis à jour avec succès.',
        'data' => $userToUpdate
    ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if (!$user->hasPermissionTo('delete user')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $userToDelete = User::findOrFail($id);
        $userToDelete->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès.'
        ]);
    }
}
