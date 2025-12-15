<?php

namespace App\Http\Controllers;

use App\Models\Habitat;
use App\Models\Specie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
    }

    public function addSpecie()
    {
        $this->checkAdmin();
        return view('admin.add-specie');
    }

    public function storeSpecie(Request $request)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'habitat_tag' => 'required|integer|exists:habitats,id',
            'scientific_name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'beheerder' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'locked' => 'required|boolean',
        ]);

        Specie::create($data);

        return redirect()->route('admin.addSpecie')->with('success', 'Species added!');
    }
  
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
