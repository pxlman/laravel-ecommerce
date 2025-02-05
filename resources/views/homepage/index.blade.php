@extends('layouts.app')

@section('content')
    <h2>Products</h2>
    <br>
    <div class="d-flex flex-wrap gap-5 mx-3">
        @foreach ($products as $product)
            <div class="card text-dark bg-light border-primary mx-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text text-secondary">{{ $product->price }}$</p>
                    {{-- <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Add to Cart</a> --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
