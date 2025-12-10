<?php

namespace App\Http\Controllers;

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
}
