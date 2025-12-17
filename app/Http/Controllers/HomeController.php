<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = Auth::user();

            $animals = $user->animals()
                ->with('species')
                ->orderBy('adopted_at', 'desc')
                ->get();

            return view('animals.index', compact('animals'));
        } else {
            return view('index');
        }

    }
}
