<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Http\Requests\StoreCourRequest;
use App\Http\Requests\UpdateCourRequest;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cour $cour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourRequest $request, Cour $cour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cour $cour)
    {
        //
    }
}
