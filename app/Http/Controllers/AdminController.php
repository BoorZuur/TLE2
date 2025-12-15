<?php

namespace App\Http\Controllers;

use App\Models\Habitat;
use App\Models\Specie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $species = Specie::all();

//        return view('admin.species.index', compact('species'));
        return redirect()->route('admin.species.index')->with('species', $species);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specie = Specie::findOrFail($id);

        $habitats = Habitat::all();

        return view('admin.species.edit', compact('specie', 'habitats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
