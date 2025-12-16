<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;
use App\Models\Specie;
use App\Models\UserSpeciesUnlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function collection(Request $request)
    {
        $user = $request->user();
        $region = $request->query('region');

        $query = Specie::with('habitat')->where('status', 1);

        if ($region) {
            $query->whereHas('habitat', fn($q) => $q->where('name', $region));
        }

        $species = $query->get();

        $unlockedIds = $user
            ? UserSpeciesUnlock::where('user_id', $user->id)->pluck('species_id')->toArray()
            : [];

        $result = $species->map(fn($specie) => [
            'vernacularName' => $specie->name,
            'scientificName' => $specie->scientific_name ?? '-',
            'location' => $specie->habitat->name ?? '-',
            'beheerder' => $specie->beheerder ?? '-',
            'image' => $specie->image ?? '/images/placeholder.jpg',
            'locked' => !in_array($specie->id, $unlockedIds),
            'info' => $specie->info ?? '-',
            'id' => $specie->id,
        ]);

        return response()->json($result->values());
    }

    public function create()
    {
        return view('admin.species.create')->with('habitats', Habitat::all());
    }

    public function show(string $id)
    {
        $specie = Specie::where('id', $id)->where('status', true)->firstOrFail();

        $userSpecieCount = Specie::where('user_id', Auth::id())->count();
        return view('collection.animals', compact('specie', 'userSpecieCount'));
    }

    public function dashboard()
    {
        $species = Specie::all();
        return view('admin.species.index', compact('species'));
    }

    public function edit(Specie $specie)
    {
        $user = Auth::user();
        if (!$user || $user->is_admin != 1) {
            return redirect()->route('admin.species.index')->with('error', 'Je moet admin zijn om een dier te bewerken.');
        }

        $habitats = Habitat::all(); //
        return view('admin.species.edit', compact('specie', 'habitats'));
    }

    public function update(Request $request, Specie $specie)
    {
        $request->validate([
            'vernacularName' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'beheerder' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'location' => 'required|exists:habitats,id',
            'image' => 'nullable|image',
        ]);

        $specie->update([
            'name' => $request->vernacularName,
            'scientific_name' => $request->scientific_name,
            'beheerder' => $request->beheerder,
            'info' => $request->info,
            'habitat_id' => $request->location,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/species'), $filename);
            $specie->image = '/images/species/' . $filename;
        }

        $specie->habitat_id = $request->input('location');
        $specie->save();

        $specie->save();


        return redirect()->route('admin.index')->with('success', 'Dier geüpdatet');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vernacularName' => ['required', 'string', 'max:255'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'beheerder' => ['nullable', 'string', 'max:255'],
            'info' => ['nullable', 'string'],
            'location' => ['required', 'exists:habitats,id'],
            'image' => ['nullable', 'image'],
        ]);

        $specie = new Specie();
        $specie->name = $request->input('vernacularName');
        $specie->scientific_name = $request->input('scientific_name');
        $specie->beheerder = $request->input('beheerder');
        $specie->info = $request->input('info');
        $specie->status = 1;
        $specie->habitat_id = $request->input('location');
//        $specie->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/species'), $filename);
            $specie->image = '/images/species/' . $filename;
        } else {
            $specie->image = '/images/placeholder.jpg';
        }

        $specie->save();

        return redirect()->route('admin.index')->with('success', 'Dier toegevoegd');
    }


    public function toggleStatus(Specie $specie)
    {
        $user = Auth::user();
        if ($user->is_admin !== 1 && $specie->user_id !== $user->id) {
            abort(403, 'Ongeldige actie.');
        }

        $specie->status = $specie->status == 1 ? 0 : 1;
        $specie->save();

        return redirect()->back()->with('success', 'Dier status geüpdatet!');
    }
}
