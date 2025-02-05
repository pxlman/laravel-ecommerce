@extends('layouts.app') 

@section('content')
<div>
    <h1>Cart</h1>
    <div class="d-flex flex-wrap gap-5 mx-3">
        @foreach ($cartItems as $cartItem)
            <div class="card text-dark bg-light border-primary mx-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $cartItem->product->name }}</h5>
                    <p class="card-text">{{ $cartItem->product->description }}</p>
                    <p class="card-text text-secondary">{{ $cartItem->product->price }}$</p>
                    <p class="card-text text-secondary">Quantity: {{ $cartItem->quantity }}</p>
                    <form action="{{ route('cart.remove', $cartItem->product_id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                </div>
            </div>
        @endforeach
        <p class="card-text text-secondary">{{ Auth::user()->totalCartPrice() }}$</p>
    </div>
</div>
@endsection
