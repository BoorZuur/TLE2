<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserPurchase;
use App\Models\Animal;
use App\Models\UserSpeciesUnlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $user = Auth::user();
        return view('product.index', compact('products', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // alleen admin
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // alleen admin
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $user = Auth::user();
        $hasPurchased = $user->hasPurchased($product);
        return view('product.show', compact('product', 'user', 'hasPurchased'));
    }

    /**
     * Purchase a product with coins or real money
     */
    public function purchase(Request $request, Product $product)
    {
        $user = Auth::user();

        // Check if already purchased
        if ($user->hasPurchased($product)) {
            return back()->with('error', 'Je hebt dit product al gekocht!');
        }

        DB::beginTransaction();
        try {
            if ($product->canBuyWithCoins()) {
                // Purchase with coins
                if ($user->coins < $product->price) {
                    return back()->with('error', 'Je hebt niet genoeg munten!');
                }

                $user->coins -= $product->price;
                $user->save();

                UserPurchase::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'purchase_type' => 'coins',
                    'amount_paid' => $product->price,
                ]);

                // If animal, add to collection
                if ($product->isAnimal()) {
                    Animal::create([
                        'user_id' => $user->id,
                        'name' => $product->name,
                        'happiness' => 100,
                        'hunger' => 50,
                        'cleanliness' => 75,
                        'species_tag' => $product->species_tag,
                        'adopted_at' => now(),
                        'updated_at' => now(),
                    ]);
                    UserSpeciesUnlock::create([
                        'user_id' => $user->id,
                        'species_id' => $product->species_tag,
                    ]);
                }



                // todo: if powerup, add to user's powerups (not implemented yet)

                DB::commit();
                return back()->with('success', 'Product succesvol gekocht met munten!');

            } else {
                // Purchase with money (mock payment)
                $request->validate([
                    'payment_method' => 'required|in:creditcard,ideal,paypal',
                ]);

                // Mock payment processing
                UserPurchase::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'purchase_type' => 'real_money',
                    'amount_paid' => $product->price,
                ]);

                // If animal, add to collection
                if ($product->isAnimal()) {
                    Animal::create([
                        'user_id' => $user->id,
                        'name' => $product->name,
                        'happiness' => 100,
                        'hunger' => 50,
                        'cleanliness' => 75,
                        'species_tag' => $product->species_tag,
                        'adopted_at' => now(),
                        'updated_at' => now(),
                    ]);
                    UserSpeciesUnlock::create([
                        'user_id' => $user->id,
                        'species_id' => $product->species_tag,
                    ]);
                }

                DB::commit();
                return back()->with('success', 'Product succesvol gekocht! Betaling gesimuleerd.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Er is iets misgegaan bij het kopen: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // alleen admin
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // alleen admin
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // alleen admin
    }
}
