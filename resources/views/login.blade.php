@extends('layouts.layout')

@section('title','ログインページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="card_title">Login</h1>
  <div class="form_wrap">
    <form method="POST" action="/login">
      @csrf
      <!-- Email Address -->
      <div>
        <img src="{{putSource('/img/mail.png')}}" alt="no image">
        <input id="email" type="email" name="email" value="{{old('email')}}" placeholder="Email" required />
      </div>
      <!-- Password -->
      <div>
        <img src="{{putSource('/img/key.png')}}" alt="no image">
        <input id="password" type="password" name="password" placeholder="Password" required />
      </div>
      <button type="submit">ログイン</button>
    </form>
  </div>
</main>
@endsection