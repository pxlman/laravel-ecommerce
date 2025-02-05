@extends('layouts.app')

@section('content')
<div class="container mx-auto w-50">
    <h1>Login</h1>
    <form action="{{ route('login.login') }}" method="post" class="form-control">
        @csrf
        <input type="email" name="email" placeholder="Email" class="form-control"><br><br>
        <input type="password" name="password" placeholder="Password" class="form-control"><br><br>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
