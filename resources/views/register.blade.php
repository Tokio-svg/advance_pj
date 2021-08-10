@extends('layouts.layout')

@section('title','会員登録ページ')

@section('style')
@endsection

@section('content')
<main style="margin-top: 100px;">
  <h1>Registration</h1>
  <form method="POST" action="/register">
    @csrf
    <!-- Name -->
    <div>
      <input id="name" type="text" name="name" value="{{old('name')}}" placeholder="Username" required />
    </div>

    <!-- Email Address -->
    <div>
      <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" required />
    </div>

    <!-- Password -->
    <div>
      <input id="password" type="password" name="password" placeholder="Password" required />
    </div>

    <!-- Confirm Password -->
    <!-- <div>
      <input id="password_confirmation" type="password" name="password_confirmation" required />
    </div> -->

    <button type="submit">登録</button>
  </form>
</main>
@endsection