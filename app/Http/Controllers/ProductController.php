<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Product;
use App\Models\UserPurchase;
use App\Models\UserSpeciesUnlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $user = Auth::user();

        return view('product.index', compact('products', 'user'));
    }

    public function show(Product $product)
    {
        $user = Auth::user();
        $hasPurchased = $user->hasPurchased($product);

        return view('product.show', compact('product', 'user', 'hasPurchased'));
    }

    /**
     * Purchase a product with coins / real money / QR
     */
    public function purchase(Request $request, Product $product)
    {
        $user = Auth::user();

        // Prevent double purchase
        if ($user->hasPurchased($product)) {
            return back()->with('error', 'Je hebt dit product al gekocht!');
        }

        DB::beginTransaction();

        try {

            if ($product->canBuyWithCoins()) {
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
            } else {
                // Real money or QR
                UserPurchase::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'purchase_type' => $product->currency_type,
                    'amount_paid' => $product->price,
                ]);
            }

            if ($product->isAnimal()) {

                if (!$product->species_id) {
                    throw new \Exception('Animal product heeft geen species_id');
                }

                // Species unlocken
                UserSpeciesUnlock::firstOrCreate([
                    'user_id' => $user->id,
                    'species_id' => $product->species_id,
                ]);

                // 🐾 ANIMAL AANMAKEN
                Animal::create([
                    'user_id' => $user->id,
                    'name' => $product->species->name,
                    'species_id' => $product->species_id,
                    'hunger' => 100,
                    'happiness' => 100,
                    'cleanliness' => 100,
                    'adopted_at' => now(),
                ]);
            }

            DB::commit();

            return back()->with('success', 'Product succesvol gekocht!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'Er is iets misgegaan bij het kopen: ' . $e->getMessage()
            );
        }
    }
}
