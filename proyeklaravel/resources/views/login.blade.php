@extends('layout.main')

@section('title', 'Login')

@section('content')
<section id="login">
  <h2>Login</h2>
  <form action="{{ route('login.process') }}" method="POST">
    @csrf
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Masuk</button>
  </form>
</section>
@endsection
