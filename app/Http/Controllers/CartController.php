<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login.index');
        }
        $products = Auth::user()->products()->get();
        return view('cart.index', ['products' => $products]);
    }

    public function add($productId)
    {
        $relation = Auth::user()->products()->where('product_id', $productId);

        if ($relation->exists()) {
            $oldQuantity = $relation->first(['quantity'])->quantity;

            Auth::user()->products()->updateExistingPivot($productId, 
                ['quantity' => $oldQuantity + 1]
            );

        } else {
            Auth::user()->products()->attach($productId, ['quantity' => 1]);
        }
        return redirect()->route('homepage.index');
    }

    public function remove($productId)
    {
        $relation = Auth::user()->products()->where('product_id', $productId);
        if ($relation->exists()) {
            $oldQuantity = $relation->first(['quantity'])->quantity;

            if ($oldQuantity > 1) {
                Auth::user()->products()->updateExistingPivot($productId, 
                    ['quantity' => $oldQuantity - 1]
                );
            } else {
                $relation->detach();
            }

        }
        return redirect()->route('cart.index');
    }

    public function checkout()
    {
        // get quantity of each product
        $relation = Auth::user()->products()->where('product_id', 1);
        if($relation->exists()){
            dd($relation->get(['quantity'])->first()->quantity);
        }
    }
}
