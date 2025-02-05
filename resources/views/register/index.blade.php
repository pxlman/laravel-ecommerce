@extends('layouts.app') 

@section('content')
<div class="container mx-auto w-50">
    <h1>Register</h1>
    <form action="{{ route('register.register') }}" method="post" class="form-control">
        @csrf
        <input type="text" class="form-control" name="name" placeholder="Name"><br><br>
        <input type="email" class="form-control" name="email" placeholder="Email"><br><br>
        <input type="password" class="form-control" name="password" placeholder="Password"><br><br>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection