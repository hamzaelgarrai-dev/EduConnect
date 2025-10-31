<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Http\Requests\StoreCourRequest;
use App\Http\Requests\UpdateCourRequest;
use Illuminate\Support\Facades\Auth;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cours = Cour::all();
        return response()->json([
            'success' => true,
            'data' => $cours
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourRequest $request)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $cours = Cour::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => Auth::id(), 
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'data' => $cours
        ], );
    }

    /**
     * Display the specified resource.
     */
    public function show(Cour $cour)
    {
        $cour = Cour::all();
        return response()->json([
            'success' => true,
            'data' => $cour
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourRequest $request  ,$id)
    {
         $cour = Cour::findOrFail($id);

        // Only creator or admin can update
        $user = Auth::user();
        if ($cour->users_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], );
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $cour->update($request->only(['title', 'description']));

        return response()->json([
            
            'message' => 'Course updated successfully',
            'data' => $cour
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $cour = Cour::findOrFail($id);

        $user = Auth::user();
        if ($cour->users_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json([
                'message' => 'Unauthorized'
            ],);
        }

        $cour->delete();

        return response()->json([
            
            'message' => 'Course deleted successfully'
        ]);
    }
}
