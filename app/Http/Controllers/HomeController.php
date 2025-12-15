<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $animal = Animal::first();

            return view('home', compact('animal'));
        } else {
            return view('index');
        }

    }
}
