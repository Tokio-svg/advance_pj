@extends('layouts.layout')

@section('title','サンクスページ')

@section('style')
  <link rel="stylesheet" href="{{putSource('/css/thanks_style.css')}}">
@endsection

@section('content')
  <main class="shadow">
    <div class="thanks_wrap">
      <p>会員登録ありがとうございます</p>
      <p><a href="{{ route('login') }}" class="thanks_button">ログインする</a></p>
    </div>
  </main>
@endsection