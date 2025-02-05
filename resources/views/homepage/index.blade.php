@extends('layouts.app')

@section('content')
    <h2 class="text-center">Products</h2>
    <br>
    <div class="d-flex flex-wrap gap-5 mx-3">
        @foreach ($products as $product)
            <div class="card text-dark bg-light border-primary mx-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text text-secondary">{{ $product->price }}$</p>
                    @if (\App\Models\Cart::where('user_id', auth()->id())->where('product_id', $product->id)->exists())
                        <form action="{{ route('cart.remove', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove from Cart</button>
                        </form>
                    @else
                        <form action="{{ route('cart.add', $product->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
