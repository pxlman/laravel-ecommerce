@extends('layouts.app') 

@section('content')
<h1 class="text-center">Cart</h1>
<div class="d-flex flex-row align-items-center">
    <div class="d-flex flex-wrap mx-3" style="max-width: 80%">
        @foreach ($cartItems as $cartItem)
            <div class="card text-dark bg-light border-primary m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $cartItem->product->name }}</h5>
                    <p class="card-text">{{ $cartItem->product->description }}</p>
                    <p class="card-text text-secondary">{{ $cartItem->product->price }}$</p>
                    <p class="card-text text-success">Quantity: {{ $cartItem->quantity }}</p>
                    <div class="d-flex gap-2 justify-content-between">  
                        <div class="d-flex gap-2">
                            <form action="{{ route('cart.add', $cartItem->product_id) }}" class="d-inline" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">+</button>
                            </form>
                            <form action="{{ route('cart.decrement', $cartItem->product_id) }}" class="d-inline" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"></button>
                            </form>
                        </div>
                        <form action="{{ route('cart.remove', $cartItem->product_id) }}" class="d-inline" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card bg-light border-primary p-3 ms-auto mx-2" style="width: 25rem; align-self:flex-end;">
        <h5 class="card-title">Cart Total</h5>
        <div class="d-flex align-items-center gap-2">
            <span class="h4 mb-0">Total:</span>
            <span class="h4 mb-0 text-primary">{{ Auth::user()->totalCartPrice() }}$</span>
        </div>
</div>
</div>
@endsection
