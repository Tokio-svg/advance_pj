@extends('layouts.layout')

@section('title','ログインページ')

@section('style')
@endsection

@section('content')
<main style="margin-top: 100px;">
  <h1>Registration</h1>
  <form method="POST" action="/login">
    @csrf
    <!-- Email Address -->
    <div>
      <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" required />
    </div>

    <!-- Password -->
    <div>
      <input id="password" type="password" name="password" placeholder="Password" required />
    </div>

    <button type="submit">ログイン</button>
  </form>
</main>
@endsection