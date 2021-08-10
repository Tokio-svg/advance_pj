@extends('layouts.layout')

@section('title','会員登録ページ')

@section('style')
<link rel="stylesheet" href="{{putSource('/css/auth_style.css')}}">
@endsection

@section('content')
<main>
  <h1 class="card_title">Registration</h1>
  <div class="form_wrap">
    <form method="POST" action="/register">
      @csrf
      <!-- Name -->
      <div>
        <img src="{{putSource('/img/person.png')}}" alt="no image">
        <input id="name" type="text" name="name" value="{{old('name')}}" placeholder="Username" required />
      </div>
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
      <button type="submit">登録</button>
    </form>
  </div>
</main>
@endsection