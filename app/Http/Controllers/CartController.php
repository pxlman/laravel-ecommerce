<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login.index');
        }
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add($productId)
    {
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();
        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            Cart::create(['user_id' => auth()->id(), 'product_id' => $productId, 'quantity' => 1]);
        }
        
        return back();
    }

    public function remove($productId)
    {
        Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();
        
        return back();
    }

    public function decrement($productId)
    {
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();
        if ($cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }
        return back();
    }

    public function checkout()
    {
        // get quantity of each product
        $relation = Auth::user()->products()->where('product_id', 1);
        if($relation->exists()){
            dd($relation->get(['quantity'])->first()->quantity);
        }
    }
    public function fetch(){
        $response = [
            "cart" => Auth::user()->cart()->with('product')->get()->map(function($item) {
                return [
                    "id" => $item->product_id,
                    "quantity" => $item->quantity,
                    "price" => $item->product->price,
                ];

            }),
            "payer_id" => Auth::user()->id,
        ];
        return $response;
    }
}
