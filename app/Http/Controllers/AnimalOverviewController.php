<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalOverviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $animals = $user->animals()
            ->with('species')
            ->orderBy('adopted_at', 'desc')
            ->get();

        return view('animals.index', compact('animals'));
    }
}
